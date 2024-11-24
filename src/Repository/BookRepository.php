<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @param mixed $searchTerm The search term.
     *
    * @return Book[] Returns an array of Book objects
    */
    public function findByExampleField($searchTerm): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.id = :search')
            ->orWhere('b.isbn LIKE :search')
            ->orWhere('b.title LIKE :search')
            ->orWhere('b.author LIKE :search')
            ->setParameter('search', $searchTerm)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
