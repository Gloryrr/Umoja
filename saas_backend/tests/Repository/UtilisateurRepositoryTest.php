<?php

namespace App\Tests\Repository;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UtilisateurRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private UtilisateurRepository $utilisateurRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->utilisateurRepository = static::getContainer()->get(UtilisateurRepository::class);
        $this->entityManager = $this->utilisateurRepository->getEntityManager();

        // Clean up database before each test
        $this->entityManager->createQuery('DELETE FROM App\Entity\Reponse')->execute();
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
        $this->entityManager->createQuery('DELETE FROM App\Entity\Reseau')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\TypeOffre')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\Utilisateur')->execute();
    }

    public function testCreateUtilisateur(): void
    {
        // Créer un nouvel utilisateur
        $utilisateur = new Utilisateur();
        $utilisateur->setId(1)
            ->setEmailUtilisateur('test@example.com')
            ->setMdpUtilisateur('password123')
            ->setRoles('ROLE_USER')
            ->setUsername('testuser');

        // Persister et flush
        $this->utilisateurRepository->inscritUtilisateur($utilisateur);

        // Vérifier que l'utilisateur a été persisté
        $this->assertGreaterThan(0, $utilisateur->getId());
        $this->assertEquals('test@example.com', $utilisateur->getEmailUtilisateur());
    }

    public function testFindUtilisateurById(): void
    {
        // Créer et persister un utilisateur
        $utilisateur = new Utilisateur();
        $utilisateur->setId(2)
            ->setEmailUtilisateur('findme@example.com')
            ->setMdpUtilisateur('password123')
            ->setRoles('ROLE_USER')
            ->setUsername('findme');
        $this->utilisateurRepository->inscritUtilisateur($utilisateur);

        // Récupérer l'utilisateur via le repository
        $foundUtilisateur = $this->utilisateurRepository->find($utilisateur->getId());

        // Vérifier que l'utilisateur trouvé est correct
        $this->assertEquals('findme@example.com', $foundUtilisateur->getEmailUtilisateur());
    }

    public function testUpdateUtilisateur(): void
    {
        // Créer et persister un utilisateur
        $utilisateur = new Utilisateur();
        $utilisateur->setId(3)
            ->setEmailUtilisateur('old@example.com')
            ->setMdpUtilisateur('password123')
            ->setRoles('ROLE_USER')
            ->setUsername('olduser');
        $this->utilisateurRepository->inscritUtilisateur($utilisateur);

        // Mettre à jour l'utilisateur
        $utilisateur->setEmailUtilisateur('new@example.com');
        $this->utilisateurRepository->updateUtilisateur($utilisateur);

        // Vérifier la mise à jour
        $updatedUtilisateur = $this->utilisateurRepository->find($utilisateur->getId());
        $this->assertEquals('new@example.com', $updatedUtilisateur->getEmailUtilisateur());
    }

    public function testDeleteUtilisateur(): void
    {
        // Créer et persister un utilisateur
        $utilisateur = new Utilisateur();
        $utilisateur->setId(4)
            ->setEmailUtilisateur('delete@example.com')
            ->setMdpUtilisateur('password123')
            ->setRoles('ROLE_USER')
            ->setUsername('deleteuser');

        $this->utilisateurRepository->inscritUtilisateur($utilisateur);

        // Récupérer l'ID de l'entité pour la suppression
        $utilisateurId = $utilisateur->getId();

        // Supprimer l'utilisateur
        $this->utilisateurRepository->removeUtilisateur($utilisateur);

        // Vérifier que l'utilisateur a été supprimé
        $deletedUtilisateur = $this->utilisateurRepository->find($utilisateurId);
        $this->assertNull($deletedUtilisateur);
    }

    protected function tearDown(): void
    {
        $entityManager = $this->utilisateurRepository->getEntityManager();

        // Effacer toutes les entités pour garder une base de données propre
        $entityManager->createQuery('DELETE FROM App\Entity\Reponse')->execute();
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
        $entityManager->createQuery('DELETE FROM App\Entity\Reseau')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\TypeOffre')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\Utilisateur')->execute();

        parent::tearDown();
    }
}
