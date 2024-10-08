<?php

namespace App\Repository;

use App\Entity\FicheTechniqueArtiste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FicheTechniqueArtiste>
 */
class FicheTechniqueArtisteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FicheTechniqueArtiste::class);
    }

    /**
     * Ajoute une nouvelle fiche technique dans la base de données.
     *
     * @param mixed $data Les données de la fiche technique.
     * @param FicheTechniqueArtiste $ficheTechniqueArtiste L'objet de la fiche technique à persister.
     * @return bool Indique si l'inscription a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function inscritFicheTechniqueArtiste(FicheTechniqueArtiste $ficheTechniqueArtiste): bool
    {
        try {
            $this->getEntityManager()->persist($ficheTechniqueArtiste);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement de la fiche technique : " . $e->getCode());
        }
    }

    /**
     * Met à jour une fiche technique d'un artiste existante dans la base de données.
     *
     * @param mixed $data Les nouvelles données de la fiche technique.
     * @param FicheTechniqueArtiste $ficheTechniqueArtiste L'objet de la fiche technique à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function updateFicheTechniqueArtiste(FicheTechniqueArtiste $ficheTechniqueArtiste): ?bool
    {
        try {
            $this->getEntityManager()->persist($ficheTechniqueArtiste);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'update de la fiche technique", $e->getCode());
        }
    }

    /**
     * Supprime une fiche technique d'un artiste de la base de données.
     *
     * @param FicheTechniqueArtiste $ficheTechniqueArtiste La fiche tehcnique à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function removeFicheTechniqueArtiste(FicheTechniqueArtiste $ficheTechniqueArtiste): ?bool
    {
        try {
            $this->getEntityManager()->remove($ficheTechniqueArtiste);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression de la fiche technique", $e->getCode());
        }
    }
}
