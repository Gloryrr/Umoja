<?php

namespace App\Tests\Repository;

use App\Entity\PreferenceNotification;
use App\Repository\PreferenceNotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PreferencesNotificationsRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private PreferenceNotificationRepository $preferenceNotificationRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->preferenceNotificationRepository = static::getContainer()->get(PreferenceNotificationRepository::class);
        $this->entityManager = $this->preferenceNotificationRepository->getEntityManager();

        // Clean up database before each test
        $this->entityManager->createQuery('DELETE FROM App\Entity\Commentaire')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\Offre')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\Artiste')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\BudgetEstimatif')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\ConditionsFinancieres')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\EtatOffre')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\EtatReponse')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\Extras')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\FicheTechniqueArtiste')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\GenreMusical')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\Reponse')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\Reseau')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\TypeOffre')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\Utilisateur')->execute();
    }

    public function testCreatePreferenceNotification(): void
    {
        // Create and persist a PreferenceNotification entity
        $preferenceNotification = new PreferenceNotification();
        $preferenceNotification->setId(1)
                               ->setEmailNouvelleOffre(true)
                               ->setEmailUpdateOffre(false)
                               ->setReponseOffre(true);

        $this->preferenceNotificationRepository->inscritPreferenceNotification($preferenceNotification);

        // Assert that the entity is persisted
        $this->assertNotNull($preferenceNotification->getId(), 'The PreferenceNotification should be successfully persisted.');
    }

    public function testUpdatePreferenceNotification(): void
    {
        $preferenceNotification = new PreferenceNotification();
        $preferenceNotification->setId(1)
                               ->setEmailNouvelleOffre(true)
                               ->setEmailUpdateOffre(false)
                               ->setReponseOffre(true);

        $this->preferenceNotificationRepository->inscritPreferenceNotification($preferenceNotification);

        // Update the entity
        $preferenceNotification->setEmailNouvelleOffre(false);
        $preferenceNotification->setEmailUpdateOffre(true);
        $preferenceNotification->setReponseOffre(false);
        $this->preferenceNotificationRepository->updatePreferenceNotification($preferenceNotification);

        // Assert the entity has been updated
        $updatedPreferenceNotification = $this->preferenceNotificationRepository->find($preferenceNotification->getId());
        $this->assertFalse($updatedPreferenceNotification->isEmailNouvelleOffre(), 'The emailNouvelleOffre should be updated.');
        $this->assertTrue($updatedPreferenceNotification->isEmailUpdateOffre(), 'The emailUpdateOffre should be updated.');
        $this->assertFalse($updatedPreferenceNotification->isReponseOffre(), 'The reponseOffre should be updated.');
    }

    public function testDeletePreferenceNotification(): void
    {
        // Create and persist a PreferenceNotification entity
        $preferenceNotification = new PreferenceNotification();
        $preferenceNotification->setId(1)
                               ->setEmailNouvelleOffre(true)
                               ->setEmailUpdateOffre(false)
                               ->setReponseOffre(true);

        $this->preferenceNotificationRepository->inscritPreferenceNotification($preferenceNotification);

        $preferenceNotificationId = $preferenceNotification->getId();

        // Retrieve and delete the entity
        $this->preferenceNotificationRepository->removePreferenceNotification($preferenceNotification);

        // Assert the entity has been deleted
        $deletedPreferenceNotification = $this->preferenceNotificationRepository->find($preferenceNotificationId);
        $this->assertNull($deletedPreferenceNotification, 'The PreferenceNotification should be deleted.');
        $this->assertEmpty($this->preferenceNotificationRepository->find($preferenceNotificationId), 'There should be no PreferenceNotification entities.');
    }

    protected function tearDown(): void
    {
        $entityManager = $this->preferenceNotificationRepository->getEntityManager();
        
        // Effacer toutes les entités pour garder une base de données propre
        $entityManager->createQuery('DELETE FROM App\Entity\Commentaire')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\Offre')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\Artiste')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\BudgetEstimatif')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\ConditionsFinancieres')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\EtatOffre')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\EtatReponse')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\Extras')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\FicheTechniqueArtiste')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\GenreMusical')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\Reponse')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\Reseau')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\TypeOffre')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\Utilisateur')->execute();
        
        parent::tearDown();
    }
}
