<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProductController extends AbstractController
{
    
    #[Route('/{slug}', name: 'product_category')]
    public function category($slug, CategoryRepository $categoryRepository): Response
    {

        $category = $categoryRepository->findOneBy(['slug' => $slug]);

        // Erreur si non trouvé
        if(!$category) {
            throw $this->createNotFoundException("La catégorie demandée n'éxiste pas");
        }

        return $this->render('product/category.html.twig', [
            'category' => $category
        ]);
    }


    #[Route('/{category_slug}/{slug}', name: 'product_show')]
    public function show($slug, ProductRepository $productRepository): Response
    {

        $product = $productRepository->findOneBy(['slug' => $slug]);

        // Erreur si non trouvé
        if(!$product) {
            throw $this->createNotFoundException("La catégorie demandée n'éxiste pas");
        }

        return $this->render('product/product.html.twig', [
            'product' => $product
        ]);
    }
}
