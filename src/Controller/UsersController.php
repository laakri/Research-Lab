<?php

// src/Controller/UsersController.php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'app_users')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Get all users from the database
        $users = $entityManager->getRepository(User::class)->findAll();

        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
            'users' => $users,
        ]);
    }
    #[Route('/delete/user/{id}', name: 'app_delete_user')]
    public function deleteUser(User $user, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();

        // Add a flash message for success
        $this->addFlash('success', 'User deleted successfully!');

        // Redirect back to the user list
        return $this->redirectToRoute('app_users');
    }
}
