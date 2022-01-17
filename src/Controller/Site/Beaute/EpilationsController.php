<?php

namespace App\Controller\Site\Beaute;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EpilationsController extends AbstractController
{
    #[Route('/epilations', name: 'beaute_epilations')]
    public function index(): Response
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
