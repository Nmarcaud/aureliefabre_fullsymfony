<?php

namespace App\Purchase;

use App\Entity\Purchase;
use App\Cart\CartService;
use App\Entity\PurchaseItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasePersister extends AbstractController
{
    protected $cartService;
    protected $em;

    public function __construct(CartService $cartService, EntityManagerInterface $em)
    {
        $this->cartService = $cartService;
        $this->em = $em;
    }

    public function storePurchase(Purchase $purchase)
    {

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


        // Autres éléments manquants
        $purchase->setUser($this->getUser());


        // Saisir en bdd
        $this->em->persist($purchase);
        $this->em->flush();
    }
}