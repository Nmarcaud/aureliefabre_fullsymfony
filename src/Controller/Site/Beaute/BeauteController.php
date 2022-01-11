<?php

namespace App\Controller\Site\Beaute;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BeauteController extends AbstractController
{
    #[Route('/beaute', name: 'beaute_home')]
    public function index(): Response
    {
        return $this->render('beaute/beaute.html.twig', [
            'secondaryNavbar' => 'beaute',
        ]);
    }
}
