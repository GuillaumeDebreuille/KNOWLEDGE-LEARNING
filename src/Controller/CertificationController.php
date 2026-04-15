<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\CertificationRepository;



final class CertificationController extends AbstractController
{
    #[Route('/certification_list', name: 'app_certification_list')]
    public function index(CertificationRepository $certificationRepository): Response
    {

        $user = $this->getUser();
        $certification = $certificationRepository->findBy(['user' => $user]);
        $certificationOk = [];

        foreach ($certification as $row) {
            if ($row -> getLecon()) {
                $certificationOk[] = $row -> getLecon() -> getId();
            } 
        }




        return $this->render('certification/index.html.twig', [
            'controller_name' => 'CertificationController',
            'certificationOk' => $certificationOk,
        ]);
    
    }
}