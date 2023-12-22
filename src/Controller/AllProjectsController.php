<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllProjectsController extends AbstractController
{
    #[Route('/all/projects', name: 'app_all_projects')]
    public function index(): Response
    {
        return $this->render('all_projects/index.html.twig', [
            'controller_name' => 'AllProjectsController',
        ]);
    }
}
