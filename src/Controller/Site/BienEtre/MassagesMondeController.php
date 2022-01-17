<?php

namespace App\Controller\Site\BienEtre;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MassagesMondeController extends AbstractController
{
    #[Route('/bien-etre/massages-du-monde', name: 'massages_monde')]
    public function index(): Response
    {
        return $this->render('bien_etre/massages_monde.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }

}
