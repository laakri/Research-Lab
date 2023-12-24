<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AllProjectsController extends AbstractController
{
    #[Route('/all/projects', name: 'app_all_projects')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Get all projects from the database
        $projects = $entityManager->getRepository(Project::class)->findAll();
        return $this->render('all_projects/index.html.twig', [
            'projects' => $projects,
            
        ]);
    }

    #[Route('/delete/project/{id}', name: 'app_delete_project')]
    public function deleteProject(Project $project, EntityManagerInterface $entityManager): RedirectResponse
    {
        // Remove the project from the database
        $entityManager->remove($project);
        $entityManager->flush();

        // Add a flash message for success
        $this->addFlash('success', 'Project deleted successfully!');

        // Redirect back to the project list
        return $this->redirectToRoute('app_all_projects');
    }
    #[Route('/select-researcher/{projectId}', name: 'app_select_researcher')]
    public function selectResearcher(Project $project, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjectUserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $researcher = $data['researcher'];

            // Update the project's principal researcher
            $project->setResearcherId($researcher->getId());
            $entityManager->flush();

            // Add a flash message for success
            $this->addFlash('success', 'Principal Researcher selected successfully!');

            // Redirect back to the project list
            return $this->redirectToRoute('app_all_projects');
        }
    }
    #[Route('/get/users', name: 'app_get_users')]
    public function getUsers(EntityManagerInterface $entityManager): JsonResponse
    {
        $users = $entityManager->getRepository(User::class)->findAll();

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
            ];
        }
        
        return $this->json($data);
    }
}