<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/add-role/{id}', name: 'admin_add_role')]
    public function addRole(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'utilisateur par son ID
        $user = $userRepository->find($id);
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        // Ajouter le rôle ADMIN
        $user->setRoles(['ROLE_ADMIN']);

        // Sauvegarder les modifications
        $entityManager->persist($user);
        $entityManager->flush();

        // Ajouter un message flash
        $this->addFlash('success', 'Le rôle ROLE_ADMIN a été ajouté à l\'utilisateur.');

        // Rediriger vers la page des utilisateurs
        return $this->redirectToRoute('admin_users');
    }

    #[Route('/admin/users', name: 'admin_users')]
    public function listUsers(UserRepository $userRepository): Response
    {
        // Récupérer tous les utilisateurs
        $users = $userRepository->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/remove-role/{id}', name: 'admin_remove_role')]
    public function removeRole(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'utilisateur par son ID
        $user = $userRepository->find($id);
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        // Retirer le rôle ADMIN
        $roles = $user->getRoles();
        $roles = array_diff($roles, ['ROLE_ADMIN']); // Supprimer le rôle
        $user->setRoles($roles);

        // Sauvegarder les modifications
        $entityManager->persist($user);
        $entityManager->flush();

        // Ajouter un message flash
        $this->addFlash('success', 'Le rôle ROLE_ADMIN a été retiré de l\'utilisateur.');

        // Rediriger vers la page des utilisateurs
        return $this->redirectToRoute('admin_users');
    }
}
