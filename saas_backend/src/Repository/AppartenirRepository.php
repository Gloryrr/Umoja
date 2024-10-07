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
