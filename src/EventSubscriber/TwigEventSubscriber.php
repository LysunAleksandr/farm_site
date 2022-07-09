<?php

namespace App\EventSubscriber;

use App\Repository\BasketPositionRepository;
use App\Service\BasketCalcInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $basketCalculator;


    public function onControllerEvent(ControllerEvent $event)
    {
        $sessionId = $event->getRequest()->getSession()->getId();
        $this->twig->addGlobal('totalPrice', $this->basketCalculator->getBasketPrice($sessionId));
        $this->twig->addGlobal('totalQuantity', $this->basketCalculator->getBasketQuantity($sessionId));
    }

    public function __construct(Environment $twig, BasketCalcInterface $basketCalculator)
    {
        $this->twig = $twig;
        $this->basketCalculator = $basketCalculator;

    }

    public static function getSubscribedEvents()
    {
        return [
            ControllerEvent::class => 'onControllerEvent',
        ];
    }
}
