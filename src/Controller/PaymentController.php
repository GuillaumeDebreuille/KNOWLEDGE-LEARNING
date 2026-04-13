<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\FormationRepository;
use App\Repository\LeconRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Repository\ProgressRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Progress;
use Symfony\Component\HttpFoundation\Request;

final class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment')]
    public function index(SessionInterface $session, FormationRepository $formationRepository, LeconRepository $leconRepository): Response
    {

        $cart = $session->get('cart', []);
        $formations = [];
        $lecons = [];
        // Retrieve the cart from the session, or initialize it as an empty array if it doesn't exist
        foreach ($cart as $item) {
            if ($item['type'] === 'formation') {
                $formations[] = $formationRepository->find($item['id']);
                // Retrieve formation details for each item in the cart
            } elseif ($item['type'] === 'lecon') {
                $lecons[] = $leconRepository->find($item['id']);
                // Retrieve lecon details for each item in the cart
            }
        }


        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
            'formations' => $formations,
            'lecons' => $lecons,
        ]);
    }





    #[Route('/payment/validate', name: 'app_payment_validate', methods: ['POST'])]
    public function validate(
        SessionInterface $session, FormationRepository $formationRepository, LeconRepository $leconRepository, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $cart = $session->get('cart', []);

        foreach ($cart as $item) {
            $progress = new Progress();
            $progress->setUser($user);
            $progress->setLeconValidated(false);
            $progress->setFormationValidated(false);

            if ($item['type'] === 'formation') {
                $formation = $formationRepository->find($item['id']);
                $progress->setFormation($formation);
            } elseif ($item['type'] === 'lecon') {
                $lecon = $leconRepository->find($item['id']);
                $progress->setLecon($lecon);
            }

            $em->persist($progress);
        }
        $em->flush();

        // Empty cart
        $session->set('cart', []);

        // Redirect to account or confirmation page
        return $this->redirectToRoute('app_account');
    }

}