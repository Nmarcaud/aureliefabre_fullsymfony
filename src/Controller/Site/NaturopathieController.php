<?php

namespace App\Controller\Site;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/naturopathie')]
class NaturopathieController extends AbstractController
{
    protected $secondaryNavbar;

    public function __construct()
    {
        $this->secondaryNavbar = 'naturopathie';
    }

    #[Route('/', name: 'naturopathie_home')]
    public function showHome(): Response
    {
        return $this->render('naturopathie/index.html.twig', [
            'controller_name' => 'NaturopathieController',
        ]);
    }
}
