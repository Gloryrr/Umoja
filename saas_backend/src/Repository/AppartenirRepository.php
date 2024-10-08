<?php

namespace App\Repository;

use App\Entity\Appartenir;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Appartenir>
 */
class AppartenirRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appartenir::class);
    }

    /**
     * Trouve les membres d'un réseau grâce à son id
     *
     * @param int $idReseau, l'id du réseau en question
     * @return Appartenir[] Une liste d'utilisateurs
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function trouveMembresParIdReseau(int $idReseau): array
    {
        try {
            return $this->createQueryBuilder('r')
                ->andWhere('r.idReseau = :idReseau')
                ->setParameter('idReseau', $idReseau)
                ->getQuery()
                ->getResult();
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la récupération des membres : " . $e->getCode());
        }
    }

    /**
     * Trouve les réseaux auxquels un utilisateur appartient grâce à son ID.
     *
     * @param int $idUtilisateur, l'id de l'utilisateur en question
     * @return Appartenir[] Une liste d'utilisateurs
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function trouveReseauxParIdUtilisateur(int $idUtilisateur): array
    {
        try {
            return $this->createQueryBuilder('r')
                ->andWhere('r.idUtilisateur = :idUtilisateur')
                ->setParameter('idUtilisateur', $idUtilisateur)
                ->getQuery()
                ->getResult();
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la récupération des réseaux : " . $e->getCode());
        }
    }

    /**
     * Ajoute un membre à un réseau
     *
     * @param Appartenir $appartenirObject, l'objet contenant l'id du réseau et de l'utilisateur en question
     * @return bool Indique si l'ajout a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function ajouteMembreAuReseau(Appartenir $appartenirObject): bool
    {
        try {
            $this->getEntityManager()->persist($appartenirObject);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'ajout de l'utilisateur au réseau : " . $e->getCode());
        }
    }

    /**
     * Retire un membre d'un réseau
     *
     * @param Appartenir $appartenirObject, l'objet contenant l'id du réseau et de l'utilisateur en question
     * @return bool Indique si la suppression a réussie.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function retireMembreReseau(Appartenir $appartenirObject): bool
    {
        try {
            $this->getEntityManager()->remove($appartenirObject);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression de l'utilisateur au réseau : " . $e->getCode());
        }
    }
}
