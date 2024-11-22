<?php

namespace App\Repository;

use App\Entity\PreferenceNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PreferenceNotification>
 */
class PreferenceNotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PreferenceNotification::class);
    }

    /**
     * Inscrit une nouvelle préférence de notification à l'utilisateur dans la base de données.
     *
     * @param mixed $data Les données de la préférence de notification.
     * @param PreferenceNotification $preferenceNotification L'objet PreferenceNotification à persister.
     * @return bool Indique si l'inscription a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de l'enregistrement.
     */
    public function inscritPreferenceNotification(PreferenceNotification $preferenceNotification): bool
    {
        try {
            $this->getEntityManager()->persist($preferenceNotification);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException(
                "Erreur lors de l'enregistrement de la préférence de notification : " . $e->getCode()
            );
        }
    }

    /**
     * Met à jour une préférence de notification existante dans la base de données.
     *
     * @param mixed $data Les données de la préférence de notification.
     * @param PreferenceNotification $preferenceNotification L'objet PreferenceNotification à mettre à jour.
     * @return bool|null Indique si la mise à jour a réussi.
     *
     * @throws \Exception Si une erreur survient lors de la mise à jour.
     */
    public function updatePreferenceNotification(PreferenceNotification $preferenceNotification): ?bool
    {
        try {
            $this->getEntityManager()->persist($preferenceNotification);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'update de la préférence de notification", $e->getCode());
        }
    }

    /**
     * Supprime une préférence de notification de la base de données.
     *
     * @param PreferenceNotification $preferenceNotification la préférence de notification à supprimer.
     * @return bool|null Indique si la suppression a réussi.
     *
     * @throws \RuntimeException Si une erreur survient lors de la suppression.
     */
    public function removePreferenceNotification(PreferenceNotification $preferenceNotification): ?bool
    {
        try {
            $this->getEntityManager()->remove($preferenceNotification);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException(
                "Erreur lors de la suppression de la préférence de notification",
                $e->getCode()
            );
        }
    }
}
