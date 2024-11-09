<?php

namespace App\Repository;

use App\Entity\Extras;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Extras>
 */
class ExtrasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Extras::class);
    }

    /**
     * Ajoute un nouvel extra dans la base de données.
     *
     * @param Extras $extras L'objet de l'extra à persister.
     * @return bool Indique si l'insertion a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function ajouterExtras(Extras $extras): bool
    {
        try {
            $this->getEntityManager()->persist($extras);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement de l'extra : " . $e->getMessage());
        }
    }

    /**
     * Met à jour un extra existant dans la base de données.
     *
     * @param Extras $extras L'objet de l'extra à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function modifierExtras(Extras $extras): ?bool
    {
        try {
            $this->getEntityManager()->persist($extras);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la mise à jour de l'extra : " . $e->getMessage());
        }
    }

    /**
     * Supprime un extra de la base de données.
     *
     * @param Extras $extras L'extra à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function supprimerExtras(Extras $extras): ?bool
    {
        try {
            $this->getEntityManager()->remove($extras);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression de l'extra : " . $e->getMessage());
        }
    }
}
