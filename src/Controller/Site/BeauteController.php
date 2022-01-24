<?php

namespace App\Controller\Site;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/beaute')]
class BeauteController extends AbstractController
{
    protected $secondaryNavbar;

    public function __construct()
    {
        $this->secondaryNavbar = 'beaute';
    }


    #[Route('/', name: 'beaute_home')]
    public function showHome(): Response
    {
        return $this->render('beaute/beaute.html.twig', [
            'secondaryNavbar' => $this->secondaryNavbar,
        ]);
    }


    #[Route('/epilations', name: 'beaute_epilations')]
    public function showEpilations(): Response
    {
        return $this->render('beaute/epilations.html.twig', [
            'secondaryNavbar' => $this->secondaryNavbar,
        ]);
    }


    #[Route('/manucures', name: 'beaute_manucures')]
    public function showManucures(): Response
    {
        return $this->render('beaute/manucures.html.twig', [
            'secondaryNavbar' => $this->secondaryNavbar,
        ]);
    }
}
