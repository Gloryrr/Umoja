<?php

namespace App\Repository;

use App\Entity\EtatReponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EtatReponse>
 */
class EtatReponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtatReponse::class);
    }

    /**
     * Ajoute un nouvel état de réponse dans la base de données.
     *
     * @param EtatReponse $etatReponse L'objet de l'état de réponse à persister.
     * @return bool Indique si l'insertion a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function ajouterEtatReponse(EtatReponse $etatReponse): bool
    {
        try {
            $this->getEntityManager()->persist($etatReponse);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement de l'état de réponse : " . $e->getMessage());
        }
    }

    /**
     * Met à jour un état de réponse existant dans la base de données.
     *
     * @param EtatReponse $etatReponse L'objet de l'état de réponse à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function modifierEtatReponse(EtatReponse $etatReponse): ?bool
    {
        try {
            $this->getEntityManager()->persist($etatReponse);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la mise à jour de l'état de réponse", $e->getMessage());
        }
    }

    /**
     * Supprime un état de réponse de la base de données.
     *
     * @param EtatReponse $etatReponse L'état de réponse à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function supprimerEtatReponse(EtatReponse $etatReponse): ?bool
    {
        try {
            $this->getEntityManager()->remove($etatReponse);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression de l'état de réponse", $e->getMessage());
        }
    }
}
