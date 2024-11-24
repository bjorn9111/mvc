<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;

class LibraryControllerJson extends AbstractController
{
    #[Route("/api/library/books", name: 'book_show_all', methods: ['GET'])]
    public function showAllBook(
        BookRepository $bookRepository
    ): Response {
        $data = $bookRepository->findAll();
        $response = $this->json($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route('/api/library/book/{isbn}', name: 'book_by_isbn')]
    public function showBookByISBN(
        BookRepository $bookRepository,
        string $isbn
    ): Response {
        // $data = array(1 => $isbn);
        $data = $bookRepository->findOneBy(['isbn' => $isbn]);

        $response = $this->json($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
