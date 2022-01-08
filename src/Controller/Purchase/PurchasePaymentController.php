<?php 

namespace App\Controller\Purchase;

use App\Entity\Purchase;
use App\Stripe\StripeService;
use App\Repository\PurchaseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasePaymentController extends AbstractController
{

    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }


    #[IsGranted('ROLE_USER')]
    #[Route('/purchase/pay/{id}', name:'purchase_payment_form')]
    public function shoCardForm($id, PurchaseRepository $purchaseRepository)
    {

        $purchase = $purchaseRepository->find($id);

        if(!$purchase || ($purchase && $purchase->getUser() !== $this->getUser()) || ($purchase && $purchase->getStatus() === Purchase::STATUS_PAID)) {
            return $this->redirectToRoute('cart_show');
        }

        // Récupération du paiement stripe ?!
        // Voir dossier Stripe dans Src
        $paymentIntent = $this->stripeService->getPaymentIntent($purchase);

        return $this->render('purchase/payment.html.twig', [
            'clientSecret' => $paymentIntent->client_secret,
            'purchase' => $purchase,
            'stripePublicKey' => $this->stripeService->getPublicKey()
        ]);

    }
}