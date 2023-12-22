<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Faker\Factory;

class AllProjectsController extends AbstractController
{
    #[Route('/all/projects', name: 'app_all_projects')]
    public function index(): Response
    {
        $faker = Factory::create();

        // Generate some fake projects for testing
        $fakeProjects = [];
        for ($i = 1; $i <= 10; $i++) {
            $fakeProjects[] = [
                'id' => $i,
                'name' => $faker->words(3, true),
                'description' => $faker->sentence(),
            ];
        }

        return $this->render('all_projects/index.html.twig', [
            'fakeProjects' => $fakeProjects,
        ]);
    }
}
