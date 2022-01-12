<?php

namespace App\Controller\Site\BienEtre;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MassagesInstitutController extends AbstractController
{
    #[Route('/bien-etre/massage-de-l-institut', name: 'massages_institut')]
    public function index(): Response
    {   
        return $this->render('bien_etre/massages_institut.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }

}
