<?php

namespace App\Repository;

use App\Entity\Commentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commentaire>
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    /**
     * Inscrit un nouveau commentaire dans la base de données.
     *
     * @param mixed $data Les données du commentaire.
     * @param Commentaire $commentaire L'objet du commentaire à persister.
     * @return bool Indique si l'inscription a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function inscritCommentaire(Commentaire $commentaire): bool
    {
        try {
            $this->getEntityManager()->persist($commentaire);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement d'un commentaire : " . $e->getCode());
        }
    }

    /**
     * Met à jour un commentaire existant dans la base de données.
     *
     * @param mixed $data Les nouvelles données du commentaire.
     * @param Commentaire $commentaire L'objet du commentaire à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function updateCommentaire(Commentaire $commentaire): ?bool
    {
        try {
            $this->getEntityManager()->persist($commentaire);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'update du commentaire", $e->getCode());
        }
    }

    /**
     * Supprime un commentaire de la base de données.
     *
     * @param Commentaire $commentaire Le commentaire à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function removeCommentaire(Commentaire $commentaire): ?bool
    {
        try {
            $this->getEntityManager()->remove($commentaire);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression du commentaire", $e->getCode());
        }
    }
}
