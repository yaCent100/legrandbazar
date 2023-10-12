<?php

namespace App\Repository;

use App\Entity\Connexion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;


/**
 * @extends ServiceEntityRepository<Connexion>
 *
 * @method Connexion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Connexion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Connexion[]    findAll()
 * @method Connexion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConnexionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Connexion::class);
    }

    public function add(Connexion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Connexion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function getNbConnexionsLast7Days(User $user): int
    {
        $date = new \DateTime('-7 days');

        $qb = $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.user = :user')
            ->andWhere('c.createdAt >= :date')
            ->setParameter('user', $user)
            ->setParameter('date', $date);

        $result = $qb->getQuery()->getSingleScalarResult();

        return (int) $result;
    }

    public function countLast7DaysByUser($user)
    {
        $date = new \DateTime('-7 days');

        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.createdAt >= :date')
            ->andWhere('c.user = :user')
            ->setParameter('date', $date)
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }








    //    /**
    //     * @return Connexion[] Returns an array of Connexion objects
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

    //    public function findOneBySomeField($value): ?Connexion
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
