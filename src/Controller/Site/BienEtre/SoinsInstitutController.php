<?php

namespace App\Controller\Site\BienEtre;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SoinsInstitutController extends AbstractController
{
    #[Route('/bien-etre/soins-de-l-institut', name: 'soins_institut')]
    public function index(): Response
    {
        return $this->render('bien_etre/soins_institut.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }

}