<?php 

namespace App\EventSubscriber;

use Knp\Snappy\Pdf;
use Psr\Log\LoggerInterface;
use App\Event\PurchaseSuccessEvent;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PurchaseSuccessPdfSubscriber implements EventSubscriberInterface
{

    protected $logger;
    protected $security;
    protected $pdf;

    public function __construct(LoggerInterface $logger, Security $security, Pdf $pdf)
    {
        $this->logger = $logger;
        $this->pdf = $pdf;
        $this->security = $security;
    }

    // Exprime la configuration
    public static function getSubscribedEvents()
    {
        // Je dis à mon Subscriber de se bancher sur l'Event 'purchase.event' et d'effectuer l'action que je lui ai lié
        return [
            'purchase.success' => 'editPdf'
        ];
    }

    public function editPdf(PurchaseSuccessEvent $purchaseSuccesEvent)
    {
        /** @var User */
        $currentUser = $this->security->getUser();

         /** @var Purchase */
        $purchase = $purchaseSuccesEvent->getPurchase();

        // $snappy = new Pdf('/usr/local/bin/wkhtmltopdf');
        // header('Content-Type: application/pdf');
        // echo $snappy->getOutput('http://www.github.com');

        // $test->generateFromHtml(
        //     $this->renderView('home/index.html.twig'),
        //     '/pdf/file.pdf'
        // );

        $this->logger->info("Pdf généré pour la commande n°" . $purchase->getId() );
    }

}
