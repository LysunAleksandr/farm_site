<?php


namespace App\EntityListener;
use App\Entity\ClientContact;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class OrderEntityListener
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function prePersist(Order $order, LifecycleEventArgs $event)
    {

    }

    public function preUpdate(Order $order, LifecycleEventArgs $event)
    {

    }
}