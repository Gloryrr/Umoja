<?php

namespace App\Repository;

use App\Entity\Rattacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rattacher>
 */
class RattacherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rattacher::class);
    }

    /**
     * Ajoute une nouvelle relation entre une offre et un genre musical dans la base de données.
     *
     * @param Rattacher $rattacher L'objet de la relation à persister.
     * @return bool Indique si l'insertion a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function ajouterRattacher(Rattacher $rattacher): bool
    {
        try {
            $this->getEntityManager()->persist($rattacher);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement de la relation : " . $e->getMessage());
        }
    }

    /**
     * Met à jour une relation existante dans la base de données.
     *
     * @param Rattacher $rattacher L'objet de la relation à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function modifierRattacher(Rattacher $rattacher): ?bool
    {
        try {
            $this->getEntityManager()->persist($rattacher);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la mise à jour de la relation", $e->getMessage());
        }
    }

    /**
     * Supprime une relation de la base de données.
     *
     * @param Rattacher $rattacher La relation à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function supprimerRattacher(Rattacher $rattacher): ?bool
    {
        try {
            $this->getEntityManager()->remove($rattacher);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression de la relation", $e->getMessage());
        }
    }
}
