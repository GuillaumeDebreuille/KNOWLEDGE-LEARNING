<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProgressRepository;

use App\Entity\Certification;
use Doctrine\ORM\EntityManagerInterface;

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




    #[Route('/certification/{lecon_id}', name: 'app_certification')]
        public function certification(int $lecon_id, EntityManagerInterface $em, \App\Repository\LeconRepository $leconRepository): Response
        {
            $user = $this->getUser();
            // user id recovery
            $lecon = $leconRepository->find($lecon_id);
            //We retrieve the lesson ID from the lesson database and store it here.
            
            $certification = new Certification();
            // creation of the new line in the database
            $certification -> setUser($user);
            $certification -> setLecon($lecon);
            $certification -> setCertificationOk(true);
            // We fill the 3 columns

            $em->persist($certification);
            $em->flush();
            // sending method

            return $this->redirectToRoute('app_lessons', ['id' => $lecon_id, 'certif' => 'ok']);
        }   // We return to the lesson/ID and add the certificate.

}