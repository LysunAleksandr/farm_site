<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrderDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $entityManager;
    private $orderRepository;
    private $token;
    private $user;

    public function __construct(EntityManagerInterface $entityManager, OrderRepository $orderRepository,TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
        $this->token=$tokenStorage->getToken();
    }

    /**
     * @param array<string, mixed> $context
     *
     * @throws \RuntimeException
     *
     * @return iterable<Order>
     */
    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        try {
            if ($this->token) {
                $this->user = $this->token->getUser()->getUserIdentifier();
            }
            $collection = $this->orderRepository->findBy(['sessionID' => $this->user ]);
        } catch (\Exception $e) {
            throw new \RuntimeException(sprintf('Unable to retrieve orders from external source: %s', $e->getMessage()));
        }


        return $collection;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Order::class === $resourceClass;
    }
}