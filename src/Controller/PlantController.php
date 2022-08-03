<?php

namespace App\Controller;

use App\Entity\BasketPosition;
use App\Entity\Plant;
use App\Entity\RentBeds;
use App\Entity\User;
use App\Form\BasketPositionEmptyFormType;
use App\Repository\RentBedsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PlantController extends AbstractController
{
    private EntityManagerInterface $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/plant', name: 'plant')]
    public function index(Request $request,
                          RentBedsRepository $repository,
                          Security $security): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $sessionId = $request->getSession()->getId();
        $username = $security->getUser()?->getUserIdentifier();
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);
        $paginator = $repository->getBedsPaginatorForUser($offset, $user);

        $plants =  $this->entityManager->getRepository(Plant::class)->findBy(['users' => $user]);


        return new Response($this->render('plant/index.html.twig', [
            'catalogs' => $paginator,
            'plants' => $plants,
            'session' => $sessionId ,
            'previous' => $offset - RentBedsRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + RentBedsRepository::PAGINATOR_PER_PAGE),
        ]));

    }

    #[Route('/plant/{id}', name: 'planted')]
    public function show(RentBeds $beds,
                         $id,
                         Security $security): RedirectResponse
    {






        return $this->redirectToRoute('cabinet', [] );
    }


}