<?php

namespace App\Repository;

use App\Entity\TypeOffre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeOffre>
 */
class TypeOffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeOffre::class);
    }

    /**
     * Trouve une offre par son type.
     *
     * @param string $type Le type de l'offre à rechercher.
     * @return TypeOffre[] Une liste d'offres correspondant aux critères.
     */
    public function trouveOffreByType(string $type): array
    {
        try {
            return $this->createQueryBuilder('t')
                ->andWhere('t.type = :type')
                ->setParameter('type', $type)
                ->getQuery()
                ->getResult();
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la récupération de l'offre", $e->getCode());
        }
    }

    /**
     * Inscrit une nouvelle offre dans la base de données.
     *
     * @param TypeOffre $offre L'objet de l'offre à persister.
     * @return bool Indique si l'inscription a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function inscritOffre(TypeOffre $offre): bool
    {
        try {
            $this->getEntityManager()->persist($offre);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement de l'offre : " . $e->getCode());
        }
    }

    /**
     * Met à jour une offre existante dans la base de données.
     *
     * @param TypeOffre $offre L'objet de l'offre à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function updateOffre(TypeOffre $offre): ?bool
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
     * @param TypeOffre $offre L'offre à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function removeOffre(TypeOffre $offre): ?bool
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
