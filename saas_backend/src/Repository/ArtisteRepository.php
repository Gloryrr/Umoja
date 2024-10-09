<?php

namespace App\Repository;

use App\Entity\Artiste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Artiste>
 */
class ArtisteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artiste::class);
    }

    /**
     * Inscrit un nouvel artiste dans la base de données.
     *
     * @param mixed $data Les données de l'artiste.
     * @param Artiste $artiste L'objet de l'artiste à persister.
     * @return bool Indique si l'inscription a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function inscritArtiste(Artiste $artiste): bool
    {
        try {
            $this->getEntityManager()->persist($artiste);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement d'un artiste : " . $e->getCode());
        }
    }

    /**
     * Met à jour un artiste existant dans la base de données.
     *
     * @param mixed $data Les nouvelles données de l'artiste.
     * @param Artiste $artiste L'objet de l'artiste à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function updateArtiste(Artiste $artiste): ?bool
    {
        try {
            $this->getEntityManager()->persist($artiste);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'update de l'artiste", $e->getCode());
        }
    }

    /**
     * Supprime un Artiste de la base de données.
     *
     * @param Artiste $artiste Le Artiste à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function removeArtiste(Artiste $artiste): ?bool
    {
        try {
            $this->getEntityManager()->remove($artiste);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression de l'artiste", $e->getCode());
        }
    }
}
