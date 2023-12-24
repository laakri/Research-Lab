<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;

class ProjectController extends AbstractController
{
    #[Route("/projects", name: "project_list")]
    public function listProjects(ManagerRegistry $doctrine): Response
    {
        $projects = $doctrine->getRepository(Project::class)->findAll();

        return $this->render('project/list.html.twig', [
            'projects' => $projects,
        ]);
    }
}

?>