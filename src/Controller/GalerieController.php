<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ObjetRepository;

final class GalerieController extends AbstractController
{
    #[Route('/galerie', name: 'app_galerie')]
    public function index(ObjetRepository $objetRepository): Response
    {
        $objets = $objetRepository->findAll();

        return $this->render('galerie/index.html.twig', [
            'objets' => $objets,
        ]);
    }
}
