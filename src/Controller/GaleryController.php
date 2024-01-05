<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GaleryController extends AbstractController
{
    #[Route('/galery/', name: 'app_galery')]
    public function index(): Response
    {
        return $this->render('home/galery.html.twig');
    }
}
