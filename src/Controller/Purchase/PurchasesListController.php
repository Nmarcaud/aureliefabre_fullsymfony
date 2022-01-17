<?php

// Un Controller qui liste toutes les actions possibles sur mes commandes ( Purchase )

namespace App\Controller\Purchase;

use App\Repository\PurchaseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: "Vous devez être connecté pour accéder à vos commandes")]
class PurchasesListController extends AbstractController 
{
    protected $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }

    #[Route('/purchases', name:'purchases_index')]
    public function index()
    {

        /** @var User */
        $user = $this->getUser();

        $purchases = $this->purchaseRepository->findBy(
            ['user' => $user->getId()],
            ['createdAt' => 'DESC']
        );

        // Passer l'utilisateur connecté à Twig a fin d'afficher ses commandes
        return $this->render('purchase/index.html.twig', [
            'purchases' => $purchases,
            'secondaryNavbar' => 'customer'
        ]);

    }
}