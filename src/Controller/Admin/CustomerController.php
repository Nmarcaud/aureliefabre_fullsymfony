<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[IsGranted('ROLE_ADMIN')]
#[Route('/customer')]
class CustomerController extends AbstractController
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
        

    #[Route('/', name: 'customers_show')]
    public function index(): Response
    {
        $customers = $this->userRepository->findAll();

        return $this->render('admin/customer/index.html.twig', [
            'secondaryNavbar' => 'admin',
            'customers' => $customers,
        ]);
    }
}
