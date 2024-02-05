<?php

namespace App\Controller\Admin;

use App\Entity\Artwork;
use App\Form\ArtworkType;
use App\Repository\ArtworkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/artwork', name: 'app_admin_artwork_')]
class ArtworkController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(
        ArtworkRepository $artworkRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $form = $this->createFormBuilder(null, [
            'method' => 'get'
        ])
            ->add('search', SearchType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Rechercher par ville'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
            $query = $artworkRepository->findLikeCity($search);
        } else {
            $query = $artworkRepository->findAll();
        }

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );
        return $this->render('/admin/artwork/index.html.twig', [
            'artworks' => $pagination,
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $artwork = new Artwork();
        $formArtwork = $this->createForm(ArtworkType::class, $artwork);

        $formArtwork->handleRequest($request);

        if ($formArtwork->isSubmitted() && $formArtwork->isValid()) {
            $entityManager->persist($artwork);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_artwork_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('/admin/artwork/new.html.twig', [
            'artwork' => $artwork,
            'formArtwork' => $formArtwork,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Artwork $artwork,
        EntityManagerInterface $entityManager
    ): Response {
        $formArtwork = $this->createForm(ArtworkType::class, $artwork);
        $formArtwork->handleRequest($request);

        if ($formArtwork->isSubmitted() && $formArtwork->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_artwork_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('/admin/artwork/edit.html.twig', [
            'artwork' => $artwork,
            'formArtwork' => $formArtwork,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Artwork $artwork, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $artwork->getId(), $request->request->get('_token'))) {
            $entityManager->remove($artwork);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_artwork_index', [], Response::HTTP_SEE_OTHER);
    }
}
