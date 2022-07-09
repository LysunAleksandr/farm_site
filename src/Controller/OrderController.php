<?php

namespace App\Controller;

use App\Entity\BasketPosition;
use App\Entity\Catalog;
use App\Entity\ClientContact;
use App\Entity\Order;
use App\Form\BasketPositionFormType;
use App\Form\OrderFormType;
use App\Message\OrderMessage;
use App\Repository\BasketPositionRepository;
use App\Service\BasketCalcInterface;
use App\Service\BasketCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class OrderController extends AbstractController
{
    private $twig;
    private $entityManager;
    private $bus;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager, MessageBusInterface $bus)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
        $this->bus = $bus;
    }

    #[Route('/order', name: 'order')]
    public function index(Request $request, BasketPositionRepository $basketPositionRepository, BasketCalcInterface $basketCalculator, SessionInterface $sessionInterface): Response

     {
         $sessionId = $request->getSession()->getId();
         $offset = max(0, $request->query->getInt('offset', 0));

         $order = new Order();
         $order->setSessionID($sessionId);
         $form = $this->createForm(OrderFormType::class, $order);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $order->setCreatedAtValue();

             $basketPositions = $basketPositionRepository->findBy(['sessionID' => $sessionId ]);
             foreach ($basketPositions  as $basketPosition) {
                 $order->addBasketposition($basketPosition);
             }

             $this->entityManager->persist($order);
             $this->entityManager->flush();

             $context = [
                 'username' => $order->getUsername(),
                 'phone' => $order->getTelehhone(),
                 'adres' => $order->getAdress(),
             ];
             $this->bus->dispatch(new OrderMessage($order->getId(), $context));

             $telephone = $order->getTelehhone();
             $sessionInterface->invalidate();
             return $this->redirectToRoute('ordered', ['id' =>  $order->getId()]);
         }


         $paginator = $basketPositionRepository->getBasketPaginator($offset, $sessionId);

         return new Response($this->twig->render('order/index.html.twig', [
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
        return new Response($this->twig->render('order/show.html.twig', [
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

}
