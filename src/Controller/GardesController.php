<?php

namespace App\Controller;

use App\Entity\Gardes;
use App\Form\GardesType;
use App\Repository\GardesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/gardes')]
final class GardesController extends AbstractController
{
    #[Route(name: 'app_gardes_index', methods: ['GET'])]
    public function index(GardesRepository $gardesRepository): Response
    {
        return $this->render('gardes/index.html.twig', [
            'gardes' => $gardesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_gardes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $garde = new Gardes();
        $form = $this->createForm(GardesType::class, $garde);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($garde);
            $entityManager->flush();

            return $this->redirectToRoute('app_gardes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gardes/new.html.twig', [
            'garde' => $garde,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gardes_show', methods: ['GET'])]
    public function show(Gardes $garde): Response
    {
        return $this->render('gardes/show.html.twig', [
            'garde' => $garde,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gardes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gardes $garde, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GardesType::class, $garde);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_gardes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gardes/edit.html.twig', [
            'garde' => $garde,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gardes_delete', methods: ['POST'])]
    public function delete(Request $request, Gardes $garde, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$garde->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($garde);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_gardes_index', [], Response::HTTP_SEE_OTHER);
    }
}
