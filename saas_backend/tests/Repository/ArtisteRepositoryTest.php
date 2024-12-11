<?php

namespace App\Tests\Repository;

use App\Entity\Artiste;
use App\Repository\ArtisteRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArtisteRepositoryTest extends KernelTestCase
{
    private ArtisteRepository $artisteRepository;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->artisteRepository = static::getContainer()->get(ArtisteRepository::class);

        $entityManager = $this->artisteRepository->getEntityManager();

        // Nettoyer la base de données avant chaque test
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
    }

    public function testInscriptionArtiste(): void
    {
        $artiste = new Artiste();
        $artiste->setId(1);
        $artiste->setNomArtiste('Artiste Test');

        $result = $this->artisteRepository->inscritArtiste($artiste);

        $this->assertTrue($result, 'L\'artiste devrait être correctement inscrit.');

        $artistes = $this->artisteRepository->findAll();
        $this->assertCount(1, $artistes, 'Un seul artiste devrait être présent dans la base de données.');
        $this->assertSame('Artiste Test', $artistes[0]->getNomArtiste(), 'Le nom de l\'artiste devrait correspondre.');
    }

    public function testTrouveArtisteByName(): void
    {
        $artiste = new Artiste();
        $artiste->setId(1);
        $artiste->setNomArtiste('Artiste Unique');
        $this->artisteRepository->inscritArtiste($artiste);

        $result = $this->artisteRepository->trouveArtisteByName('Artiste Unique');
        $this->assertNotEmpty($result, 'Un artiste devrait être trouvé.');
        $this->assertSame('Artiste Unique', $result[0]->getNomArtiste(), 'Le nom de l\'artiste devrait correspondre.');
    }

    public function testUpdateArtiste(): void
    {
        $artiste = new Artiste();
        $artiste->setId(1);
        $artiste->setNomArtiste('Ancien Nom');
        $this->artisteRepository->inscritArtiste($artiste);

        $artiste->setNomArtiste('Nouveau Nom');
        $result = $this->artisteRepository->updateArtiste($artiste);

        $this->assertTrue($result, 'La mise à jour devrait être réussie.');

        $artistes = $this->artisteRepository->findAll();
        $this->assertCount(1, $artistes, 'Un seul artiste devrait être présent dans la base de données.');
        $this->assertSame('Nouveau Nom', $artistes[0]->getNomArtiste(), 'Le nom de l\'artiste devrait être mis à jour.');
    }

    public function testRemoveArtiste(): void
    {
        $artiste = new Artiste();
        $artiste->setId(1);
        $artiste->setNomArtiste('Artiste à Supprimer');
        $this->artisteRepository->inscritArtiste($artiste);

        $result = $this->artisteRepository->removeArtiste($artiste);

        $this->assertTrue($result, 'La suppression devrait être réussie.');

        $artistes = $this->artisteRepository->findAll();
        $this->assertCount(0, $artistes, 'Aucun artiste ne devrait être présent dans la base de données après suppression.');
    }
    protected function tearDown(): void
    {
        $entityManager = $this->artisteRepository->getEntityManager();
        
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
