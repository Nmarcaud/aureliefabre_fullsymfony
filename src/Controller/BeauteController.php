<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BeauteController extends AbstractController
{
    #[Route('/beaute', name: 'beaute_home')]
    public function showBeaute(): Response
    {
        return $this->render('beaute/beaute.html.twig', [
            'secondaryNavbar' => 'beaute',
        ]);
    }


    #[Route('/epilations', name: 'beaute_epilations')]
    public function showEpilation(): Response
    {
        return $this->render('beaute/epilations.html.twig', [
            'secondaryNavbar' => 'beaute',
        ]);
    }

    #[Route('/manucures', name: 'beaute_manucures')]
    public function showManucure(): Response
    {
        return $this->render('beaute/manucures.html.twig', [
            'secondaryNavbar' => 'beaute',
        ]);
    }
}
