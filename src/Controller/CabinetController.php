<?php

namespace App\Controller;

use App\Repository\RentBedsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CabinetController extends AbstractController
{
    #[Route('/cabinet', name: 'cabinet')]
    public function index(Request $request,RentBedsRepository $repository): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $sessionId = $request->getSession()->getId();
        $user = $request->getUser();
        $paginator = $repository->getBedsPaginatorForUser($offset);


        return new Response($this->render('cabinet/index.html.twig', [
            'catalogs' => $paginator,
            'session' => $sessionId ,
            'previous' => $offset - RentBedsRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + RentBedsRepository::PAGINATOR_PER_PAGE),
        ]));

    }
}
