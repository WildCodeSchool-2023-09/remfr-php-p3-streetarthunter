<?php

namespace App\Controller;

use App\Repository\ArtworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profil/carte', name: 'app_')]
class CarteController extends AbstractController
{
    #[Route('/', name: 'carte')]
    public function index(ArtworkRepository $artworkRepository): Response
    {
        $arts = $artworkRepository->findAll();
        return $this->render('carte/index.html.twig', ['arts' => $arts]);
    }

    #[Route('/art/{id}', methods:['GET'], name: 'show_art')]
    public function show(int $id, ArtworkRepository $artworkRepository): Response
    {
        $art = $artworkRepository->find(['id' => $id]);
        return $this->render('arts/artwork.html.twig', ['art' => $art]);
    }
}
