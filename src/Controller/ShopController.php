<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FormationRepository;
// import FormationRepository to use its methods in ShopController (findAll)
use App\Repository\LeconRepository;
// import LeconRepository to use its methods in ShopController (findAll)
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
// import Request and SessionInterface to handle adding items to the cart in ShopController
use App\Repository\ProgressRepository;

final class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index(FormationRepository $formationRepository, LeconRepository $leconRepository, ProgressRepository $progressRepository): Response
    // adding methods of FormationRepository (findAll)
    // adding methods of LeconRepository (findAll)

    {
        $formations = $formationRepository->findAll();
        $lecons = $leconRepository->findAll();
        // ShopController => formationRepository => findAll() => formations (shop)
        // ShopController => leconRepository => findAll() => lecons (shop)
        // Data retrieval and storage in $formations and $lecons (shop)





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
        // The goal is to avoid showing products that are already owned.




        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'formations' => $formations,
            // allows to use all the data of $formations in the Twig Shop with 'formations'
            'lecons' => $lecons,
            // allows to use all the data of $lecons in the Twig Shop with 'lecons'
            'leconsOwned' => $leconsOwned,
            'formationsOwned' => $formationsOwned,
        ]);
    }





    #[Route('/shop/add-to-cart', name: 'app_cart_add')]
    public function addToCart(Request $request, SessionInterface $session): Response
    // Function to add items to the cart

    {
        $type = $request->get('type');
        // 'formation' or 'lecon'
        $id = $request->get('id');
        // ID of the item to add


        $cart = $session->get('cart', []);
        // Retrieve the current cart from the session, 
        // or initialize it as an empty array if it


        $cart[] = ['type' => $type, 'id' => $id];
        // Adding the item to the cart array


        $session->set('cart', $cart);
        // Storing the cart in the session
        

        return $this->redirectToRoute('app_shop');
    }
}
