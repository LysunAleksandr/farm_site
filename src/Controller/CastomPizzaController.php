<?php

namespace App\Controller;

use App\Entity\BasketPosition;
use App\Entity\Catalog;
use App\Entity\Order;
use App\Form\BasketPositionFormType;
use App\Form\CastomPizzaFormType;
use App\Service\BasketCalcInterface;
use App\Service\CustomMakerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class CastomPizzaController extends AbstractController
{
    private $entityManager;


    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/castom', name: 'castom_pizza')]
    public function index(Request $request, BasketCalcInterface $basketCalculator, CustomMakerInterface $customMakerInterface ): Response
    {
        $sessionId = $request->getSession()->getId();
        $validateError = '';
        $catalog = new Catalog();
        $form = $this->createForm(CastomPizzaFormType::class, $catalog);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $quantity = $form->get('Quantity')->getData();
                $basketPosition = $customMakerInterface->getBasketCastom($catalog,$sessionId,$quantity);
                $this->entityManager->persist($basketPosition);
                $this->entityManager->flush();

                return $this->redirectToRoute('homepage');

            }
            catch ( \Exception $e) {
                $validateError = $e->getMessage(); //   'Error : input fields cannot be empty ';
            }

        }


        return $this->render('castom_pizza/index.html.twig', [
            'controller_name' => 'CastomPizzaController',
            'add_form' => $form->createView(),
            'validate_error' => $validateError
        ]);
    }
}
