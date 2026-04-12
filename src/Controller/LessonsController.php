<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProgressRepository;

final class LessonsController extends AbstractController
{
    #[Route('/lessons/{id}', name: 'app_lessons')]
    public function show(int $id, ProgressRepository $progressRepository): Response
    {



                    // !!!!! Sécurity check !!!!!
        // To display the Twig, we need : URL identifier (provided directly) + whether the user purchased the lesson or training.
        
        $user = $this->getUser();
        $progress = $progressRepository->findBy(['user' => $user]);
        // 1) We retrieve the user's lines from the "progress" database using their ID.

        $leconsOwned = [];
        $formationsOwned = [];
        // 2) We create the two tables that will contain this data.

        foreach ($progress as $row) {
            if ($row -> getLecon()) {
                $leconsOwned[] = $row -> getLecon() -> getId();
            }
            if ($row -> getFormation()) {
                $formationsOwned[] = $row -> getFormation() -> getId();
            }
        }
        // 3) We complete the tables with the lessons and training acquired.



        return $this->render('lessons/index.html.twig', [
            'controller_name' => 'LessonsController',
            'lecon_id' => $id,
            'leconsOwned' => $leconsOwned, // Sécurity check
            'formationsOwned' => $formationsOwned // Sécurity check
        ]);
    }
}
