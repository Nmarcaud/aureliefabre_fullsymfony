<?php

namespace App\Controller\Site\BienEtre;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConseilsBilansController extends AbstractController
{
    #[Route('/bien-etre/conseils-et-bilans', name: 'conseils_bilans')]
    public function index(): Response
    {

        return $this->render('bien_etre/conseils_bilans.html.twig', [
            'secondaryNavbar' => 'bien-etre',
        ]);
    }

}
