<?php

namespace App\Controller;

use App\Entity\BasketPosition;
use App\Entity\RentBeds;
use App\Entity\User;
use App\Form\BasketPositionEmptyFormType;
use App\Form\BasketPositionFormType;
use App\Repository\RentBedsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CabinetController extends AbstractController
{
    private EntityManagerInterface $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/cabinet', name: 'cabinet')]
    public function index(Request $request,
                          RentBedsRepository $repository,
                          Security $security): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $sessionId = $request->getSession()->getId();
        $username = $security->getUser()?->getUserIdentifier();
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);
        $paginator = $repository->getBedsPaginatorForUser($offset, $user);


        return new Response($this->render('cabinet/index.html.twig', [
            'catalogs' => $paginator,
            'session' => $sessionId ,
            'previous' => $offset - RentBedsRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + RentBedsRepository::PAGINATOR_PER_PAGE),
        ]));

    }

    #[Route('/cabinet/{id}', name: 'itemcabinet')]
    public function show(Request $request, RentBeds $beds): Response
    {
        $sessionId = $request->getSession()->getId();
        $basketPosition = new BasketPosition();
        $form = $this->createForm(BasketPositionEmptyFormType::class, $basketPosition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('cabinet');
        }


        return new Response($this->render('cabinet/show.html.twig', [
            'catalog_unit' => $beds,
            'session' => $sessionId,
//            'totalPrice' => $basketCalculator->getBasketPrice($sessionId),
//            'totalQuantity' =>  $basketCalculator->getBasketQuantity($sessionId),
//            'ingridients' => $catalog->getIngr(),
            'add_basket_form' => $form->createView(),
        ]));
    }

}
