<?php

namespace App\Controller\User;

use App\Security\EmailVerifier;
use App\Form\UserInformationsType;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class UserParameterController extends AbstractController
{
    protected $userRepository;
    protected $em;
    private $emailVerifier;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em, EmailVerifier $emailVerifier)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
        $this->emailVerifier = $emailVerifier;
    }


    #[Route('/user/parameter', name: 'user_parameter')]
    public function index(Request $request): Response
    {
        
        $user = $this->userRepository->find($this->getUser()->getId());
        $exEmail = $user->getEmail();   // Conserve l'ancienne addresse

        // Form Infos du <Us></Us>er
        $form = $this->createForm(UserInformationsType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Si l'eamil est différent, confirmer l'email par mail !
            if ($user->getEmail() != $exEmail) {
                $user->setIsVerified(false);
                $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('no-reply@aureliefabre.com', 'Aurélie Fabre'))
                    ->to($user->getEmail())
                    ->subject('Confirmez votre email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
                );
            }

            $this->em->flush();

            $this->addFlash('success', "Informations modifiées");

            // Redirection
            return $this->redirectToRoute('profil');

        }


        return $this->render('profil/parameters.html.twig', [
            'user' => $this->getUser(),
            'formView' => $form->createView(),
            'secondaryNavbar' => 'customer'
        ]);
    }
}
