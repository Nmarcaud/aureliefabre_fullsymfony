<?php

namespace App\Controller\Site\BienEtre;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BienEtreController extends AbstractController
{

    protected $productRepository;
    protected $categoryRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->products = $this->productRepository->findAll();
    }


    #[Route('/bien-etre/home', name: 'bien_etre_home')]
    public function index(): Response
    {
        return $this->render('bien_etre/bien_etre.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }

}
