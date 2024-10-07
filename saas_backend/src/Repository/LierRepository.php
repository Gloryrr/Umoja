<?php

namespace App\Repository;

use App\Entity\Lier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lier>
 */
class LierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lier::class);
    }

    /**
     * Trouve les genres musicaux depuis un id réseau
     *
     * @param int $idReseau, l'id du réseau en question
     * @return Lier[] Une liste de genres musicaux
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function trouveGenresMusicauxParIdReseau(int $idReseau): array
    {
        try {
            return $this->createQueryBuilder('l')
                ->andWhere('l.idReseau = :idReseau')
                ->setParameter('idReseau', $idReseau)
                ->getQuery()
                ->getResult();
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la récupération des genres musicaux : " . $e->getCode());
        }
    }

    /**
     * Ajoute un genre musical à un réseau
     *
     * @param Lier $lierObjet, l'objet contenant l'id du réseau et l'id du genre musical en question
     * @return bool Indique si l'ajout a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function ajouteMembreAuReseau(Lier $lierObjet): bool
    {
        try {
            $this->getEntityManager()->persist($lierObjet);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'ajout du genre musical au réseau : " . $e->getCode());
        }
    }

    /**
     * Retire un genre musical d'un réseau
     *
     * @param Lier $lierObject, l'objet contenant l'id du réseau et l'id du genre musical en question
     * @return bool Indique si la suppression a réussie.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function retireGenreMusicalReseau(Lier $lierObject): bool
    {
        try {
            $this->getEntityManager()->remove($lierObject);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression du genre musical du réseau : " . $e->getCode());
        }
    }
}
