<?php

namespace App\Repository;

use App\Entity\Decision;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Decision>
 *
 * @method Decision|null find($id, $lockMode = null, $lockVersion = null)
 * @method Decision|null findOneBy(array $criteria, array $orderBy = null)
 * @method Decision[]    findAll()
 * @method Decision[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DecisionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Decision::class);
    }

    public function save(Decision $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Decision $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Decision[] Returns an array of Decision objects
     */
    public function findAllByTimeline(): array
    {
        $queryBuilder = $this->createQueryBuilder('d')
            ->join('d.timelines', 't')
            ->where('t.startedAt > CURRENT_DATE()')
            ->orderBy('t.startedAt', 'ASC')
            ->addSelect('d')->addSelect('t')
            ->getQuery();
        return $queryBuilder->getResult();
    }

    public function findAllByUser(UserInterface $user): array
    {
        $queryBuilder = $this->createQueryBuilder('d')
            ->join('d.timelines', 't')
            ->join('d.user', 'u')
            ->where('t.startedAt > CURRENT_DATE()')
            ->andwhere('d.user = :user')
            ->setParameter('user', $user)
            ->orderBy('t.startedAt', 'ASC')
            ->setMaxResults(3)
            ->addSelect('d')
            ->addSelect('t')
            ->addSelect('u')
            ->getQuery();
        return $queryBuilder->getResult();
    }

    public function findAllByContributor(UserInterface $user): array
    {
        $queryBuilder = $this->createQueryBuilder('d')
            ->join('d.contributors', 'c')
            ->join('c.employee', 'e')
            ->join('e.user', 'u')
            ->join('d.timelines', 't')
            ->where('u.id = :user')
            ->andwhere('t.endedAt > CURRENT_DATE()')
            ->andwhere("t.name = ':deadline pour donner son avis'")
            ->orwhere("t.name = ':deadline pour entrer en conflit'")
            ->setParameter('user', $user)
            ->orderBy('t.endedAt', 'ASC')
            ->setMaxResults(3)
            ->addSelect('d')
            ->addSelect('e')
            ->addSelect('u')
            ->addSelect('c')
            ->addSelect('t')
            ->getQuery();
        return $queryBuilder->getResult();
    }

//    public function findOneBySomeField($value): ?Decision
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
