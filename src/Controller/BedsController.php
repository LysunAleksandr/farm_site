<?php

namespace App\Controller;

use App\Entity\BasketPosition;
use App\Entity\Catalog;
use App\Entity\RentBeds;
use App\Form\BasketPositionEmptyFormType;
use App\Form\BasketPositionFormType;
use App\Form\RentBedsType;
use App\Repository\RentBedsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class BedsController extends AbstractController
{
    private $twig;
    private $entityManager;


    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    #[Route('/beds', name: 'beds')]
    public function index(Request $request,RentBedsRepository $repository): Response
    {
            $offset = max(0, $request->query->getInt('offset', 0));
            $sessionId = $request->getSession()->getId();
            $paginator = $repository->getCatalogPaginator($offset);

            return new Response($this->render('beds\index.html.twig', [
                'catalogs' => $paginator,
                'session' => $sessionId ,
                'previous' => $offset - RentBedsRepository::PAGINATOR_PER_PAGE,
                'next' => min(count($paginator), $offset + RentBedsRepository::PAGINATOR_PER_PAGE),
            ]));

    }

    #[Route('/beds/{id}', name: 'itembeds')]
    public function show(Request $request, RentBeds $beds): Response
    {
        $sessionId = $request->getSession()->getId();
        $basketPosition = new BasketPosition();
        $form = $this->createForm(BasketPositionEmptyFormType::class, $basketPosition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $basketPosition->setQuantity(1);
            $basketPosition->setSessionID($sessionId);
            $basketPosition->setTitle($beds->getTitle());
            $basketPosition->setPrice($beds->getPrice());
            $basketPosition->setBeds($beds);
            $this->entityManager->persist($basketPosition);
            $this->entityManager->flush();

            return $this->redirectToRoute('homepage');
        }


        return new Response($this->render('beds/show.html.twig', [
            'catalog_unit' => $beds,
            'session' => $sessionId,
//            'totalPrice' => $basketCalculator->getBasketPrice($sessionId),
//            'totalQuantity' =>  $basketCalculator->getBasketQuantity($sessionId),
//            'ingridients' => $catalog->getIngr(),
            'add_basket_form' => $form->createView(),
        ]));
    }
}
