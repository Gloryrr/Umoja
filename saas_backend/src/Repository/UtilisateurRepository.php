<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Utilisateur>
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

        /**
        * @return Utilisateur[] Une liste contenant les informations utilisateurs
        */
    public function trouveUtilisateur(string $nom, string $mdp): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :nom')
            ->andWhere('u.mdpUtilisateur = :mdp')
            ->setParameter('nom', $nom)
            ->setParameter('mdp', $mdp)
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Utilisateur
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
