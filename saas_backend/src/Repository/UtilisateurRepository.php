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
    public function trouveUtilisateurByUsername(string $username, string $mdp): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :username')
            ->andWhere('u.mdpUtilisateur = :mdp')
            ->setParameter('username', $username)
            ->setParameter('mdp', $mdp)
            ->getQuery()
            ->getResult();
    }

    public function trouveUtilisateurByMail(string $email, string $mdp): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :nom')
            ->andWhere('u.mdpUtilisateur = :mdp')
            ->setParameter('emailUtilisateur', $email)
            ->setParameter('mdp', $mdp)
            ->getQuery()
            ->getResult();
    }

    public function inscritUtilisateur(mixed $data): Utilisateur
    {
        if ((empty($data['emailUtilisateur']) && empty($data['username']))) {
            throw new \InvalidArgumentException("L'email ou le username de l'utilisateur est requis.");
        } elseif (empty($data['mdpUtilisateur'])) {
            throw new \InvalidArgumentException("Le mot de passe utilisateur est requis.");
        }

        $utilisateur = new Utilisateur();
        $utilisateur->setEmailUtilisateur(!(empty($data['emailUtilisateur'])) ? $data['emailUtilisateur'] : "");
        $utilisateur->setMdpUtilisateur($data['mdpUtilisateur']);
        $utilisateur->setRoleUtilisateur("USER");
        $utilisateur->setUsername(!(empty($data['username'])) ? $data['username'] : "");
        $utilisateur->setNumTelUtilisateur($data['numTelUtilisateur'] ?? null);
        $utilisateur->setNomUtilisateur($data['nomUtilisateur'] ?? null);
        $utilisateur->setPrenomUtilisateur($data['prenomUtilisateur'] ?? null);

        try {
            $this->save($utilisateur, true);
            return $utilisateur;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement de l'utilisateur : " . $e->getMessage());
        }
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
