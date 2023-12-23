<?php

// src/Controller/CreateProjectController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateProjectController extends AbstractController
{
    #[Route('/create/project', name: 'app_create_project')]
    public function index(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('name')
            ->add('description')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // Log the data to the console (you can replace this with any logging mechanism)
            $this->addFlash('success', 'Project created successfully!');
            dump($data); // This will be logged to the console
        }

        return $this->render('create_project/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}