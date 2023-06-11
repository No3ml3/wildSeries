<?php

namespace App\Repository;

use App\Entity\Program;
use App\Entity\Actor;
use App\Repository\ActorRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\AST\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Program>
 *
 * @method Program|null find($id, $lockMode = null, $lockVersion = null)
 * @method Program|null findOneBy(array $criteria, array $orderBy = null)
 * @method Program[]    findAll()
 * @method Program[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Program::class);
    }

    public function save(Program $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Program $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findLikeName(string $name)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->leftJoin('p.actors', 'a') // Jointure avec la table des acteurs
            ->where('p.title LIKE :name')
            ->orWhere('a.name LIKE :actor')
            ->setParameter('name', '%' . $name . '%')
            ->setParameter('actor', '%' . $name . '%')
            ->orderBy('p.title', 'ASC')
            ->getQuery();
    
        return $queryBuilder->getResult();
    }
}
