<?php

namespace App\Controller\Purchase;

use App\Entity\Purchase;
use App\Cart\CartService;
use App\Entity\PurchaseItem;
use App\Form\CartConfirmationType;
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

    public function __construct(CartService $cartService, EntityManagerInterface $em)
    {
        $this->cartService = $cartService;
        $this->em = $em;
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


        // Récupérer les produits du panier
        $cartItems = $this->cartService->getDetailedCartItems();
        
        // Si il n'y a pas d'items dans le cart
        if (count($cartItems) === 0) {
            $this->addFlash('warning', "Votre panier est vide !");
            return $this->redirectToRoute('cart_show');
        }
        foreach ($cartItems as $cartItem) {
            $purchaseItem = new PurchaseItem;
            $purchaseItem
                ->setPurchase($purchase)
                ->setProduct($cartItem->product)
                ->setProductName($cartItem->product->getName())
                ->setProductPrice($cartItem->product->getPrice())
                ->setQuantity($cartItem->quantity)
                ->setTotal($cartItem->product->getPrice() * $cartItem->quantity);
            
            $purchase->addPurchaseItem($purchaseItem);

            $this->em->persist($purchaseItem);
        }


        // Autre éléments manquants
        $purchase
            ->setUser($this->getUser())
            ->setTotal($this->cartService->getTotal())
            ->setPurchasedAt(new \DateTime());


        // Saisir en bdd
        $this->em->persist($purchase);
        $this->em->flush();


        // Commande validée ! 
            // Redirection vers la liste des commandes 
            // Suppression du cart dans la session
        
        $this->cartService->removeCart();
        $this->addFlash('success', "Commande validée");
        return $this->redirectToRoute('purchases_index');


    }
}
