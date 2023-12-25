<?php

namespace App\Controller;

use App\Entity\Equipments;
use App\Entity\Project;
use App\Entity\User;
use App\Entity\EquipProj;


use Symfony\Component\HttpFoundation\Request;
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
        if ($this->isGranted('ROLE_ADMIN')) {

        // Get all projects from the database
        $projects = $entityManager->getRepository(Project::class)->findAll();
        $equipments = $entityManager->getRepository(Equipments::class)->findAll();
        


        return $this->render('all_projects/index.html.twig', [
            'projects' => $projects,
            'equipments'=>$equipments, 
        ]);
        }
        else{
            return $this->redirectToRoute('app_home_page');
        }
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
    #[Route('/select-second-researcher/{projectId}/{researcherId}', name: 'app_select_second_researcher')]
        public function selectSecondResearcher(
            EntityManagerInterface $entityManager,
            int $projectId,
            int $researcherId
        ): Response {
            $project = $entityManager->getRepository(Project::class)->find($projectId);

            if (!$project) {
                throw $this->createNotFoundException('Project not found');
            }

            $researcher = $entityManager->getRepository(User::class)->find($researcherId);

            if (!$researcher) {
                throw $this->createNotFoundException('Researcher not found');
            }

            $project->addResearcher($researcher);
            $entityManager->flush();

            $this->addFlash('success', 'Second Researcher selected successfully!');

            return $this->redirectToRoute('app_all_projects');
        }

    #[Route('/select-principal-researcher/{projectId}/{researcherId}', name: 'app_select_researcher')]
        public function selectResearcher(
            EntityManagerInterface $entityManager,
            int $projectId,
            int $researcherId
        ): Response {
            // Manually retrieve the Project entity
            $project = $entityManager->getRepository(Project::class)->find($projectId);

            // Check if the project is found
            if (!$project) {
                throw $this->createNotFoundException('Project not found');
            }

            // Manually retrieve the User entity for the selected researcher
            $researcher = $entityManager->getRepository(User::class)->find($researcherId);

            // Check if the researcher is found
            if (!$researcher) {
                throw $this->createNotFoundException('Researcher not found');
            }

            // Update the project's principal researcher
            $project->setPrincipalResearcher($researcher);
            $entityManager->flush();

            // Add a flash message for success
            $this->addFlash('success', 'Principal Researcher selected successfully!');

            // Redirect back to the project list
            return $this->redirectToRoute('app_all_projects');
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
    #[Route('/edit/project/{id}', name: 'app_edit_project')]
    public function editProject(Request $request, EntityManagerInterface $entityManager, Project $project): Response
    {
        $data = json_decode($request->getContent(), true);

        // Retrieve the edited name and description from the request data
        $editedName = $data['editedName'] ?? null;
        $editedDescription = $data['editedDescription'] ?? null;

        // Update the project's name and description
        $project->setName($editedName);
        $project->setDescription($editedDescription);

        // Save changes to the database
        $entityManager->flush();

        return $this->redirectToRoute('app_all_projects');
    }
     
    #[Route('/save-selected-equipment', name:"app_save_selected_equipment")]
     
    public function saveSelectedEquipment(Request $request, EntityManagerInterface $entityManager,): Response
    {
        $data = json_decode($request->getContent(), true);


        $project = $entityManager->getRepository(Project::class)->find($data['project_id']);
        $selectedEquipmentIds = $data['equipment_ids'];

        // Persist the selected equipment for the project
        foreach ($selectedEquipmentIds as $equipmentId) {
            $equipProj = new EquipProj();
            $equipProj->setProjID($project->getId());
            $equipProj->setEquipID($equipmentId);

            $entityManager->persist($equipProj);
        }

        $entityManager->flush();

        // You can return a JSON response indicating success or any other relevant information
        return new JsonResponse(['success' => true]);
    }
}