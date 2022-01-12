<?php

namespace App\Controller\Site\BienEtre;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BienEtreController extends AbstractController
{
    #[Route('/bien-etre/home', name: 'bien_etre_home')]
    public function index(): Response
    {
        return $this->render('bien_etre/bien_etre.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }

}
