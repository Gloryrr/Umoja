<?php

namespace App\Repository;

use App\Entity\Attacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Attacher>
 */
class AttacherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attacher::class);
    }

    /**
     * Ajoute un nouvel attachement entre un artiste et un genre musical dans la base de données.
     *
     * @param mixed $data Les données de l'attachement.
     * @param Attacher $attacher L'objet de l'attachement à persister.
     * @return bool Indique si l'inscription a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function inscritAttacher(Attacher $attacher): bool
    {
        try {
            $this->getEntityManager()->persist($attacher);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement d'un attachement : " . $e->getCode());
        }
    }

    /**
     * Met à jour un attachement existant dans la base de données.
     *
     * @param mixed $data Les nouvelles données de l'attachement.
     * @param Attacher $attacher L'objet de l'attachement à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function updateAttacher(Attacher $attacher): ?bool
    {
        try {
            $this->getEntityManager()->persist($attacher);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'update de l'attachement", $e->getCode());
        }
    }

    /**
     * Supprime un attachement de la base de données.
     *
     * @param Attacher $attacher L'attachement à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function removeAttacher(Attacher $attacher): ?bool
    {
        try {
            $this->getEntityManager()->remove($attacher);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la suppression de l'attachement", $e->getCode());
        }
    }
}
