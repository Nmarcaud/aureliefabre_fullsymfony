<?php

namespace App\Cart;

use App\Cart\CartItem;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartService extends AbstractController
{
    /*
        Visualisation du cart
        [
            idProduct => quantity,
        ]
    */

    protected $session;
    protected $productRepository;
    
    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }


    // Retrouver le panier dans la session ( sous forme d'un tableau ) et si il n'éxiste pas : tableau vide
    protected function getCart(): array
    {
        
        return $this->session->get('cart', []);
    }


    // Enregistrer le tableau mis à jour dans la session
    protected function saveCart($cart): void
    {
        $this->session->set('cart', $cart);
    }


    protected function productExsitInCart(int $id, array $cart)
    {
        if(!array_key_exists($id, $cart)) {
            return;
        }
    }


    // Suppresion du panier dans la session
    public function removeCart() 
    {
        $this->session->remove('cart');
    }


    public function add(int $id) 
    {
        
        $cart = $this->getCart();

        // Si le poduit n'éxiste pas, je l'initialise à 0
        if (!array_key_exists($id, $cart)) {
            $cart[$id] = 0;
        } 

        // Puis incrémentation de 1
        $cart[$id]++;

        $this->saveCart($cart);

    }


    public function remove(int $id) 
    {
        // Je récupère le panier dans la session
        $cart = $this->getCart();

        // Si le produit n'éxiste pas dans le cart - stop -
        $this->productExsitInCart($id, $cart);

        // Je supprime l'élément ( toute la ligne, peut-importe le nombre de product )
        unset($cart[$id]);

        $this->saveCart($cart);
    }


    public function decrement(int $id) 
    {
        $cart = $this->getCart();
        $this->productExsitInCart($id, $cart);

        // Si il ne reste plus qu'un item
        if( $cart[$id] === 1 ) {
            $this->remove($id);
            return;
        } 
        
        $cart[$id] -= 1;
        
        $this->saveCart($cart);
    }


    public function increment(int $id) 
    {
        $cart = $this->getCart();
        $this->productExsitInCart($id, $cart);
        $cart[$id] += 1;
        $this->saveCart($cart);
    }


    public function getTotal(): int 
    {
        $total = 0;

        // [id => ['porduct' => ..., 'quantity' => qté ]]
        foreach ($this->getCart() as $id => $quantity) {
            
            $product = $this->productRepository->find($id);

            // Si il n'y a pas de produit - continue et zap l'étape suivante
            if(!$product) {
                continue;
            }

            $total += $product->getPrice() * $quantity;

        }

        return $total;

    }


    public function getNbItemsInCart(): int 
    {
        $nbItems = 0;

        // [id => ['porduct' => ..., 'quantity' => qté ]]
        foreach ($this->getCart() as $id => $quantity) {
            
            $product = $this->productRepository->find($id);

            // Si il n'y a pas de produit - continue et zap l'étape suivante
            if(!$product) {
                continue;
            }
            $nbItems += $quantity;

        }

        return $nbItems;

    }


    // Annotation pour autocomplétion
    /**
     *
     * @return CartItem[]
     */
    public function getDetailedCartItems(): array 
    {
        $detailCart = [];

        // [id => ['porduct' => ..., 'quantity' => qté ]]
        foreach ($this->getCart() as $id => $quantity) {
            
            $product = $this->productRepository->find($id);

            // Si il n'y a pas de produit - continue et zap l'étape suivante
            if(!$product) {
                continue;
            }
            
            $detailCart[] = new CartItem($product, $quantity);
        }

        return $detailCart;
    }


    

}