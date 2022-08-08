<?php

namespace App\Controller;

use App\Entity\BasketPosition;
use App\Entity\Catalog;
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

    #[Route('/plant/{id}', name: 'plant')]
    public function index(Request $request,
                          RentBedsRepository $repository,
                          Security $security,
                          $id  ): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $sessionId = $request->getSession()->getId();
        $username = $security->getUser()?->getUserIdentifier();
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);
        $paginator = $repository->getBedsPaginatorForUser($offset, $user);
        $plantID = $id;
        $plants =  $this->entityManager->getRepository(Plant::class)->findBy(['users' => $user]);


        return new Response($this->render('plant/index.html.twig', [
            'plantID' => $plantID,
            'catalogs' => $paginator,
            'plants' => $plants,
            'errorMess' => null,
            'session' => $sessionId ,
            'previous' => $offset - RentBedsRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + RentBedsRepository::PAGINATOR_PER_PAGE),
        ]));

    }

    #[Route('/plant/{id}/{plantID}', name: 'planted')]
    public function show(RentBeds $beds,
                         $id,
                         $plantID,
                         Request $request,
                         RentBedsRepository $repository,
                         Security $security): RedirectResponse
    {
        $plant =  $this->entityManager->getRepository(Plant::class)->findOneBy(['id' => $plantID]);
        $bed = $this->entityManager->getRepository(RentBeds::class)->findOneBy(['id' => $id]);
        $catalogID = $plant->getCatalog() ?? null;
        $catalog = $this->entityManager->getRepository(Catalog::class)->findOneBy(['id' => $catalogID]);
        $square = $catalog->getSquare() ?? 0;
        $freSquare = $bed->getFreeSquare() ?? 0;
        $tottalFreeSquare = $freSquare - $square;
        if ($tottalFreeSquare >= 0) {
            $plant->setBed($bed);
            $bed->setFreeSquare($tottalFreeSquare);
            $this->entityManager->persist($plant);
            $this->entityManager->persist($bed);
            $this->entityManager->flush();
            return $this->redirectToRoute('cabinet', []);
        }
        else {
            $offset = max(0, $request->query->getInt('offset', 0));
            $sessionId = $request->getSession()->getId();
            $username = $security->getUser()?->getUserIdentifier();
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);
            $paginator = $repository->getBedsPaginatorForUser($offset, $user);
            $plantID = $id;
            $plants =  $this->entityManager->getRepository(Plant::class)->findBy(['users' => $user]);


            return new RedirectResponse($this->render('plant/index.html.twig', [
                'plantID' => $plantID,
                'catalogs' => $paginator,
                'plants' => $plants,
                'errorMess' => 'there is not enough space on the bed ' . $id,
                'session' => $sessionId ,
                'previous' => $offset - RentBedsRepository::PAGINATOR_PER_PAGE,
                'next' => min(count($paginator), $offset + RentBedsRepository::PAGINATOR_PER_PAGE),
            ]));

        }
    }


}