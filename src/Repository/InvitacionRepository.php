<?php

namespace App\Repository;

use App\Entity\Invitacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Invitacion>
 *
 * @method Invitacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invitacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invitacion[]    findAll()
 * @method Invitacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvitacionRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Invitacion::class);
        $this->manager = $manager;
    }

    public function save(Invitacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Invitacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function saveInvitacion($evento, $usuario, $presentado = 0)
    {
        //dd(var_dump($invitacion));
        $newInvitacion = new Invitacion();

        $newInvitacion
            ->setEvento($evento)
            ->setUsuario($usuario)
            ->setPresentado($presentado);

        $this->manager->persist($newInvitacion);
        $this->manager->flush();

        return $newInvitacion;
    }

    /**
     * @return Invitacion[] Returns an array of Invitacion objects
     */
    public function findByExampleField($evento): array
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.evento = :val')
            ->setParameter('val', $evento)
            ->orderBy('i.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    //    public function findOneBySomeField($value): ?Invitacion
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
