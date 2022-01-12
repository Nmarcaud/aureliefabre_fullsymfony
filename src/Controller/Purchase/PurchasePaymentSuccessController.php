<?php 

namespace App\Controller\Purchase;

use App\Cart\CartService;
use App\Entity\Purchase;
use App\Event\PurchaseSuccessEvent;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PurchasePaymentSuccessController extends AbstractController
{
    protected $purchaseRepository;
    protected $em;
    protected $cartService;

    public function __construct(PurchaseRepository $purchaseRepository, EntityManagerInterface $em, CartService $cartService)
    {
        $this->purchaseRepository = $purchaseRepository;
        $this->em = $em;
        $this->cartService = $cartService;
    }

    #[Route('/purchase/success/{id}', name: 'purchase_payment_success')]
    public function success($id, EventDispatcherInterface $dispatcher) 
    {

        // Je récupère la purchase
        $purchase = $this->purchaseRepository->find($id);

        // Si il n'y a pas de purchase
        // Si le user de la purchase n'est pas le même que celui qui est connecté
        // Si le status de la purchase est déjà à PAID
        if (!$purchase || ($purchase && $purchase->getUser() !== $this->getUser()) || ($purchase && $purchase->getStatus() === Purchase::STATUS_PAID)) {
            $this->addFlash('warning', "La commande n'éxiste pas");
            return $this->redirectToRoute('purchases_index');
        }
        
        // Je modifie le status à PAID
        $purchase->setStatus(Purchase::STATUS_PAID);

        // Ajout à la bdd
        $this->em->flush();

        // Suppression du cart dans la session
        $this->cartService->removeCart();

        // Lancement d'un event 'purchase.success'  pour l'envoi des mails de confirmation et génération du pdf
        $purchaseEvent = new PurchaseSuccessEvent($purchase);
        $dispatcher->dispatch($purchaseEvent, 'purchase.success');

        // Redirection vers la liste des commandes 
        $this->addFlash('success', "Commande confirmée et payée");
        return $this->redirectToRoute('purchases_index');

    }

}