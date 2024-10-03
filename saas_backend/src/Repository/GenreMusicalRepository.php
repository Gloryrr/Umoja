<?php

namespace App\Repository;

use App\Entity\GenreMusical;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Classe GenreMusicalRepository
 * Repository pour l'entité GenreMusical, étendant ServiceEntityRepository pour interagir avec la base de données.
 * @extends ServiceEntityRepository<GenreMusical>
 */
class GenreMusicalRepository extends ServiceEntityRepository
{
    /**
     * Constructeur.
     *
     * @param ManagerRegistry $registry Le registre des gestionnaires d'entités.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenreMusical::class);
    }


    /**
     * Trouve un genre musical par son nom.
     *
     * @param string $username Le nom du genre à rechercher.
     * @return GenreMusical[] Une liste de genre musical correspondant aux critères.
     */
    public function trouveGenreMusicalByName(string $nomGenre): array
    {
        try {
            return $this->createQueryBuilder('gm')
            ->andWhere('gm.nomGenreMusical = :nomGenre')
            ->setParameter('nomGenre', $nomGenre)
            ->getQuery()
            ->getResult();
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la récupération du genre musical", $e->getCode());
        }
    }

    /**
     * Inscrit un nouveau genre musical dans la base de données.
     *
     * @param mixed $data Les données du genre musical.
     * @param GenreMusical $genreMusical L'objet du genre musical à persister.
     * @return bool Indique si l'inscription a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function inscritGenreMusical(GenreMusical $genreMusical): bool
    {
        try {
            $this->getEntityManager()->persist($genreMusical);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement du genre muscial : " . $e->getCode());
        }
    }

    /**
     * Met à jour un genre musical existant dans la base de données.
     *
     * @param mixed $data Les nouvelles données du genre musical.
     * @param GenreMusical $genreMusical L'objet du genre musical à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function updateGenreMusical(GenreMusical $genreMusical): ?bool
    {
        try {
            $this->getEntityManager()->persist($genreMusical);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'update du genre musical", $e->getCode());
        }
    }

    /**
     * Supprime un genre musical de la base de données.
     *
     * @param GenreMusical $genreMusical Le genre musical à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function removeGenreMusical(GenreMusical $genreMusical): ?bool
    {
        try {
            $this->getEntityManager()->remove($genreMusical);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression du genre musical", $e->getCode());
        }
    }
}
