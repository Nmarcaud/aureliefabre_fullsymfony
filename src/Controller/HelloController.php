<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelloController extends AbstractController
{

    #[Route('/hello/{name}/{age}', name: 'hello')]
    public function index($name = "World", $age = 0): Response
    {
        return $this->render('hello/index.html.twig', [
            'prestations' => [
                [ 'name' => 'Californien'],
                [ 'name' => 'Nuit Scandinave'],
                [ 'name' => 'Test']
            ]
        ]);
    }
}
