<?php 

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use App\Event\PurchaseSuccessEvent;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class PurchaseSuccessInstituteEmailSubscriber implements EventSubscriberInterface
{

    protected $logger;
    protected $mailer;
    protected $security;

    public function __construct(LoggerInterface $logger, MailerInterface $mailer, Security $security)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->security = $security;
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
        /** @var User */
        $currentUser = $this->security->getUser();

         /** @var Purchase */
        $purchase = $purchaseSuccesEvent->getPurchase();

        // Créer l'email pour le customer
        $adminEmail = new TemplatedEmail();
        $adminEmail
            ->from(new Address("no-reply@aureliefabre.com", "Commande site web")) // Objet Address avec mail et nom
            ->to(new Address('contact@aureliefabre.com', "Institut Aurélie Fabre"))
            // ->text("La commande n°" . $purchase->getId() . " vient d'être validée")
            
            // Nom du 'template' twig
            ->htmlTemplate('emails/purchase_institute_confirmation.html.twig')   

            // Tableau associatif de variables à lui passer 
            ->context([
                'user' => $currentUser,
                'purchase' => $purchase
            ])

            ->subject("Nouvelle commande d'un montant de " . $purchase->getTotal()/100 . "€");

        $this->mailer->send($adminEmail);

    }

}