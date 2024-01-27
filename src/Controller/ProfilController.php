<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    #[Route('/profil/', name: 'user_profil')]
    public function index(User $user, UserRepository $userRepository): Response
    {
        return $this->render('user/profil.html.twig', [
        ]);
    }
}
