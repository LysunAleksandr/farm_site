<?php

namespace App\Controller;


use App\Entity\Order;
use App\Entity\RentBeds;
use App\Entity\User;
use App\Form\OrderFormType;
use App\Repository\BasketPositionRepository;
use App\Service\BasketCalcInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class OrderController extends AbstractController
{
    private EntityManagerInterface $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/order', name: 'order')]
    public function index(Request $request,
                          BasketPositionRepository $basketPositionRepository,
                          BasketCalcInterface $basketCalculator,
                          SessionInterface $sessionInterface,
                          Security $security
    ): Response

     {
         $sessionId = $request->getSession()->getId();
         $username = $security->getUser()->getUserIdentifier();
         $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);
         $offset = max(0, $request->query->getInt('offset', 0));

         $order = new Order();
         $order->setSessionID($sessionId);
         $form = $this->createForm(OrderFormType::class, $order);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $order->setCreatedAtValue();
             $order->setUsername($sessionId);
             $order->setUsers($user);

             $basketPositions = $basketPositionRepository->findBy(['sessionID' => $sessionId ]);
             foreach ($basketPositions  as $basketPosition) {
                 $order->addBasketposition($basketPosition);
                 /**
                  * @param RentBeds $bed
                  */
                 foreach ($basketPosition->getBeds() as $bed) {
                     $bed->setRenter($user);
                 }
             }

             $this->entityManager->persist($order);
             $this->entityManager->flush();

             $sessionInterface->invalidate();
             return $this->redirectToRoute('cabinet', ['id' =>  $order->getId()]);
         }


         $paginator = $basketPositionRepository->getBasketPaginator($offset, $sessionId);

         return new Response($this->render('order/index.html.twig', [
             'basket_positions' => $paginator,
             'session' => $sessionId,
             'totalPrice' => $basketCalculator->getBasketPrice($sessionId),
             'totalQuantity' =>  $basketCalculator->getBasketQuantity($sessionId),
             'previous' => $offset - BasketPositionRepository::PAGINATOR_PER_PAGE,
             'next' => min(count($paginator), $offset + BasketPositionRepository::PAGINATOR_PER_PAGE),
             'add_order_form' => $form->createView(),
         ]));

     }

    #[Route('/ordered/{id}', name: 'ordered')]
    public function show(Request $request, Order $order, BasketPositionRepository $basketPositionRepository, BasketCalcInterface $basketCalculator): Response
    {

        $sessionId = $order->getSessionID();
        $offset = max(0, $request->query->getInt('offset', 0));

        $paginator = $basketPositionRepository->getBasketPaginator($offset, $sessionId);
        return new Response($this->render('order/show.html.twig', [
            'basket_positions' => $paginator,
            'order' => $order,
            'username' => $order->getUsername(),
            'delivery_adress' => $order->getAdress(),
            'telephone' => $order->getTelehhone(),
            'session' => $sessionId,
            'totalPrice' => $basketCalculator->getBasketPrice($sessionId),
            'totalQuantity' =>  $basketCalculator->getBasketQuantity($sessionId),
            'previous' => $offset - BasketPositionRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + BasketPositionRepository::PAGINATOR_PER_PAGE),
        ]));
    }

    #[Route('/orders', name: 'orders')]
    public function orders(Request $request, BasketPositionRepository $basketPositionRepository, BasketCalcInterface $basketCalculator, SessionInterface $sessionInterface): Response

    {
        $sessionId = $request->getSession()->getId();
        $offset = max(0, $request->query->getInt('offset', 0));

        $paginator = $basketPositionRepository->getBasketPaginator($offset, $sessionId);

        return new Response($this->render('order/index.html.twig', [
            'basket_positions' => $paginator,
            'session' => $sessionId,
            'totalPrice' => $basketCalculator->getBasketPrice($sessionId),
            'totalQuantity' =>  $basketCalculator->getBasketQuantity($sessionId),
            'previous' => $offset - BasketPositionRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + BasketPositionRepository::PAGINATOR_PER_PAGE),
        ]));

    }
}
