<?php


namespace App\MessageHandler;


use App\Message\OrderMessage;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class OrderMessageHandler implements MessageHandlerInterface
{
    private $entityManager;
    private $orderRepository;
    private $mailer;
    private $adminEmail;

    public function __construct(EntityManagerInterface $entityManager,  OrderRepository $orderRepository, MessageBusInterface $bus,  MailerInterface $mailer, string $adminEmail)
    {
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;

    }
    public function __invoke(OrderMessage $message)
    {
     // this is a imitation send e-mail
/*
        $this->mailer->send((new NotificationEmail())
                            ->subject('New order successfully accepted')
                        ->htmlTemplate('emails/order_notification.html.twig')
                    ->from($this->adminEmail)
                    ->to($this->adminEmail)

                );
*/
    }
}