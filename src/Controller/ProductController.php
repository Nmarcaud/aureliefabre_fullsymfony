<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProductController extends AbstractController
{

    protected $em;
    protected $slugger;
    protected $productRepository;
    protected $categoryRepository;

    public function __construct(EntityManagerInterface $em, SluggerInterface $slugger, ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->em = $em;
        $this->slugger = $slugger;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    // SITE
    #[Route('product/{category_slug}/{slug}', name: 'product_show')]
    public function show($slug, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBy(['slug' => $slug]);

        // Erreur si non trouvé
        if(!$product) {
            throw $this->createNotFoundException("La catégorie demandée n'éxiste pas");
        }

        return $this->render('site/product/product.html.twig', [
            'product' => $product,
            'secondaryNavbar' => 'bien-etre',
        ]);
    }


    // ADMIN
    #[IsGranted('ROLE_ADMIN', message: "Vous n'avez pas accès à cette section")]
    #[Route('products', name: 'products_show')]
    public function index(): Response
    {
        $products = $this->productRepository->findAll();
        $categories = $this->categoryRepository->findAll();
        return $this->render('admin/product/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'secondaryNavbar' => 'admin',
        ]);
    }


    #[IsGranted('ROLE_ADMIN', message: "Vous n'avez pas accès à cette section")]
    #[Route('/admin/product/{id}/edit', name: 'product_edit')]
    public function edit($id, Request $request)
    {
        $product = $this->productRepository->find($id);

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

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


    #[IsGranted('ROLE_ADMIN', message: "Vous n'avez pas accès à cette section")]
    #[Route('/admin/product/create', name: 'product_create')]
    public function create(Request $request)
    {
        $product = new Product;
        $form = $this->createForm(ProductType::class, $product);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($product);

            $imageJpg = $form->get('jpgPicture')->getData();
            if ($imageJpg) {
                // Rename image
                $newFilename = $product->getSlug() .'-'.uniqid().'.'.$imageJpg->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $imageJpg->move(
                        $this->getParameter('img_products_jpg'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $product->setJpgPicturePath('/img/products/jpg/' . $newFilename);
            }

            $imageWebp = $form->get('webpPicture')->getData();
            if ($imageWebp) {
                // Rename image
                $newFilename = $product->getSlug() .'-'.uniqid().'.'.$imageWebp->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $imageWebp->move(
                        $this->getParameter('img_products_webp'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $product->setWebpPicturePath('/img/products/webp/' . $newFilename);
            }

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

    
    #[IsGranted('ROLE_ADMIN', message: "Vous n'avez pas accès à cette section")]
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


    #[IsGranted('ROLE_ADMIN', message: "Vous n'avez pas accès à cette section")]
    #[Route('/api/admin/product/create', name: 'product_api_create')]
    public function apiCreate(Request $request)
    {

        echo $_POST['name'];

        dd($request);
        
        // $this->em->persist($product);

        // $imageJpg = $form->get('jpgPicture')->getData();
        // if ($imageJpg) {
        //     // Rename image
        //     $newFilename = $product->getSlug() .'-'.uniqid().'.'.$imageJpg->guessExtension();
        //     // Move the file to the directory where brochures are stored
        //     try {
        //         $imageJpg->move(
        //             $this->getParameter('img_products_jpg'),
        //             $newFilename
        //         );
        //     } catch (FileException $e) {
        //         // ... handle exception if something happens during file upload
        //     }
        //     $product->setJpgPicturePath('/img/products/jpg/' . $newFilename);
        // }

        // $imageWebp = $form->get('webpPicture')->getData();
        // if ($imageWebp) {
        //     // Rename image
        //     $newFilename = $product->getSlug() .'-'.uniqid().'.'.$imageWebp->guessExtension();
        //     // Move the file to the directory where brochures are stored
        //     try {
        //         $imageWebp->move(
        //             $this->getParameter('img_products_webp'),
        //             $newFilename
        //         );
        //     } catch (FileException $e) {
        //         // ... handle exception if something happens during file upload
        //     }
        //     $product->setWebpPicturePath('/img/products/webp/' . $newFilename);
        // }

        // $this->em->flush();

        // $this->addFlash('success', "Le produit a bien été créé");

        // // Redirection
        // return $this->redirectToRoute('products_show');
    }
}
