<?php

// src/Controller/CreateProjectController.php

namespace App\Controller;
use App\Form\ProjectType;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CreateProjectController extends AbstractController
{
    #[Route('/create/project', name: 'app_create_project')]
    public function index(Request $request ,EntityManagerInterface $entityManager): Response
    {
        
        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Retrieve the form data
            $data = $form->getData();

            // Create a Project entity and set its values

            $entityManager->persist($project);
            $entityManager->flush();
            

            // Add a flash message for user feedback
            $this->addFlash('success', 'Project created successfully!');

            // Redirect to a route (you can customize this)
            return $this->redirectToRoute('your_success_route');
        }

        // Render the form in your template
        return $this->render('create_project/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
