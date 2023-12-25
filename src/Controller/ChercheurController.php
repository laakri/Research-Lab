<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EmailModificationType;

use App\Repository\ProjectRepository;


class ChercheurController extends AbstractController
{
    #[Route('/chercheur', name: 'app_liste_chercheur')]
    public function index(): Response
    {
        return $this->render('chercheur/index.html.twig', [
            'controller_name' => 'ChercheurController',
        ]);
    }
  
   

    #[Route('/profile-chercheur', name: 'app_profile_chercheur')]
    public function show(Request $request, ProjectRepository $projectRepository , PersistenceManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        // Get the list of projects for the current user
        $projects = $projectRepository->findBy(['principalResearcher' => $user]);

        $form = $this->createForm(EmailModificationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Email updated successfully.');

            return $this->redirectToRoute('app_profile_chercheur');
        }

        return $this->render('chercheur/profile.html.twig', [
            'user' => $user,
            'projects' => $projects, // Pass the projects to the template
            'form' => $form->createView(),
        ]);
    }

}
