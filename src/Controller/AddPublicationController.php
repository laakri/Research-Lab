<?php
// src/Controller/AddPublicationController.php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use App\Repository\ProjectRepository;


class AddPublicationController extends AbstractController
{
    /**
 * @Route("/add-publication", name="index")
 */
public function index( Request $request, PersistenceManagerRegistry $doctrine , ProjectRepository $projectRepository): Response
{
    {
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publication->setDateP(new \DateTime());

            $entityManager = $doctrine->getManager();
            $entityManager->persist($publication);
            $entityManager->flush();

            // Optionally, add a flash message to indicate success
            $this->addFlash('success', 'Publication added successfully.');

           // return $this->redirectToRoute('index');
        }
          // Fetch all publications along with their projects
          $publications = $doctrine->getRepository(Publication::class)->findAllWithProjects();

           // Fetch project choices
        $projectChoices = $projectRepository->findAll();

        return $this->render('add_publication/index.html.twig', [
            'form' => $form->createView(),
            'publications' => $publications,
            'project_choices' => $projectChoices,
        ]);

        return $this->render('add_publication/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}}
?>