<?php

namespace App\Tests\Repository;

use App\Entity\Reseau;
use App\Repository\ReseauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReseauRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private ReseauRepository $reseauRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->reseauRepository = static::getContainer()->get(ReseauRepository::class);
        $this->entityManager = $this->reseauRepository->getEntityManager();

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

    public function testCreateReseau(): void
    {
        // Créer un nouvel objet Reseau
        $reseau = new Reseau();
        $reseau->setId(1)
            ->setNomReseau('Test Reseau');

        // Persister et flush
        $this->reseauRepository->inscritReseau($reseau);

        // Vérifier que l'objet a bien été persité
        $this->assertGreaterThan(0, $reseau->getId());
        $this->assertEquals('Test Reseau', $reseau->getNomReseau());
    }

    public function testFindReseauById(): void
    {
        // Créer et persister un réseau
        $reseau = new Reseau();
        $reseau->setId(1)
            ->setNomReseau('Test Reseau');
        $this->reseauRepository->inscritReseau($reseau);

        // Récupérer le réseau via le repository
        $foundReseau = $this->reseauRepository->find($reseau->getId());

        // Vérifier que le réseau trouvé est le même que celui qui a été créé
        $this->assertEquals('Test Reseau', $foundReseau->getNomReseau());
    }

    public function testUpdateReseau(): void
    {
        // Créer et persister un réseau
        $reseau = new Reseau();
        $reseau->setId(1)
            ->setNomReseau('Old Reseau');
        $this->reseauRepository->inscritReseau($reseau);

        // Mettre à jour le réseau
        $reseau->setNomReseau('Updated Reseau');
        $this->reseauRepository->updateReseau($reseau);

        // Vérifier que le nom du réseau a bien été mis à jour
        $updatedReseau = $this->reseauRepository->find($reseau->getId());
        $this->assertEquals('Updated Reseau', $updatedReseau->getNomReseau());
    }

    public function testDeleteReseau(): void
    {
        // Créer et persister un réseau
        $reseau = new Reseau();
        $reseau->setId(1)
            ->setNomReseau('Reseau to delete');
        $this->reseauRepository->inscritReseau($reseau);

        $reseauId = $reseau->getId();

        // Supprimer le réseau
        $this->reseauRepository->removeReseau($reseau);

        // Vérifier que le réseau a bien été supprimé
        $deletedReseau = $this->reseauRepository->find($reseauId);
        $this->assertNull($deletedReseau);
    }

    protected function tearDown(): void
    {
        $entityManager = $this->reseauRepository->getEntityManager();
        
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
