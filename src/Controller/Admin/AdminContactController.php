<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Form\Contact1Type;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/contact')]
class AdminContactController extends AbstractController
{
    #[Route('/', name: 'app_admin_contact_index', methods: ['GET'])]
    public function index(
        ContactRepository $contactRepository,
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
            $query = $contactRepository->findByUsername($search);
        } else {
            $query = $contactRepository->queryFindAll();
        }

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('admin/admin_contact/index.html.twig', [
            'contacts' => $pagination,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'app_admin_contact_show', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        return $this->render('admin/admin_contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_contact_index', [], Response::HTTP_SEE_OTHER);
    }
}
