<?php

namespace App\Repository;

use App\Entity\Reserva;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reserva>
 *
 * @method Reserva|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reserva|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reserva[]    findAll()
 * @method Reserva[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservaRepository extends ServiceEntityRepository
{
    private $mesaRepository;
    private $userRepository;
    private $juegoRepository;
    private $manager;
    public function __construct(ManagerRegistry $registry, MesaRepository $mesaRepository, UserRepository $userRepository, JuegoRepository $juegoRepository, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Reserva::class);
        $this->mesaRepository = $mesaRepository;
        $this->userRepository = $userRepository;
        $this->juegoRepository = $juegoRepository;
        $this->manager = $manager;
    }

    public function save(Reserva $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reserva $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function saveReserva($fechaInicio, $fechaFin, $fechaCancelacion, $presentado, $mesaId, $userId, $juegoId)
    {
        $newReserva = new Reserva();

        $newReserva
            ->setFechaInicio(new DateTime($fechaInicio))
            ->setFechaFin(new DateTime($fechaFin))
            ->setFechaCancelacion(new DateTime($fechaCancelacion))
            ->setPresentado($presentado)
            ->setMesa($this->mesaRepository->findOneBy(['id' => $mesaId]))
            ->setUser($this->userRepository->findOneBy(['id' => $userId]))
            ->setJuego($this->juegoRepository->findOneBy(['id' => $juegoId]));

        $this->manager->persist($newReserva);
        $this->manager->flush();

        return $newReserva;
    }

    public function updateReserva(Reserva $reserva): Reserva
    {
        $this->manager->persist($reserva);
        $this->manager->flush();

        return $reserva;
    }

    public function removeReserva(Reserva $reserva)
    {
        $this->manager->remove($reserva);
        $this->manager->flush();
    }

    //    /**
    //     * @return Reserva[] Returns an array of Reserva objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reserva
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
