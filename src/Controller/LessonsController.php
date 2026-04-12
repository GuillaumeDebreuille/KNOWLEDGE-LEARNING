<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LessonsController extends AbstractController
{
    #[Route('/lessons/{id}', name: 'app_lessons')]
    public function show(int $id): Response
    {
        return $this->render('lessons/index.html.twig', [
            'controller_name' => 'LessonsController',
            'lecon_id' => $id,
        ]);
    }
}
