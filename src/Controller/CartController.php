<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FormationRepository;
use App\Repository\LeconRepository;
// import FormationRepository to use its methods in ShopController (findAll)
// import LeconRepository to use its methods in ShopController (findAll)
use Symfony\Component\HttpFoundation\Session\SessionInterface;
// import SessionInterface to handle cart data in the session for ShopController and CartController
use App\Repository\ProgressRepository;


final class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, FormationRepository $formationRepository, LeconRepository $leconRepository, ProgressRepository $progressRepository): Response
    // Function to display the cart contents
    // Adding FormationRepository and LeconRepository to retrieve item details for display in the cart
    {


        // exemple of cart data structure in the session:
        // $cart = [ ['type' => 'formation', 'id' => 1], ['type' => 'lecon', 'id' => 2] ];
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



        $user = $this->getUser();
        $progress = $progressRepository->findBy(['user' => $user]);
        // AccountController => progressRepository => findBy() => progress (account)

        $leconsOwned = [];

        foreach ($progress as $row) {
            if ($row -> getLecon()) {
                $leconsOwned[] = $row -> getLecon() -> getId();
            }
        }
        // allows you to create two lists: a list of lessons owned by the user and a list of courses owned by the user.
        // These lists will allow lessons and training to be displayed in the Twigs thanks to leconsOwned and formationsOwned
        // The goal is to check if the user has already completed a lesson from the training.



        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cart' => $cart,
            // allows to use all the data of $cart in the Twig Cart with 'cart'
            'formations' => $formations,
            // allows to use all the data of $formations in the Twig Shop with 'formations'
            'lecons' => $lecons,
            // allows to use all the data of $lecons in the Twig Shop with 'lecons'
            'leconsOwned' => $leconsOwned,
            'allLecons' => $leconRepository->findAll(),
        ]);
    }



    #[Route('/cart/remove/{type}/{id}', name: 'app_cart_remove')]
    public function remove(string $type, int $id, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        $cart = array_filter($cart, function ($item) use ($type, $id) {
            return !($item['type'] === $type && $item['id'] == $id);
        });
        // We filter the basket to remove the corresponding item

        $cart = array_values($cart);
        $session->set('cart', $cart);
        // We reindex the table to avoid gaps in the keys


        return $this->redirectToRoute('app_cart');
    }
}
