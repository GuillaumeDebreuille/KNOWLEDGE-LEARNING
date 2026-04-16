<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/user/{id}/edit', name: 'admin_user_edit', methods: ['POST'])]
    public function editUser(
        int $id,
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $em
    ): Response {
        $user = $userRepository->find($id);
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        // Récupérer les données du formulaire brut
        $email = $request->request->get('email');
        $role = $request->request->get('role');
        $isVerified = $request->request->get('isVerified');

        if ($email !== null) {
            $user->setEmail($email);
        }
        if ($role !== null) {
            $user->setRoles([$role]);
        }
        if ($isVerified !== null) {
            $user->setIsVerified((bool)$isVerified);
        }

        $em->flush();

        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/user/{id}/delete', name: 'admin_user_delete', methods: ['POST'])]
    public function deleteUser(
        int $id,
        UserRepository $userRepository,
        EntityManagerInterface $em
    ): Response {
        $user = $userRepository->find($id);
        if ($user) {
            // Supprimer les progress liés à cet utilisateur
            foreach ($user->getProgress() as $progress) {
                $em->remove($progress);
            }
            // Supprimer les certifications liées à cet utilisateur
            foreach ($user->getCertifications() as $certif) {
                $em->remove($certif);
            }
            $em->remove($user);
            $em->flush();
        }
        return $this->redirectToRoute('app_admin');
    }
}