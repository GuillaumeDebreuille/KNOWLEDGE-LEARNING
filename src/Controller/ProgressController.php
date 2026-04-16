<?php

namespace App\Controller;

use App\Entity\Progress;
use App\Form\ProgressType;
use App\Repository\ProgressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/progress')]
final class ProgressController extends AbstractController
{
    #[Route(name: 'app_progress_index', methods: ['GET'])]
    public function index(ProgressRepository $progressRepository): Response
    {
        return $this->render('progress/index.html.twig', [
            'progress' => $progressRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_progress_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $progress = new Progress();
        $form = $this->createForm(ProgressType::class, $progress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($progress);
            $entityManager->flush();

            return $this->redirectToRoute('app_progress_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('progress/new.html.twig', [
            'progress' => $progress,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_progress_show', methods: ['GET'])]
    public function show(Progress $progress): Response
    {
        return $this->render('progress/show.html.twig', [
            'progress' => $progress,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_progress_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Progress $progress, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProgressType::class, $progress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_progress_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('progress/edit.html.twig', [
            'progress' => $progress,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_progress_delete', methods: ['POST'])]
    public function delete(Request $request, Progress $progress, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$progress->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($progress);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_progress_index', [], Response::HTTP_SEE_OTHER);
    }
}
