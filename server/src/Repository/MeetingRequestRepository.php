<?php

namespace App\Repository;

use App\Entity\MeetingRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MeetingRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method MeetingRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method MeetingRequest[]    findAll()
 * @method MeetingRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeetingRequestRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MeetingRequest::class);
    }

//    /**
//     * @return MeetingRequest[] Returns an array of MeetingRequest objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MeetingRequest
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
