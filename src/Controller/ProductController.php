<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    protected $em;
    protected $slugger;
    protected $productRepository;

    public function __construct(EntityManagerInterface $em, SluggerInterface $slugger, ProductRepository $productRepository)
    {
        $this->em = $em;
        $this->slugger = $slugger;
        $this->productRepository = $productRepository;
    }

    // SITE
    #[Route('product/{category_slug}/{slug}', name: 'product_show')]
    public function show($slug): Response
    {

        $product = $this->productRepository->findOneBy(['slug' => $slug]);

        // Erreur si non trouvé
        if(!$product) {
            throw $this->createNotFoundException("La catégorie demandée n'éxiste pas");
        }

        return $this->render('site/product/product.html.twig', [
            'product' => $product
        ]);
    }


    // ADMIN
    #[IsGranted('ROLE_ADMIN')]
    #[Route('products', name: 'products_show')]
    public function index(): Response
    {
        $products = $this->productRepository->findAll();
        return $this->render('admin/product/index.html.twig', [
            'products' => $products,
            'secondaryNavbar' => 'admin',
        ]);
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/product/{id}/edit', name: 'product_edit')]
    public function edit($id, Request $request)
    {
        $product = $this->productRepository->find($id);

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Génération du slug ( au cas où il ai changé )
            $product->setSlug(strtolower($this->slugger->slug($product->getName())));

            $this->em->flush();

            $this->addFlash('success', "Le produit a bien été modifié");

            // Redirection
            return $this->redirectToRoute('products_show');

        }

        $formView = $form->createView();

        return $this->render('admin/product/edit.html.twig', [
            'product' => $product,
            'formView' => $formView,
            'secondaryNavbar' => 'admin',
        ]);
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/product/create', name: 'product_create')]
    public function create(Request $request)
    {
        $product = new Product;
        $form = $this->createForm(ProductType::class, $product);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Génération du slug
            $product->setSlug(strtolower($this->slugger->slug($product->getName())));
    
            $this->em->persist($product);
            $this->em->flush();

            $this->addFlash('success', "Le produit a bien été créé");

            // Redirection
            return $this->redirectToRoute('products_show');

        }

        $formView = $form->createView();

        return $this->render('admin/product/create.html.twig', [
            'formView' => $formView,
            'secondaryNavbar' => 'admin',
        ]);
    }


    #[Route('/admin/product/delete/{id}', name: 'product_delete', requirements: ['id' => '\d+'])]
    public function delete(int $id) {
        
        // Le produit existe ?
        $product = $this->productRepository->find($id);
    
        // N'existe pas => exception
        if (!$product) {
            throw $this->createNotFoundException("Le produit $id n'éxiste pas");
        }

        $this->em->remove($product);
        $this->em->flush();

        $this->addFlash('success', "Le produit a bien été supprimé");

        return $this->redirectToRoute('products_show');
    }
}
