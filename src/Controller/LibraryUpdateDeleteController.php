<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;
use App\Repository\BookRepository;

class LibraryUpdateDeleteController extends AbstractController
{
    #[Route('/library/update/{id}', name: 'book_update_get', methods: ['GET'])]
    public function updateBookGet(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->findOneBy(['id' => $id]);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $data = [
            'id' => $id,
            'book' => $book
        ];

        return $this->render('library/update.html.twig', $data);
    }

    #[Route('/library/update', name: 'book_update', methods: ['POST'])]
    public function updateBookPost(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $id = $request->request->get('id');
        $picture = $request->files->get('picture');
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->findOneBy(['id' => $id]);

        if ($book) {
            $book->setIsbn((string) $request->request->get('isbn'));
            $book->setTitle((string) $request->request->get('title'));
            $book->setAuthor((string) $request->request->get('author'));

            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                $originalFilename = (string) $originalFilename;
                $newFilename = $originalFilename.'-'.uniqid().'.'.$picture->guessExtension();
                $destination = $this->getParameter('kernel.project_dir');
                $destination = is_string($destination) ? $destination.'/public/uploads' : '';
                $picture->move($destination, $newFilename);
                $book->setPicture($newFilename);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('book_view_all');
    }

    #[Route('/library/delete/{id}', name: 'book_delete_get', methods: ['GET'])]
    public function deleteBookGet(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->findOneBy(['id' => $id]);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $data = [
            'id' => $id,
            'book' => $book
        ];

        return $this->render('library/delete.html.twig', $data);
    }

    #[Route('/library/delete', name: 'book_delete', methods: ['POST'])]
    public function deleteBookPost(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $id = $request->request->get('id');
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->findOneBy(['id' => $id]);

        if ($book) {
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('book_view_all');
    }
}
