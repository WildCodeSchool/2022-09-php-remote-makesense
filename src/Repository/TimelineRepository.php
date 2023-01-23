<?php

namespace App\Repository;

use App\Entity\Timeline;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Timeline>
 *
 * @method Timeline|null find($id, $lockMode = null, $lockVersion = null)
 * @method Timeline|null findOneBy(array $criteria, array $orderBy = null)
 * @method Timeline[]    findAll()
 * @method Timeline[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimelineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Timeline::class);
    }

    public function save(Timeline $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Timeline $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllByContributor(UserInterface $user): array
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->join('t.decision', 'd')
            ->join('d.contributors', 'c')
            ->join('c.implication', 'i')
            ->join('c.employee', 'e')
            ->join('e.user', 'u')
            ->where('u.id = :user')
            ->andwhere('t.endedAt > CURRENT_DATE()')
            ->andwhere("t.name LIKE '%avis%' OR t.name LIKE '%conflit%'")
            ->setParameter('user', $user)
            ->orderBy('t.endedAt', 'ASC')
            ->setMaxResults(3)
            ->addSelect('d')
            ->addSelect('e')
            ->addSelect('u')
            ->addSelect('c')
            ->addSelect('i')
            ->addSelect('t')
            ->getQuery();
        return $queryBuilder->getResult();
    }
}
