<?php

namespace App\Controller\Site;

use App\Controller\ProductController;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/bien-etre')]
class BienEtreController extends AbstractController
{
    protected $secondaryNavbar;
    protected $products;

    public function __construct(ProductRepository $productRepository)
    {
        $this->secondaryNavbar = 'bien-etre';
        $this->products = $productRepository->findAll();
    }


    #[Route('/', name: 'bien_etre_home')]
    public function showHome(): Response
    {
        return $this->render('bien_etre/bien_etre.html.twig', [
            'secondaryNavbar' => $this->secondaryNavbar,
        ]);
    }


    #[Route('/conseils-et-bilans', name: 'conseils_bilans')]
    public function showConseilsBilans(): Response
    {
        return $this->render('bien_etre/conseils_bilans.html.twig', [
            'secondaryNavbar' => $this->secondaryNavbar,
        ]);
    }


    #[Route('/massage-de-l-institut', name: 'massages_institut')]
    public function showMassagesInstitut(): Response
    {   
        return $this->render('bien_etre/massages_institut.html.twig', [
            'secondaryNavbar' => $this->secondaryNavbar,
        ]);
    }


    #[Route('/massages-du-monde', name: 'massages_monde')]
    public function showMassagesMonde(): Response
    {
        return $this->render('bien_etre/massages_monde.html.twig', [
            'secondaryNavbar' => $this->secondaryNavbar,
        ]);
    }


    #[Route('/massages-a-la-carte', name: 'massages_carte')]
    public function showMassagesCarte(): Response
    {
        return $this->render('bien_etre/massages_carte.html.twig', [
            'secondaryNavbar' => $this->secondaryNavbar,
        ]);
    }


    #[Route('/soins-de-l-institut', name: 'soins_institut')]
    public function showSoinsInstitut(): Response
    {
        return $this->render('bien_etre/soins_institut.html.twig', [
            'secondaryNavbar' => $this->secondaryNavbar,
        ]);
    }


    #[Route('/soins-absolution', name: 'soins_absolution')]
    public function showSoinsAbsolution(): Response
    {
        return $this->render('bien_etre/soins_absolution.html.twig', [
            'secondaryNavbar' => $this->secondaryNavbar,
        ]);
    }


    #[Route('/soins-66°30', name: 'soins_6630')]
    public function showSoins6630(): Response
    {
        return $this->render('bien_etre/soins_6630.html.twig', [
            'secondaryNavbar' => $this->secondaryNavbar,
        ]);
    }


    #[Route('/soins-dr-hauschka', name: 'soins_hauschka')]
    public function showSoinsHauschka(): Response
    {
        return $this->render('bien_etre/soins_hauschka.html.twig', [
            'secondaryNavbar' => $this->secondaryNavbar,
        ]);
    }

}
