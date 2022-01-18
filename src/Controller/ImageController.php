<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImageController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/image/add', name: 'image_add')]
    public function add(Request $request)
    {
        
        


        return $this->render('admin/images/add.html.twig', [
            // 'formView' => $formView,
            'secondaryNavbar' => 'admin',
        ]);
    }
}
