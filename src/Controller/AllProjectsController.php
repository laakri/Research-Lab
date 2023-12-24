<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
}
