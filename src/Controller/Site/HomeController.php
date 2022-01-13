<?php

namespace App\Controller\Site;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'home')]
    public function index(ProductRepository $productRepository): Response
    {
        
        // Je ne veux que 3 produits -------- Créer un filtre sur les massages par exemples -- ou 3 meilleurs ventes --
        $products = $productRepository->findBy([], [], 4);

        return $this->render('home/index.html.twig', [
            'products' => $products,
        ]);
    }
}
