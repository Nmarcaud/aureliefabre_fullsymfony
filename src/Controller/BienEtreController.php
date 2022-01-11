<?php

namespace App\Controller;

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
    public function showBienEtre(): Response
    {
        return $this->render('bien_etre/bien_etre.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }


    #[Route('/bien-etre/conseils-et-bilans', name: 'conseils_bilans')]
    public function showConseilsBilans(): Response
    {

        return $this->render('bien_etre/conseils_bilans.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }


    #[Route('/bien-etre/massage-de-l-institut', name: 'massages_institut')]
    public function showMassagesInstitut(): Response
    {   
        return $this->render('bien_etre/massages_institut.html.twig', [
            'secondaryNavbar' => 'bien-etre',
            'products' => $this->products
        ]);
    }


    #[Route('/bien-etre/massages-du-monde', name: 'massages_monde')]
    public function showMassagesMonde(): Response
    {
        return $this->render('bien_etre/massages_monde.html.twig', [
            'secondaryNavbar' => 'bien-etre',
            'products' => $this->products
        ]);
    }


    #[Route('/bien-etre/massages-a-la-carte', name: 'massages_carte')]
    public function showMassagesCarte(): Response
    {
        return $this->render('bien_etre/massages_carte.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }


    #[Route('/bien-etre/soins-de-l-institut', name: 'soins_institut')]
    public function showSoinsInstitut(): Response
    {
        return $this->render('bien_etre/soins_institut.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }


    #[Route('/bien-etre/soins-absolution', name: 'soins_absolution')]
    public function showSoinsAbsolution(): Response
    {
        return $this->render('bien_etre/soins_absolution.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }


    #[Route('/bien-etre/soins-66°30', name: 'soins_6630')]
    public function showSoins6630(): Response
    {
        return $this->render('bien_etre/soins_6630.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }


    #[Route('/bien-etre/soins-dr-hauschka', name: 'soins_hauschka')]
    public function showSoinsHauschka(): Response
    {
        return $this->render('bien_etre/soins_hauschka.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }
}
