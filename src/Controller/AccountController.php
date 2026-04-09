<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(ProgressRepository $progressRepository): Response
    {

        $user = $this->getUser();
        $progress = $progressRepository->findBy(['user' => $user]);
        // AccountController => progressRepository => findBy() => progress (account)

        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'mail' => $user->getEmail(),
        ]);
    }
}
