<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Mark;
use Doctrine\ORM\Mapping;

class MarkRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, Mark::class);
	}

	/**
	 * @param $studentId
	 * @return Mark[]
	 */
	public function getAverageForStudent($studentId): array {
		$qb = $this->createQueryBuilder('m')
				   ->where('m.studentId = :studentId')
				   ->setParameter('studentId', $studentId);

		$query = $qb->getQuery();

		return $query->execute();
	}
}