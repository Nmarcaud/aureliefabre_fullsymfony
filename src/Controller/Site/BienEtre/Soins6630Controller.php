<?php

namespace App\Controller\Site\BienEtre;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Soins6630Controller extends AbstractController
{

    protected $productRepository;
    protected $categoryRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->products = $this->productRepository->findAll();
    }

    #[Route('/bien-etre/soins-66°30', name: 'soins_6630')]
    public function index(): Response
    {
        return $this->render('bien_etre/soins_6630.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }

}