<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\BasketPosition;
use App\Repository\BasketPositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class BasketPositionDataPersister implements DataPersisterInterface
{
    private $entityManager;
    private $basketPositionRepository;
    private $user;


    public function __construct(EntityManagerInterface $entityManager, BasketPositionRepository $basketPositionRepository, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->basketPositionRepository = $basketPositionRepository;
        $this->user = $tokenStorage->getToken()->getUser()->getUserIdentifier();

    }

    public function supports($data): bool
    {
        return $data instanceof BasketPosition;
    }
    /**
     * @param BasketPosition $data
     */
    public function persist($data)
    {
        $data->setSessionID($this->user);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}