<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    protected $em;
    protected $slugger;
    protected $categoryRepository;

    public function __construct(EntityManagerInterface $em, SluggerInterface $slugger, CategoryRepository $categoryRepository)
    {
        $this->em = $em;
        $this->slugger = $slugger;
        $this->categoryRepository = $categoryRepository;
    }

    
    #[Route('/category/{slug}', name: 'category_show')]
    public function show($slug): Response
    {
        $category = $this->categoryRepository->findOneBy(['slug' => $slug]);

        // Erreur si non trouvé
        if(!$category) {
            throw $this->createNotFoundException("La catégorie demandée n'éxiste pas");
        }

        return $this->render('site/category/category.html.twig', [
            'category' => $category
        ]);
    }


    // ADMIN
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/categories', name: 'categories_show')]
    public function index(): Response
    {
        $categories = $this->categoryRepository->findAll();
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories,
            'secondaryNavbar' => 'admin',
        ]);
    }


    // Create
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/category/create', name: 'category_create')]
    public function create(Request $request)
    {
        $category = new Category;
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $category
                ->setSlug(strtolower($this->slugger->slug($category->getName())))
                ->setRank(0);

            $this->em->persist($category);
            $this->em->flush();

            $this->addFlash('success', "La catégorie a bien été créée");

            return $this->redirectToRoute('categories_show');
        }

        $formView = $form->createView();

        return $this->render('admin/category/create.html.twig', [
            'formView' => $formView,
            'secondaryNavbar' => 'admin',
        ]);
    }


    // Edit
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/category/{id}/edit', name: 'category_edit')]
    public function edit($id, Request $request)
    {
        $category = $this->categoryRepository->find($id);

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $category->setSlug(strtolower($this->slugger->slug($category->getName())));
            $this->em->flush();

            $this->addFlash('success', "La catégorie a bien été modifiée");

            return $this->redirectToRoute('categories_show');
        }

        $formView = $form->createView();

        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'formView' => $formView,
            'secondaryNavbar' => 'admin',
        ]);
    }


    #[Route('/admin/category/delete/{id}', name: 'category_delete', requirements: ['id' => '\d+'])]
    public function delete(int $id) {
        
        // Le produit existe ?
        $category = $this->categoryRepository->find($id);
    
        // N'existe pas => exception
        if (!$category) {
            throw $this->createNotFoundException("La catégorie $id n'éxiste pas");
        }

        $this->em->remove($category);
        $this->em->flush();

        $this->addFlash('success', "La catégorie a bien été supprimée");

        return $this->redirectToRoute('categories_show');
    }
}
