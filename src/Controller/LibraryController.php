<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;
use App\Repository\BookRepository;

class LibraryController extends AbstractController
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

    #[Route('/library/books/view', name: 'book_view_all', methods: ['GET'])]
    public function viewAllBooks(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();
        $pictures = [];

        foreach ($books as $book) {
            $picture = $book->getPicture();
            if ($picture) {
                $pictures[] = $picture;
            }
        }
        $dirPath = $this->getParameter('kernel.project_dir');
        $dirPath = is_string($dirPath) ? $dirPath.'/public/uploads' : '';
        $files = scandir($dirPath);
        if ($files) {
            foreach ($files as $file) {
                $filePath = $dirPath . '/' . $file;
                if (is_file($filePath) and (in_array($file, $pictures))) {
                    continue;
                }
                if ((substr($file, -4, 4) == '.jpg')) {
                    unlink($filePath);
                }
            }
        }

        $data = [
            'books' => $books,
        ];

        return $this->render('library/view.html.twig', $data);
    }

    #[Route('/library/book/view/', name: 'book_by_search_form_get', methods: ['GET'])]
    public function viewOneBookFormGet(
    ): Response {
        return $this->render('library/view_one_form.html.twig');
    }

    #[Route('/library/book/view/', name: 'book_by_search_form', methods: ['POST'])]
    public function viewOneBookFormPost(
        Request $request
    ): Response {
        $search = $request->request->get('search');

        return $this->redirectToRoute('book_by_search', [ 'search' => $search ]);
    }

    #[Route('/library/book/view/{search}', name: 'book_by_search', methods: ['GET'])]
    public function viewOneBook(
        BookRepository $bookRepository,
        string|int $search
    ): Response {
        $books = $bookRepository->findByExampleField($search);

        if (!$books) {
            $this->addFlash(
                'notice',
                'No book found for search '.$search
            );
            return $this->redirectToRoute('book_by_search_form_get');
        }

        $data = [
            'books' => $books,
            'search' => $search
        ];

        return $this->render('library/view_one.html.twig', $data);
    }

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
