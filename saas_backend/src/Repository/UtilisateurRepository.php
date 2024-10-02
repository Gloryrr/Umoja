<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Classe UtilisateurRepository
 * Repository pour l'entité Utilisateur, étendant ServiceEntityRepository pour interagir avec la base de données.
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    /**
     * Constructeur.
     *
     * @param ManagerRegistry $registry Le registre des gestionnaires d'entités.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    /**
     * Trouve un utilisateur par son nom d'utilisateur et mot de passe.
     *
     * @param string $username Le nom d'utilisateur à rechercher.
     * @param string $mdp Le mot de passe de l'utilisateur.
     * @return Utilisateur[] Une liste d'utilisateurs correspondant aux critères.
     */
    public function trouveUtilisateurByUsername(string $username, string $mdp): array
    {
        try {
            return $this->createQueryBuilder('u')
            ->andWhere('u.username = :username')
            ->andWhere('u.mdpUtilisateur = :mdp')
            ->setParameter('username', $username)
            ->setParameter('mdp', $mdp)
            ->getQuery()
            ->getResult();
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la récupération", $e->getCode());
        }
    }

    /**
     * Trouve un utilisateur par son e-mail et mot de passe.
     *
     * @param string $email L'email de l'utilisateur à rechercher.
     * @param string $mdp Le mot de passe de l'utilisateur.
     * @return Utilisateur[] Une liste d'utilisateurs correspondant aux critères.
     */
    public function trouveUtilisateurByMail(string $email, string $mdp): array
    {
        try {
            return $this->createQueryBuilder('u')
                ->andWhere('u.emailUtilisateur = :email')
                ->andWhere('u.mdpUtilisateur = :mdp')
                ->setParameter('email', $email)
                ->setParameter('mdp', $mdp)
                ->getQuery()
                ->getResult();
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la récupération", $e->getCode());
        }
    }

    /**
     * Inscrit un nouvel utilisateur dans la base de données.
     *
     * @param mixed $data Les données de l'utilisateur.
     * @param Utilisateur $utilisateur L'objet utilisateur à persister.
     * @return bool Indique si l'inscription a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function inscritUtilisateur(Utilisateur $utilisateur): bool
    {
        try {
            $this->getEntityManager()->persist($utilisateur);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement de l'utilisateur : " . $e->getCode());
        }
    }

    /**
     * Met à jour un utilisateur existant dans la base de données.
     *
     * @param mixed $data Les données de l'utilisateur.
     * @param Utilisateur $utilisateur L'objet utilisateur à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function updateUtilisateur(Utilisateur $utilisateur): ?bool
    {
        try {
            $this->getEntityManager()->persist($utilisateur);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'update de l'utilisateur", $e->getCode());
        }
    }

    /**
     * Supprime un utilisateur de la base de données.
     *
     * @param Utilisateur $utilisateur L'utilisateur à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function removeUtilisateur(Utilisateur $utilisateur): ?bool
    {
        try {
            $this->getEntityManager()->remove($utilisateur);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression de l'utilisateur", $e->getCode());
        }
    }
}