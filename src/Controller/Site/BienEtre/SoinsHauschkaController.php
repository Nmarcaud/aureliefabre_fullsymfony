<?php

namespace App\Controller\Site\BienEtre;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SoinsHauschkaController extends AbstractController
{
    #[Route('/bien-etre/soins-dr-hauschka', name: 'soins_hauschka')]
    public function index(): Response
    {
        return $this->render('bien_etre/soins_hauschka.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }
}