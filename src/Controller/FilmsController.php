<?php

namespace App\Controller;

use DateTime;
use App\Entity\Films;
use App\Form\FilmType;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilmsController extends AbstractController
{
    #[Route('/film', name: 'app_films')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $film = new Films();

        $form = $this->createForm(FilmType::class, $film);

        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $film->setDate(new DateTime());

            $film->setUserId($user);

            $em = $doctrine->getManager();
            $em->persist($film);
            $em->flush();
            $this->addFlash('success', 'Votre film est enregistré');

            return $this->redirectToRoute('show_films');
        }

        return $this->render('films/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/films', name: 'show_films')]
    public function show(ManagerRegistry $doctrine, PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();

        $film = $user->getFilms();

        $repository = $doctrine->getRepository(Films::class);

        $pagination = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            2
        );

        return $this->render('films/show.html.twig', [
            'films' => $film,
            'pagination' => $pagination
        ]);
    }
}
