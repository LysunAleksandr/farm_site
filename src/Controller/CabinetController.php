<?php

namespace App\Controller;

use App\Entity\BasketPosition;
use App\Entity\RentBeds;
use App\Entity\User;
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

    #[Route('/cabinet/{id}', name: 'itembedscabinet')]
    public function show(Request $request, RentBeds $beds): Response
    {
        $sessionId = $request->getSession()->getId();
        $basketPosition = new BasketPosition();
        $form = $this->createForm(BasketPositionFormType::class, $basketPosition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
