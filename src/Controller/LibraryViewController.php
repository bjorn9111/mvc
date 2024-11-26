<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;

class LibraryViewController extends AbstractController
{
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
        if (! empty($files)) {
            foreach ($files as $file) {
                $filePath = $dirPath . '/' . $file;
                // if (is_file($filePath) and (in_array($file, $pictures))) {
                //     continue;
                // }
                if (in_array(substr($file, -4, 4), array('.jpg', '.png'))
                    and (! in_array($file, $pictures))) {
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

        if (empty($books)) {
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
}
