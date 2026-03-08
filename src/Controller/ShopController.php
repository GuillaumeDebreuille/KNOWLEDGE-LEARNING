<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FormationRepository;
// import FormationRepository to use its methods in ShopController (findAll)
use App\Repository\LeconRepository;
// import LeconRepository to use its methods in ShopController (findAll)

final class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index(FormationRepository $formationRepository, LeconRepository $leconRepository): Response
    // adding methods of FormationRepository (findAll)
    // adding methods of LeconRepository (findAll)

    {
        $formations = $formationRepository->findAll();
        $lecons = $leconRepository->findAll();
        // ShopController => formationRepository => findAll() => formations (shop)
        // ShopController => leconRepository => findAll() => lecons (shop)
        // Data retrieval and storage in $formations and $lecons (shop)

        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'formations' => $formations,
            // allows to use all the data of $formations in the Twig Shop with 'formations'
            'lecons' => $lecons,
            // allows to use all the data of $lecons in the Twig Shop with 'lecons'
        ]);
    }
}
