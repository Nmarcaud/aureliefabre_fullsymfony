<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\PreDec;
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

    #[Route('/home', name: 'home')]
    public function index(ProductRepository $productRepository): Response
    {
        


        $products = $productRepository->findAll();

        return $this->render('home/index.html.twig', [
            'products' => $products,

        ]);
    }
}
