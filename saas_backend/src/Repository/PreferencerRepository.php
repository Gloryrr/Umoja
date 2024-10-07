<?php

namespace App\Repository;

use App\Entity\Preferencer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Preferencer>
 */
class PreferencerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Preferencer::class);
    }

    /**
     * Trouve les genres musicaux aimés par un utilisateur
     *
     * @param int $idUtilisateur, l'id de l'utilisateur en question
     * @return Preferencer[] Une liste de genres musicaux
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function trouveGenresMusicauxParIdUtilisateur(int $idUtilisateur): array
    {
        try {
            return $this->createQueryBuilder('l')
                ->andWhere('l.idUtilisateur = :idUtilisateur')
                ->setParameter('idUtilisateur', $idUtilisateur)
                ->getQuery()
                ->getResult();
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la récupération des genres musicaux : " . $e->getCode());
        }
    }

    /**
     * Ajoute un genre musical préféré à un utilisateur
     *
     * @param Preferencer $preferencerObjet, l'objet contenant l'id de l'utilisateur et du genre musical en question
     * @return bool Indique si l'ajout a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function ajouteGenreMusicalUtilisateur(Preferencer $preferencerObjet): bool
    {
        try {
            $this->getEntityManager()->persist($preferencerObjet);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'ajout du genre musical à l'utilisateur : " . $e->getCode());
        }
    }

    /**
     * Retire un genre musical préféré à un utilisateur
     *
     * @param Preferencer $preferencerObject, l'objet contenant l'id de l'utilisateur et du genre musical en question
     * @return bool Indique si la suppression a réussie.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function retireGenreMusicalUtilisateur(Preferencer $preferencerObject): bool
    {
        try {
            $this->getEntityManager()->remove($preferencerObject);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException(
                "Erreur lors de la suppression du genre musical des préférences : " . $e->getCode()
            );
        }
    }
}
