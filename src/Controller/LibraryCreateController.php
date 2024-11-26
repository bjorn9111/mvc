<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;

// use App\Repository\BookRepository;

class LibraryCreateController extends AbstractController
{
    #[Route('/library', name: 'app_library', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('library/index.html.twig');
    }

    #[Route('/library/create', name: 'book_create_get', methods: ['GET'])]
    public function createBookGet(
    ): Response {
        return $this->render('library/create.html.twig');
    }

    #[Route('/library/create', name: 'book_create', methods: ['POST'])]
    public function createBookPost(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();

        $book = new Book();
        $book->setISBN((string) $request->request->get('isbn'));
        $book->setTitle((string) $request->request->get('title'));
        $book->setAuthor((string) $request->request->get('author'));

        $picture = $request->files->get('picture');
        if ($picture) {
            $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
            $originalFilename = (string) $originalFilename;
            $newFilename = $originalFilename.'-'.uniqid().'.'.$picture->guessExtension();
            $destination = $this->getParameter('kernel.project_dir');
            $destination = is_string($destination) ? $destination.'/public/uploads' : '';
            $picture->move($destination, $newFilename);
            $book->setPicture($newFilename);
        }

        $entityManager->persist($book);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Saved new book with id '.$book->getId()
        );
        return $this->redirectToRoute('book_view_all');
    }
}
