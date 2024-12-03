<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offre>
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }

    /**
     * Inscrit une nouvelle offre dans la base de données.
     *
     * @param mixed $data Les données de l'offre.
     * @param Offre $offre L'objet offre à persister.
     * @return bool Indique si l'inscription a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function inscritOffre(Offre $offre): bool
    {
        try {
            $this->getEntityManager()->persist($offre);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException(
                "Erreur lors de l'enregistrement de l'offre : " . $e->getCode() . "" . $e->getMessage()
            );
        }
    }

    /**
     * Récupère les offres d'un réseau dans la base de données.
     *
     * @param mixed $data Les données de l'offre.
     * @param Offre $offre L'objet offre à persister.
     * @return bool Indique si l'inscription a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function getOffresByTitleAndReseau(int $idReseau, string $title): array
    {
        try {
            return $this->createQueryBuilder('o')
                ->join('o.reseaux', 'r')
                ->andWhere('r.id = :idReseau')
                ->andWhere('o.titleOffre LIKE :title')
                ->setParameter('idReseau', $idReseau)
                ->setParameter('title', "%{$title}%")
                ->getQuery()
                ->getResult();
        } catch (\Exception $e) {
            throw new \RuntimeException(
                "Erreur lors de la récupération des offres : " . $e->getCode() . ", " . $e->getMessage()
            );
        }
    }

    /**
     * Récupère les offres en fonction 'une liste d'identifiant dans la base de données.
     *
     * @param array $listeIdOffres Les identifiants des offres.
     * @param Offre $offre L'objet offre à persister.
     * @return bool Indique si l'inscription a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function getOffresByListId(array $listeIdOffres): array
    {
        try {
            return $this->createQueryBuilder('o')
                ->andWhere('o.id in (:listIdOffres)')
                ->setParameter('listIdOffres', $listeIdOffres)
                ->getQuery()
                ->getResult();
        } catch (\Exception $e) {
            throw new \RuntimeException(
                "Erreur lors de la récupération des offres : " . $e->getCode() . ", " . $e->getMessage()
            );
        }
    }

    /**
     * Met à jour une offre existante dans la base de données.
     *
     * @param mixed $data Les données de l'offre.
     * @param Offre $offre L'objet offre à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function updateOffre(Offre $offre): ?bool
    {
        try {
            $this->getEntityManager()->persist($offre);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'update de l'offre", $e->getCode());
        }
    }

    /**
     * Supprime une offre de la base de données.
     *
     * @param Offre $offre L'offre à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function removeOffre(Offre $offre): ?bool
    {
        try {
            $this->getEntityManager()->remove($offre);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression de l'offre", $e->getCode());
        }
    }
}
