<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BienEtreController extends AbstractController
{
    #[Route('/bien-etre', name: 'bien_etre_home')]
    public function showBienEtre(): Response
    {
        return $this->render('bien_etre/bien_etre.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }


    #[Route('/conseils-et-bilans', name: 'conseils_bilans')]
    public function showConseilsBilans(): Response
    {
        return $this->render('bien_etre/conseils_bilans.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }


    #[Route('/massages-de-l-institut', name: 'massages_institut')]
    public function showMassagesInstitut(): Response
    {
        return $this->render('bien_etre/massages_institut.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }


    #[Route('/massages-du-monde', name: 'massages_monde')]
    public function showMassagesMonde(): Response
    {
        return $this->render('bien_etre/massages_monde.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }


    #[Route('/massages-a-la-carte', name: 'massages_carte')]
    public function showMassagesCarte(): Response
    {
        return $this->render('bien_etre/massages_carte.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }


    #[Route('/soins-de-l-institut', name: 'soins_institut')]
    public function showSoinsInstitut(): Response
    {
        return $this->render('bien_etre/soins_institut.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }


    #[Route('/soins-absolution', name: 'soins_absolution')]
    public function showSoinsAbsolution(): Response
    {
        return $this->render('bien_etre/soins_absolution.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }


    #[Route('/soins-66°30', name: 'soins_6630')]
    public function showSoins6630(): Response
    {
        return $this->render('bien_etre/soins_6630.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }


    #[Route('/soins-dr-hauschka', name: 'soins_hauschka')]
    public function showSoinsHauschka(): Response
    {
        return $this->render('bien_etre/soins_hauschka.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }
}
