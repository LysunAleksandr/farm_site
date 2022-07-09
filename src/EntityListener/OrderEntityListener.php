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
        $telephone = $order->getTelehhone();
        $client = $this->entityManager->getRepository(ClientContact::class)->findOneBy(['telephone' => $telephone] );
        if (!$client) {
            $clientContact = new ClientContact();
            $clientContact->setTelephone($order->getTelehhone());
            $clientContact->setName($order->getUsername());
            $clientContact->setAdress($order->getAdress());
            $this->entityManager->persist($clientContact);
            $order->setClientContact($clientContact);
 //           $this->entityManager->flush();
        }
        else {
            $order->setClientContact($client);
        }
    }

    public function preUpdate(Order $order, LifecycleEventArgs $event)
    {

    }
}