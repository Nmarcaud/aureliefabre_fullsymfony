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
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[IsGranted('ROLE_USER')]
class UserParameterController extends AbstractController
{
    protected $userRepository;
    protected $em;
    private $emailVerifier;
    protected $slugger;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em, EmailVerifier $emailVerifier, SluggerInterface $slugger)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
        $this->emailVerifier = $emailVerifier;
        $this->slugger = $slugger;
    }


    #[Route('/user/parameter', name: 'user_parameter')]
    public function index(Request $request): Response
    {
        
        $user = $this->userRepository->find($this->getUser()->getId());

        $exEmail = $user->getEmail();                       // Conserve l'ancienne addresse -> pour vérification nouvelle addresse
        $exPictureName = $user->getProfilePictureName();    // Conserve l'ancienne picture -> pour suppression ancienne picture

        // Form Infos du <Us></Us>er
        $form = $this->createForm(UserInformationsType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Si l'email est différent, confirmer l'email par mail !
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


  
            // Ajout de la picture
            $image = $form->get('picture')->getData();
            if ($image) {

                // Si il y a une ancienne picture, suppression de celle-ci
                if ($exPictureName) {

                    // Suppression in folder !
                    // Sources : https://youtu.be/jrca6I-sBNM
                    $fileLink = $this->getParameter("img_profiles").'/'.$exPictureName;

                    // Si fichier existe bien
                    if(file_exists($fileLink)) {
                        unlink($fileLink);          // Suppression du fichier
                    }
                }

                // Rename image
                $newFilename = $this->slugger->slug(strtolower($user->getFirstName() . $user->getLastName())) .'-'.uniqid().'.'.$image->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('img_profiles'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $user
                    ->setProfilePictureName($newFilename)
                    ->setProfilePicturePath('/img/profiles/' . $newFilename);
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
