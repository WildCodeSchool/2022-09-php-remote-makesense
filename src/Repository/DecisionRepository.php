<?php

namespace App\Repository;

use App\Entity\Decision;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query;
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

    public function findFirstThreeByUser(UserInterface $user): array
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
    public function findAllByUser(UserInterface $user): array
    {
        $queryBuilder = $this->createQueryBuilder('d')
            ->join('d.timelines', 't')
            ->join('d.user', 'u')
            ->where('d.user = :user')
            ->andwhere("t.name = 'Prise de décision commencée'")
            ->setParameter('user', $user)
            ->orderBy('t.startedAt', 'DESC')
            ->setMaxResults(100)
            ->addSelect('d')
            ->addSelect('t')
            ->addSelect('u')
            ->getQuery();
        return $queryBuilder->getResult();
    }

    public function findAllByUserByStatus(UserInterface $user, string $search): array
    {
        $queryBuilder = $this->createQueryBuilder('d')
            ->join('d.timelines', 't')
            ->join('d.user', 'u')
            ->where('d.user = :user')
            ->andwhere('t.name = :search')
            ->andwhere('t.startedAt <= CURRENT_DATE()')
            ->andwhere('t.endedAt >= CURRENT_DATE()')
            ->setParameter('user', $user)
            ->setParameter('search', $search)
            ->orderBy('t.startedAt', 'DESC')
            ->setMaxResults(100)
            ->addSelect('d')
            ->addSelect('t')
            ->addSelect('u')
            ->getQuery();
        return $queryBuilder->getResult();
    }
}
