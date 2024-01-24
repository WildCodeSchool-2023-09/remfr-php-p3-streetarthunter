<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CameraController extends AbstractController
{
    #[Route('/camera', name: 'app_camera')]
    public function index(ImageRepository $imageRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() &&$form->isValid()) {
           $image-> setUpdatedAt(new DateTimeImmutable());
           $entityManager->persist($image);
           $entityManager->flush();
           return $this->redirectToRoute('user_profil');
        }
        return $this->render('camera/index.html.twig', [
            'form' => $form,
        ]);
    }
}
