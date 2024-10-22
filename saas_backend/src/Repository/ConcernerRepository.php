<?php

namespace App\Repository;

use App\Entity\Concerner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Concerner>
 */
class ConcernerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Concerner::class);
    }

    /**
     * Ajoute une nouvelle relation entre un artiste et une offre dans la base de données.
     *
     * @param Concerner $concerner L'objet de la relation à persister.
     * @return bool Indique si l'insertion a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function ajouterConcerner(Concerner $concerner): bool
    {
        try {
            $this->getEntityManager()->persist($concerner);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement de la relation : " . $e->getMessage());
        }
    }

    /**
     * Met à jour une relation existante dans la base de données.
     *
     * @param Concerner $concerner L'objet de la relation à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function modifierConcerner(Concerner $concerner): ?bool
    {
        try {
            $this->getEntityManager()->persist($concerner);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la mise à jour de la relation", $e->getMessage());
        }
    }

    /**
     * Supprime une relation de la base de données.
     *
     * @param Concerner $concerner La relation à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function supprimerConcerner(Concerner $concerner): ?bool
    {
        try {
            $this->getEntityManager()->remove($concerner);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression de la relation", $e->getMessage());
        }
    }
}
