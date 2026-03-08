<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FormationRepository;
// import FormationRepository to use its methods in ShopController (findAll)

final class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index(FormationRepository $formationRepository): Response
    // adding methods of FormationRepository (findAll)

    {
        $formations = $formationRepository->findAll();
        // ShopController => formationRepository => findAll() => formations (shop)
        // Data retrieval and storage in $formations (shop)

        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'formations' => $formations,
            // allows to use all the data of $formations in the Twig Shop with 'formations'
        ]);
    }
}
