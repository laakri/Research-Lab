<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChercheurController extends AbstractController
{
    #[Route('/chercheur', name: 'app_liste_chercheur')]
    public function index(): Response
    {
        return $this->render('chercheur/index.html.twig', [
            'controller_name' => 'ChercheurController',
        ]);
    }
    
    #[Route('/profile-chercheur', name: 'app_profile_chercheur')]
    public function show(): Response
    {
        return $this->render('chercheur/profile.html.twig', [
            'controller_name' => 'ChercheurController',
        ]);
    }
}
