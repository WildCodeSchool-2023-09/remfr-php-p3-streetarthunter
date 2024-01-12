<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/', name: 'app_')]
class ContactController extends AbstractController
{
    #[Route('contact', name: 'contact')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('contact/index.html.twig', ['form' => $form]);
    }
}
