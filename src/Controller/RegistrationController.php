<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_accueil');
        }
        
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->passwordEncoder->hashPassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_USER']);

            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
            
            $this->addFlash('success', 'Votre compte a été créé, veuillez vous connecter');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
}
