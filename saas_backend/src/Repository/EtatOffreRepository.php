<?php

namespace App\Repository;

use App\Entity\EtatOffre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Classe EtatOffreRepository
 * Repository pour l'entité EtatOffre, étendant ServiceEntityRepository pour interagir avec la base de données.
 * @extends ServiceEntityRepository<EtatOffre>
 */
class EtatOffreRepository extends ServiceEntityRepository
{
    /**
     * Constructeur.
     *
     * @param ManagerRegistry $registry Le registre des gestionnaires d'entités.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtatOffre::class);
    }


    /**
     * Trouve l'état d'offre par son nom.
     *
     * @param string $username Le nom de l'état à rechercher.
     * @return EtatOffre[] Une liste d'états d'offre correspondant aux critères.
     */
    public function trouveEtatOffreByName(string $nomEtat): array
    {
        try {
            return $this->createQueryBuilder('gm')
            ->andWhere('gm.nomEtatOffre = :nomEtatOffre')
            ->setParameter('nomEtatOffre', $nomEtat)
            ->getQuery()
            ->getResult();
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la récupération de l'état d'offre", $e->getCode());
        }
    }

    /**
     * Inscrit un nouvel état d'offre dans la base de données.
     *
     * @param mixed $data Les données de l'état d'offre.
     * @param EtatOffre $etatOffre L'objet de l'état d'offre à persister.
     * @return bool Indique si l'inscription a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function inscritEtatOffre(EtatOffre $etatOffre): bool
    {
        try {
            $this->getEntityManager()->persist($etatOffre);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement d'un état d'offre : " . $e->getCode());
        }
    }

    /**
     * Met à jour un état d'offre existant dans la base de données.
     *
     * @param mixed $data Les nouvelles données de l'état d'offre.
     * @param EtatOffre $etatOffre L'objet de l'état d'offre à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function updateEtatOffre(EtatOffre $etatOffre): ?bool
    {
        try {
            $this->getEntityManager()->persist($etatOffre);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'update de l'état d'offre", $e->getCode());
        }
    }

    /**
     * Supprime un état d'offre de la base de données.
     *
     * @param EtatOffre $etatOffre Le état d'offre à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function removeEtatOffre(EtatOffre $etatOffre): ?bool
    {
        try {
            $this->getEntityManager()->remove($etatOffre);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression de l'état d'offre", $e->getCode());
        }
    }
}
