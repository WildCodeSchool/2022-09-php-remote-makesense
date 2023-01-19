<?php

namespace App\Repository;

use App\Entity\Contributor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Contributor>
 *
 * @method Contributor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contributor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contributor[]    findAll()
 * @method Contributor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContributorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contributor::class);
    }

    public function save(Contributor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Contributor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findOneContributorBy(UserInterface $user, int $decisionId): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->join('c.decision', 'd')
            ->join('c.employee', 'e')
            ->join('e.user', 'u')
            ->where('d.id = :decisionId')
            ->andwhere('u.id = :user')
            ->setParameter('user', $user)
            ->setParameter('decisionId', $decisionId)
            ->addSelect('c')
            ->addSelect('d')
            ->addSelect('e')
            ->addSelect('u')
            ->getQuery();
        return $queryBuilder->getResult();
    }

    public function findAllContributorsBy(UserInterface $user): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->join('c.decision', 'd')
            ->join('c.employee', 'e')
            ->join('e.user', 'u')
            ->join('d.timelines', 't')
            ->where('u.id = :user')
            ->andwhere('t.endedAt > CURRENT_DATE()')
            ->andwhere("t.name LIKE '%avis%'")
            ->orwhere("t.name LIKE '%conflit%'")
            ->setParameter('user', $user)
            ->orderBy('t.endedAt', 'ASC')
            ->addSelect('c')
            ->addSelect('d')
            ->addSelect('e')
            ->addSelect('u')
            ->addSelect('t')
            ->getQuery();
        return $queryBuilder->getResult();
    }
//    /**
//     * @return Contributor[] Returns an array of Contributor objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Contributor
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
