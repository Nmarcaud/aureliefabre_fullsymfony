<?php

namespace App\Controller\Site\BienEtre;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SoinsAbsolutionController extends AbstractController
{
    #[Route('/bien-etre/soins-absolution', name: 'soins_absolution')]
    public function index(): Response
    {
        return $this->render('bien_etre/soins_absolution.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }

}