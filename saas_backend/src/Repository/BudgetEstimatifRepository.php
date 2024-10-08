<?php

namespace App\Repository;

use App\Entity\BudgetEstimatif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BudgetEstimatif>
 */
class BudgetEstimatifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BudgetEstimatif::class);
    }

    /**
     * Ajoute un nouveau budget estimatif dans la base de données.
     *
     * @param mixed $data Les données du budget estimatif.
     * @param BudgetEstimatif $budgetEstimatif L'objet du budget estimatif à persister.
     * @return bool Indique si l'inscription a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function inscritBudgetEstimatif(BudgetEstimatif $budgetEstimatif): bool
    {
        try {
            $this->getEntityManager()->persist($budgetEstimatif);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement du budget estimatif : " . $e->getCode());
        }
    }

    /**
     * Met à jour un budget estimatif d'un artiste existant dans la base de données.
     *
     * @param mixed $data Les nouvelles données du budget estimatif.
     * @param BudgetEstimatif $budgetEstimatif L'objet du budget estimatif à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function updateBudgetEstimatif(BudgetEstimatif $budgetEstimatif): ?bool
    {
        try {
            $this->getEntityManager()->persist($budgetEstimatif);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'update du budget estimatif", $e->getCode());
        }
    }

    /**
     * Supprime un budget estimatif d'un artiste de la base de données.
     *
     * @param BudgetEstimatif $budgetEstimatif La fiche tehcnique à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function removeBudgetEstimatif(BudgetEstimatif $budgetEstimatif): ?bool
    {
        try {
            $this->getEntityManager()->remove($budgetEstimatif);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression du budget estimatif", $e->getCode());
        }
    }
}
