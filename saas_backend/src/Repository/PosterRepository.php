<?php

namespace App\Repository;

use App\Entity\Poster;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Poster>
 */
class PosterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Poster::class);
    }

    /**
     * Inscrit une offre dans un réseau dans la base de données.
     *
     * @param mixed $data Les données de du post.
     * @param Poster $poster L'objet Poster à persister.
     * @return bool Indique si l'inscription a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function inscritPoster(Poster $poster): bool
    {
        try {
            $this->getEntityManager()->persist($poster);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement du post : " . $e->getCode());
        }
    }

    /**
     * Met à jour un post existant dans la base de données.
     *
     * @param mixed $data Les données de du post.
     * @param Poster $poster L'objet Poster à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function updatePoster(Poster $poster): ?bool
    {
        try {
            $this->getEntityManager()->persist($poster);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'update du post", $e->getCode());
        }
    }

    /**
     * Supprime une un post d'une offre dans un réseau de la base de données.
     *
     * @param Poster $poster du post à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function removePoster(Poster $poster): ?bool
    {
        try {
            $this->getEntityManager()->remove($poster);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression du post", $e->getCode());
        }
    }
}
