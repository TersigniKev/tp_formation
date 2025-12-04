<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Form\MembresType;
use App\Repository\MembresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class MembresController extends AbstractController
{
    #[Route('/', name: 'app_membres')]
    public function index(MembresRepository $membresRepository): Response
    {
        $membres = $membresRepository->findAll();

        return $this->render('membres/index.html.twig', [
            'controller_name' => 'MembresController',
            'membres' => $membres
        ]);
    }

    #[Route('/new', name: 'app_membres_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $membre = new Membres();
        $form = $this->createForm(MembresType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($membre);
            $entityManager->flush();
            $this->addFlash('success', 'le membre a bien été ajouté');

            return $this->redirectToRoute('app_membres', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('membres/new.html.twig', [
            'membre' => $membre,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_membres_delete', methods: ['POST'])]
    public function delete(Request $request, Membres $membre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membre->getIdMembre(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($membre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_membres', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit', name: 'app_membres_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Membres $membre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MembresType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_membres', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('membres/edit.html.twig', [
            'membre' => $membre,
            'form' => $form,
        ]);
    }


}
