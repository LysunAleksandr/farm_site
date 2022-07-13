<?php

namespace App\Controller;

use App\Repository\RentBedsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
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

            return new Response($this->twig->render('beds\index.html.twig', [
                'catalogs' => $paginator,
                'session' => $sessionId ,
                'previous' => $offset - RentBedsRepository::PAGINATOR_PER_PAGE,
                'next' => min(count($paginator), $offset + RentBedsRepository::PAGINATOR_PER_PAGE),
            ]));

    }
}
