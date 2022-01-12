<?php 

namespace App\EventSubscriber;

use App\Event\PurchaseSuccessEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PurchaseSuccessEmailSubscriber implements EventSubscriberInterface
{

    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    // Exprime la configuration
    public static function getSubscribedEvents()
    {
        // Je dis à mon Subscriber de se bancher sur l'Event 'purchase.event' et d'effectuer l'action que je lui ai lié
        return [
            'purchase.success' => 'sendSuccessEmail'
        ];
    }

    public function sendSuccessEmail(PurchaseSuccessEvent $purchaseSuccesEvent)
    {
        $this->logger->info("Email envoyé pour la commande n°" . $purchaseSuccesEvent->getPurchase()->getId() );
    }

}