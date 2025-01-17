<?php

namespace App\Controller;

use App\Repository\ObjetRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


final class HomeController extends AbstractController{
    #[Route('/', name: 'app_home')]
public function index(ObjetRepository $objetRepository): Response
{
    
    $derniersObjets = $objetRepository->findBy([], ['id' => 'DESC'], 4);

    return $this->render('home/index.html.twig', [
        'objets' => $derniersObjets, 
    ]);
}
}