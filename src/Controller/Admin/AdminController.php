<?php 

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/dashboard', name:'admin_show_dashboard')]
    public function showDashboard()
    {
        return $this->render('admin/dashboard.html.twig', [
            'secondaryNavbar' => 'admin',
        ]);
    }
}