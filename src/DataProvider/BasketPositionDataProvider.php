<?php


namespace App\DataProvider;


use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\BasketPosition;
use App\Repository\BasketPositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class BasketPositionDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $entityManager;
    private $basketPositionRepository;
    private $token;
    private $user;

    public function __construct(EntityManagerInterface $entityManager, BasketPositionRepository $basketPositionRepository,TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->basketPositionRepository = $basketPositionRepository;
        $this->token=$tokenStorage->getToken();

    }
    /**
     * @param array<string, mixed> $context
     *
     * @throws \RuntimeException
     *
     * @return iterable<BasketPosition>
     */
    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        try {
            if ($this->token) {
                $this->user = $this->token->getUser()->getUserIdentifier();
             }
            $collection = $this->basketPositionRepository->findBy(['sessionID' => $this->user, 'orderN' => null ]);
        } catch (\Exception $e) {
            throw new \RuntimeException(sprintf('Unable to retrieve basket from external source: %s', $e->getMessage()));
        }
            return $collection;

    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return BasketPosition::class === $resourceClass;
    }
}