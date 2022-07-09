<?php

namespace App\Controller;

use App\Entity\BasketPosition;
use App\Entity\Catalog;
use App\Repository\BasketPositionRepository;
use App\Service\BasketCalcInterface;
use App\Service\BasketCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class BasketPositionController extends AbstractController
{
    private $twig;
    private $entityManager;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    #[Route('/cart', name: 'cart')]
    public function index(Request $request, BasketPositionRepository $basketPosition, BasketCalcInterface $basketCalculator): Response
    {
        $sessionId = $request->getSession()->getId();
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $basketPosition->getBasketPaginator($offset, $sessionId);

        return new Response($this->twig->render('cart/index.html.twig', [
            'basket_positions' => $paginator,
            'session' => $sessionId,
            'totalPrice' => $basketCalculator->getBasketPrice($sessionId),
            'totalQuantity' =>  $basketCalculator->getBasketQuantity($sessionId),
            'previous' => $offset - BasketPositionRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + BasketPositionRepository::PAGINATOR_PER_PAGE),
        ]));

    }
    #[Route('/remove/{id}', name: 'remove')]
    public function removeBasketPosition( BasketPosition $basketPosition): Response
    {
        $this->entityManager->remove($basketPosition);
        $this->entityManager->flush();
        return $this->redirectToRoute('basket');

    }
}
