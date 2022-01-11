<?php

namespace App\Controller\Site\Beaute;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManucuresController extends AbstractController
{
    #[Route('/manucures', name: 'beaute_manucures')]
    public function index(): Response
    {
        return $this->render('beaute/manucures.html.twig', [
            'secondaryNavbar' => 'beaute',
        ]);
    }
}
