<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProgressRepository;

final class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(ProgressRepository $progressRepository): Response
    {

        $user = $this->getUser();
        $progress = $progressRepository->findBy(['user' => $user]);
        // AccountController => progressRepository => findBy() => progress (account)



        $leconsOwned = [];
        $formationsOwned = [];

        foreach ($progress as $row) {
            if ($row -> getLecon()) {
                $leconsOwned[] = $row -> getLecon() -> getId();
            }
            if ($row -> getFormation()) {
                $formationsOwned[] = $row -> getFormation() -> getId();
            }
        }
        // allows you to create two lists: a list of lessons owned by the user and a list of courses owned by the user.
        // These lists will allow lessons and training to be displayed in the Twigs thanks to leconsOwned and formationsOwned



        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'mail' => $user->getEmail(),
            'progress' => $progress,
            'leconsOwned' => $leconsOwned,
            'formationsOwned' => $formationsOwned
        ]);
    }
}
