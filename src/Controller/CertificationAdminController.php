<?php

namespace App\Controller;

use App\Entity\Certification;
use App\Form\CertificationType;
use App\Repository\CertificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/certification/admin')]
final class CertificationAdminController extends AbstractController
{
    #[Route(name: 'app_certification_admin_index', methods: ['GET'])]
    public function index(CertificationRepository $certificationRepository): Response
    {
        return $this->render('certification_admin/index.html.twig', [
            'certifications' => $certificationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_certification_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $certification = new Certification();
        $form = $this->createForm(CertificationType::class, $certification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($certification);
            $entityManager->flush();

            return $this->redirectToRoute('app_certification_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('certification_admin/new.html.twig', [
            'certification' => $certification,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_certification_admin_show', methods: ['GET'])]
    public function show(Certification $certification): Response
    {
        return $this->render('certification_admin/show.html.twig', [
            'certification' => $certification,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_certification_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Certification $certification, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CertificationType::class, $certification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_certification_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('certification_admin/edit.html.twig', [
            'certification' => $certification,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_certification_admin_delete', methods: ['POST'])]
    public function delete(Request $request, Certification $certification, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$certification->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($certification);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_certification_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
