<?php

namespace App\Repository;

use App\Entity\ConditionsFinancieres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConditionsFinancieres>
 */
class ConditionsFinancieresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConditionsFinancieres::class);
    }

    /**
     * Ajoute un nouvelle condition financière dans la base de données.
     *
     * @param mixed $data Les données de la condition financière.
     * @param ConditionsFinancieres $conditionsFinancieres L'objet de la condition financière à persister.
     * @return bool Indique si l'inscription a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function inscritConditionsFinancieres(ConditionsFinancieres $conditionsFinancieres): bool
    {
        try {
            $this->getEntityManager()->persist($conditionsFinancieres);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'ajout de la condition financière : " . $e->getCode());
        }
    }

    /**
     * Met à jour un condition financière d'un artiste existant dans la base de données.
     *
     * @param mixed $data Les nouvelles données de la condition financière.
     * @param ConditionsFinancieres $conditionsFinancieres L'objet de la condition financière à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function updateConditionsFinancieres(ConditionsFinancieres $conditionsFinancieres): ?bool
    {
        try {
            $this->getEntityManager()->persist($conditionsFinancieres);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'update de la condition financière", $e->getCode());
        }
    }

    /**
     * Supprime un condition financière d'un artiste de la base de données.
     *
     * @param ConditionsFinancieres $conditionsFinancieres La fiche tehcnique à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function removeConditionsFinancieres(ConditionsFinancieres $conditionsFinancieres): ?bool
    {
        try {
            $this->getEntityManager()->remove($conditionsFinancieres);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression de la condition financière", $e->getCode());
        }
    }
}
