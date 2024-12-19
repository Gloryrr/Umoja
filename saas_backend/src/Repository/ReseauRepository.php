<?php

namespace App\Repository;

use App\Entity\Reseau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Classe ReseauRepository
 * Repository pour l'entité Reseau, étendant ServiceEntityRepository pour interagir avec la base de données.
 * @extends ServiceEntityRepository<Reseau>
 */
class ReseauRepository extends ServiceEntityRepository
{
    /**
     * Constructeur.
     *
     * @param ManagerRegistry $registry Le registre des gestionnaires d'entités.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reseau::class);
    }


    /**
     * Trouve un réseau par son nom.
     *
     * @param string $username Le nom du genre à rechercher.
     * @return Reseau[] Une liste de réseau correspondant aux critères.
     */
    public function trouveReseauByName(string $nomReseau): array
    {
        try {
            return $this->createQueryBuilder('r')
            ->andWhere('r.nomReseau = :nomReseau')
            ->setParameter('nomReseau', $nomReseau)
            ->getQuery()
            ->getResult();
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la récupération du réseau", $e->getCode());
        }
    }

    /**
     * Trouve les réseaux d'un utilisateur par son username.
     *
     * @param string $username Le nom de l'utilisateur à rechercher.
     * @return Reseau[] Une liste de réseaux correspondant aux critères.
     */
    public function trouveReseauxUtilisateur(string $username): array
    {
        try {
            return $this->createQueryBuilder('r')
                ->innerJoin('r.utilisateurs', 'a')
                ->innerJoin('a.reseaux', 'u')
                ->andWhere('a.username = :username')
                ->setParameter('username', $username)
                ->getQuery()
                ->getResult();
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la récupération des réseaux de l'utilisateur : " . $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Inscrit un nouveau réseau dans la base de données.
     *
     * @param mixed $data Les données du réseau.
     * @param Reseau $reseau L'objet du réseau à persister.
     * @return bool Indique si l'inscription a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function inscritReseau(Reseau $reseau): bool
    {
        try {
            $this->getEntityManager()->persist($reseau);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement du réseau : " . $e->getCode());
        }
    }

    /**
     * Met à jour un réseau existant dans la base de données.
     *
     * @param mixed $data Les nouvelles données du réseau.
     * @param Reseau $reseau L'objet du réseau à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function updateReseau(Reseau $reseau): ?bool
    {
        try {
            $this->getEntityManager()->persist($reseau);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'update du réseau", $e->getCode());
        }
    }

    /**
     * Supprime un réseau de la base de données.
     *
     * @param Reseau $reseau Le réseau à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function removeReseau(Reseau $reseau): ?bool
    {
        try {
            $this->getEntityManager()->remove($reseau);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression du réseau", $e->getCode());
        }
    }
}
