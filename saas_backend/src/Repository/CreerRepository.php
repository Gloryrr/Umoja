<?php

namespace App\Repository;

use App\Entity\Creer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Creer>
 */
class CreerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creer::class);
    }

    /**
     * Ajoute une nouvelle relation de création entre un utilisateur et une offre dans la base de données.
     *
     * @param Creer $creer L'objet de la relation à persister.
     * @return bool Indique si l'insertion a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function ajouterCreer(Creer $creer): bool
    {
        try {
            $this->getEntityManager()->persist($creer);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement de la relation" . $e->getMessage());
        }
    }

    /**
     * Met à jour une relation de création existante dans la base de données.
     *
     * @param Creer $creer L'objet de la relation à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function modifierCreer(Creer $creer): ?bool
    {
        try {
            $this->getEntityManager()->persist($creer);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la mise à jour de la relation de création", $e->getMessage());
        }
    }

    /**
     * Supprime une relation de création de la base de données.
     *
     * @param Creer $creer La relation à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function supprimerCreer(Creer $creer): ?bool
    {
        try {
            $this->getEntityManager()->remove($creer);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression de la relation de création", $e->getMessage());
        }
    }
}
