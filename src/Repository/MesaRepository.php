<?php

namespace App\Repository;

use App\Entity\Mesa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mesa>
 *
 * @method Mesa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mesa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mesa[]    findAll()
 * @method Mesa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MesaRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Mesa::class);
        $this->manager = $manager;
    }

    public function save(Mesa $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Mesa $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function saveMesa($anchura, $altura, $x = null, $y = null)
    {
        $newMesa = new Mesa();

        $newMesa
            ->setAnchura($anchura)
            ->setAltura($altura)
            ->setX($x)
            ->setY($y);

        $this->manager->persist($newMesa);
        $this->manager->flush();

        return $newMesa;
    }

    public function updateMesa(Mesa $mesa): Mesa
    {
        $this->manager->persist($mesa);
        $this->manager->flush();

        return $mesa;
    }

    public function removeMesa(Mesa $mesa)
    {
        $this->manager->remove($mesa);
        $this->manager->flush();
    }

    //    /**
    //     * @return Mesa[] Returns an array of Mesa objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Mesa
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
