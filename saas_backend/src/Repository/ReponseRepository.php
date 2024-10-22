<?php

namespace App\Repository;

use App\Entity\Reponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reponse>
 */
class ReponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reponse::class);
    }

    /**
     * Ajoute une nouvelle réponse dans la base de données.
     *
     * @param Reponse $reponse L'objet Reponse à persister.
     * @return bool Indique si l'insertion a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function ajouterReponse(Reponse $reponse): bool
    {
        try {
            $this->getEntityManager()->persist($reponse);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement de la réponse : " . $e->getMessage());
        }
    }

    /**
     * Met à jour une réponse existante dans la base de données.
     *
     * @param Reponse $reponse L'objet Reponse à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function modifierReponse(Reponse $reponse): ?bool
    {
        try {
            $this->getEntityManager()->persist($reponse);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la mise à jour de la réponse : " . $e->getMessage());
        }
    }

    /**
     * Supprime une réponse de la base de données.
     *
     * @param Reponse $reponse L'objet Reponse à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function supprimerReponse(Reponse $reponse): ?bool
    {
        try {
            $this->getEntityManager()->remove($reponse);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression de la réponse : " . $e->getMessage());
        }
    }
}
