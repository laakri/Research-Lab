<?php
// src/Controller/CreateEquipmentController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Equipments;
use Doctrine\ORM\EntityManagerInterface;

class CreateEquipmentController extends AbstractController
{
    #[Route('/create/equipment', name: 'create_equipment')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            // Retrieve form data
            $name = $request->request->get('equipment');
            $description = $request->request->get('description');

            // Create a new Equipments entity and set its properties
            $equipment = new Equipments();
            $equipment->setName($name);
            $equipment->setDescription($description);

            // Persist the entity
            $entityManager->persist($equipment);
            $entityManager->flush();

            return new Response('Saved new equipment with id ' . $equipment->getId());
        }

        return $this->render('create_equipment/index.html.twig');
    }

    #[Route('/fetch-equipments', name: 'fetch_equipments')]
    public function fetchEquipments(EntityManagerInterface $entityManager): Response
    {
        // Get the Doctrine EntityManager
        $entityManager = $this->getDoctrine()->getManager();

        // Fetch data from the Equipments entity
        $equipments = $entityManager->getRepository(Equipments::class)->findAll();

        // You can also use custom queries, for example:
        // $equipments = $entityManager->createQuery('SELECT e FROM App\Entity\Equipments e')->getResult();

        return $this->render('your_template.html.twig', [
            'equipments' => $equipments,
        ]);
    }
}

