<?php

namespace App\Controller;

use App\Entity\Objet;
use App\Form\ObjetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ObjetController extends AbstractController
{
    #[Route('/objet/new', name: 'objet_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $objet = new Objet();

        $form = $this->createForm(ObjetType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($objet);    
            $entityManager->flush();

            $this->addFlash('success', 'L\'objet a été ajouté avec succès !');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('objet/new.html.twig', [
            'objetForm' => $form->createView(),
        ]);
    }
    #[Route('/objet/{id}', name: 'objet_show')]
    public function show(int $id, ObjetRepository $objetRepository): Response
    {
        // Récupérer l'objet correspondant à l'ID
        $objet = $objetRepository->find($id);

        if (!$objet) {
            throw $this->createNotFoundException('Objet non trouvé.');
        }

        // Afficher les détails de l'objet
        return $this->render('objet/show.html.twig', [
            'objet' => $objet,
        ]);
    }
    #[Route('/objet/edit/{id}', name: 'objet_edit')]
    public function edit(Request $request, Objet $objet, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'utilisateur est le créateur ou qu'il a un rôle ADMIN
        $this->denyAccessUnlessGranted('edit', $objet);

        $form = $this->createForm(ObjetType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'L\'objet a été modifié avec succès !');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('objet/edit.html.twig', [
            'objetForm' => $form->createView(),
        ]);
    }
    #[Route('/objet/delete/{id}', name: 'objet_delete')]
    public function delete(Objet $objet, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'utilisateur est le créateur ou qu'il a un rôle ADMIN
        $this->denyAccessUnlessGranted('delete', $objet);

        $entityManager->remove($objet);
        $entityManager->flush();

        $this->addFlash('success', 'L\'objet a été supprimé avec succès !');

        return $this->redirectToRoute('app_home');
    }



}