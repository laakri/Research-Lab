<?php
// src/Controller/CreateEquipmentController.php
// src/Controller/CreateEquipmentController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Equipments;
use App\Repository\EquipmentsRepository;
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
            $equipments = $entityManager->getRepository(Equipments::class)->findAll();
        
        }
        $equipments = $entityManager->getRepository(Equipments::class)->findAll();

        return $this->render('create_equipment/index.html.twig', ['equipments' => $equipments]);
    }
    #[Route('/delete/{id}', name: 'equipment_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $equipment = $entityManager->getRepository(Equipments::class)->find($id);

        $entityManager->remove($equipment);
        $entityManager->flush();
        $this->addFlash(
            'warning',
            'Produit supprime avec succes...'
        );

        return $this->redirectToRoute('create_equipment');
    }

    #[Route('/equipment/update/{id}', name: 'app_equipment_update')]
    public function update($id,Request $request, EquipmentsRepository $repos,EntityManagerInterface $em): Response
    {

        $equipment = $repos->find($id);
        if (!$equipment) {
            throw $this->createNotFoundException('Equipment not found');
        }


        $name = $request->request->get('equipment');
        $description = $request->request->get('description');
        $equipment->setName($name);
        $equipment->setDescription($description);


     
       $em->persist($equipment);
       $em->flush(); 
        
        return $this->redirectToRoute('create_equipment');
    }

    #[Route('/equipment/disponibility/{id}', name: 'app_equipment_dispo')]
    public function statusEquipment(Request $request, EntityManagerInterface $entityManager, int $id)
    {
        $equipment = $entityManager->getRepository(Equipments::class)->find($id);
    
        if (!$equipment) {
            throw $this->createNotFoundException('Equipment not found');
        }
    
        $disponibility = $request->request->get('is_active');
        $equipment->setDisponibility($disponibility);
    
        $entityManager->flush();
    
        $status = $disponibility == 0 ? 'Pas Active' : 'Active';
    
        return $this->json([
            'response' => 'success',
            'message' => 'Status updated successfully',
            'id' => $id,
            'status' => $status,
        ]);
    }
    
    
}
