<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Cart\CartService;
use App\Form\CartConfirmationType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
 
    protected $cartService;
    protected $productRepository;

    public function __construct(CartService $cartService, ProductRepository $productRepository)
    {
        $this->cartService = $cartService;
        $this->productRepository = $productRepository;
    }


    protected function productExsitInDB(int $id)
    {
        // Le produit existe ?
        $product = $this->productRepository->find($id);
    
        // N'existe pas => exception
        if (!$product) {
            throw $this->createNotFoundException("Le produit $id n'éxiste pas");
        }
    }


    // Requirement ( requiert un nombre )
    #[Route('/cart/add/{id}/{route}', name: 'cart_add', requirements: ['id' => '\d+'])]
    public function add(int $id, string $route, Request $request)
    {   
        // Le produit existe ?
        $this->productExsitInDB($id);

        $product = $this->productRepository->find($id);
        
        // Ajout au panier
        $this->cartService->add($id);

        // 7. Notification
        // J'ajoute un message dans le flashbag ('code', 'message')
        $this->addFlash('success', "Le produit a bien été ajouté au panier");

        $route_parameters = $request->get('param');
        if ($route_parameters) {
            return $this->redirectToRoute($route, $route_parameters);
        }
        // Redirection vers page du produit
        return $this->redirectToRoute($route);
    }


    #[Route('/cart', name: 'cart_show')]
    public function show() {

        $purchase = new Purchase;
        $form = $this->createForm(CartConfirmationType::class, $purchase);

        return $this->render('cart/index.html.twig', [
            'items' => $this->cartService->getDetailedCartItems(),
            'total' => $this->cartService->getTotal(),
            'confirmationForm' => $form->createView(),
        ]);

    }


    #[Route('/cart/delete/{id}', name: 'cart_delete', requirements: ['id' => '\d+'])]
    public function delete(int $id) {
        
        // Le produit existe ?
        $this->productExsitInDB($id);

        $this->cartService->remove($id);

        // J'ajoute un message dans le flashbag ('code', 'message')
        $this->addFlash('success', "Le produit a bien été supprimé du panier");

        return $this->redirectToRoute('cart_show');

    }

    #[Route('/cart/delete/{id}/{route}', name: 'cart_mini_cart_delete', requirements: ['id' => '\d+'])]
    public function miniCartDelete(int $id, string $route) {
        
        // Le produit existe ?
        $this->productExsitInDB($id);

        $this->cartService->remove($id);

        // J'ajoute un message dans le flashbag ('code', 'message')
        $this->addFlash('success', "Le produit a bien été supprimé du panier");

        return $this->redirectToRoute($route);

    }


    #[Route('/cart/decrement/{id}', name: 'cart_decrement', requirements: ['id' => '\d+'])]
    public function decrement(int $id) {
        
        // Le produit existe ?
        $this->productExsitInDB($id);

        $this->cartService->decrement($id);

        // J'ajoute un message dans le flashbag ('code', 'message')
        $this->addFlash('success', "1 produit a bien été retiré du panier");

        return $this->redirectToRoute('cart_show');

    }


    #[Route('/cart/increment/{id}', name: 'cart_increment', requirements: ['id' => '\d+'])]
    public function increment(int $id) {
        
        // Le produit existe ?
        $this->productExsitInDB($id);

        $this->cartService->increment($id);

        // J'ajoute un message dans le flashbag ('code', 'message')
        $this->addFlash('success', "1 produit a bien été ajouté du panier");

        return $this->redirectToRoute('cart_show');

    }
}
