<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use App\Repository\ProjectRepository;

class AddPublicationController extends AbstractController
{
    /**
     * @Route("/add-publication", name="add_publication")
     */
    public function index(
        Request $request,
        PersistenceManagerRegistry $doctrine,
        ProjectRepository $projectRepository,
        UserInterface $user
    ): Response {
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publication->setDateP(new \DateTime());
            $publication->setChercheur($user); 

            $entityManager = $doctrine->getManager();
            $entityManager->persist($publication);
            $entityManager->flush();
            
            $this->addFlash('success', 'Publication added successfully.');

            return $this->redirectToRoute('add_publication');
        }

        $publications = $doctrine->getRepository(Publication::class)->findAllWithProjects();
        $projectChoices = $projectRepository->findAll();

        return $this->render('add_publication/index.html.twig', [
            'form' => $form->createView(),
            'publications' => $publications,
            'project_choices' => $projectChoices,
        ]);
    }

    /**
     * @Route("/delete-publication/{id}", name="delete_publication", methods={"POST"})
     */
    public function delete(int $id, PersistenceManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $publication = $entityManager->getRepository(Publication::class)->find($id);

        if (!$publication) {
            throw $this->createNotFoundException('Publication not found');
        }

        $entityManager->remove($publication);
        $entityManager->flush();

        $this->addFlash('success', 'Publication deleted successfully.');

        return $this->redirectToRoute('add_publication');
    }
}
