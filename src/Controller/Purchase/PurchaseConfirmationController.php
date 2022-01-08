<?php

namespace App\Controller\Purchase;

use App\Entity\Purchase;
use App\Cart\CartService;
use App\Entity\PurchaseItem;
use App\Form\CartConfirmationType;
use App\Purchase\PurchasePersister;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchaseConfirmationController extends AbstractController
{

    protected $cartService;
    protected $em;
    protected $purchasePersister;

    public function __construct(CartService $cartService, EntityManagerInterface $em, PurchasePersister $purchasePersister)
    {
        $this->cartService = $cartService;
        $this->em = $em;
        $this->purchasePersister = $purchasePersister;
    }


    #[IsGranted('ROLE_USER', message: "Vous devez être connecté pour valider votre commandes")]
    #[Route('/purchase/confirm', name: 'purchase_confirm')]
    public function confirm(Request $request): Response
    {

        $purchase = new Purchase;
        $form = $this->createForm(CartConfirmationType::class, $purchase);

        $form->handleRequest($request);


        // Si formulaire n'est pas soumis
        if (!$form->isSubmitted()) {
            $this->addFlash('danger', "Le formulaire de confirmation n'a pas été complèté");
            return $this->redirectToRoute('cart_show');
        }

        // Formulaire non valide
        if (!$form->isValid()) {
            $this->addFlash('danger', "Le formulaire de confirmation n'est pas valide");
            return $this->redirectToRoute('cart_show');
        }


        // Sauvergade la commande
        // Refactorisation
        $this->purchasePersister->storePurchase($purchase);


        // Commande validée ! 
        // Redirection vers le paiement
        return $this->redirectToRoute('purchase_payment_form', [
            'id' => $purchase->getId()
        ]);

    }
}
