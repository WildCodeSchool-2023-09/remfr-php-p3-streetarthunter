<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ranking', name: 'app_')]
class RankingController extends AbstractController
{
    #[Route('/', name: 'ranking')]
    public function index(): Response
    {
        return $this->render('ranking/index.html.twig');
    }
}
