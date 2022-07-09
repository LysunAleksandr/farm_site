<?php


namespace App\DataPersister;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Order;
use App\Exception\BasketPositionNotFoundException;
use App\Repository\BasketPositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class OrderDataPersister implements DataPersisterInterface
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
        return $data instanceof Order;
    }
    /**
     * @param Order $data
     */
    public function persist($data)
    {
        $data->setSessionID($this->user);
        $basketPositions = $this->basketPositionRepository->findBy(['sessionID' => $this->user, 'orderN' => null ]);
        if ($basketPositions){
            foreach ($basketPositions  as $basketPosition) {
                $data->addBasketposition($basketPosition);
            }
            $data->setCreatedAtValue();
            $this->entityManager->persist($data);
            $this->entityManager->flush();
        }
        else {
            throw new BasketPositionNotFoundException('Basket is empty');
         }
    }

    public function remove($data)
    {
        $basketPositions = $data->getBasketposition();
        if ($basketPositions) {
            foreach ($basketPositions  as $basketPosition) {
                $data->removeBasketposition($basketPosition);
            }
        }
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}