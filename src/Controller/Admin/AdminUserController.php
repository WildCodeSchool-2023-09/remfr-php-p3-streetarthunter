<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;

#[Route('/admin/user')]
class AdminUserController extends AbstractController
{
    #[Route('/', name: 'app_admin_user_index', methods: ['GET'])]
    public function index(
        UserRepository $userRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $form = $this->createFormBuilder(null, [
            'method' => 'get'
        ])
            ->add('search', SearchType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Recherche']
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
            $query = $userRepository->findByUsername($search);
        } else {
            $query = $userRepository->queryFindAll();
        }

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('admin/admin_user/index.html.twig', [
            'users' => $pagination,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'app_admin_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/admin_user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/admin_user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /*#[Route('/{id}', name: 'app_admin_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface
    $entityManager, ImageRepository $imageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {

            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
    }*/

    #[Route('/{id}', name: 'app_admin_user_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager,
        ImageRepository $imageRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            // Récupérer toutes les images associées à l'utilisateur
            $images = $imageRepository->findBy(['user' => $user]);

            // Supprimer chaque image
            foreach ($images as $image) {
                $entityManager->remove($image);
            }

            // Supprimer l'utilisateur
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
