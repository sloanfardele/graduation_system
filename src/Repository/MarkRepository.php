<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\Mark;

class MarkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mark::class);
    }

    /**
     * @param $studentId
     * @return Mark[]
     */
    public function getAverageForStudent($studentId): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT m
			FROM App\Entity\Mark m
			WHERE m.studentId = :studentId'
        )->setParameter('studentId', $studentId);

        return $query->getResult();
    }
}
