<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngridientController extends AbstractController
{
    #[Route('/ingridient', name: 'ingridient')]
    public function index(): Response
    {
        return $this->render('ingridient/index.html.twig', [
            'controller_name' => 'IngridientController',
        ]);
    }
}
