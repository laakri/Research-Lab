<?php

namespace App\Controller;

use App\Entity\Equipments;
use App\Entity\EquipProj;
use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class ProjectDetailsController extends AbstractController
{
    #[Route('/project/details/{id}', name: 'app_project_details')]
    public function index(Project $id ,EntityManagerInterface $entityManager): Response
    {
        $projects = $entityManager->getRepository(Project::class)->find($id);
        $equipments = $entityManager->getRepository(EquipProj::class)->findAll();
        $equip = $entityManager->getRepository(Equipments::class)->findAll();


        return $this->render('project_details/index.html.twig', [
           'projects'=>$projects,
           'equipments'=>$equipments,
           'equip'=>$equip,
        ]);
    }
}
