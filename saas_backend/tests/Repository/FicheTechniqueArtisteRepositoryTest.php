<?php

namespace App\Tests\Entity;

use App\Entity\FicheTechniqueArtiste;
use App\Repository\FicheTechniqueArtisteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FicheTechniqueArtisteRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->ficheTechniqueArtisteRepository = static::getContainer()->get(FicheTechniqueArtisteRepository::class);
        $this->entityManager = $this->ficheTechniqueArtisteRepository->getEntityManager();

        // Clean the database before each test to avoid interference
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

    public function testCreateFicheTechniqueArtiste()
    {
        $ficheTechniqueArtiste = new FicheTechniqueArtiste();
        $ficheTechniqueArtiste->setId(1)
            ->setBesoinSonorisation('Besoin en sonorisation')
            ->setBesoinEclairage('Besoin en éclairage')
            ->setBesoinScene('Besoin en scène')
            ->setBesoinBackline('Besoin en backline')
            ->setBesoinEquipements('Besoin en équipements');

        $this->entityManager->persist($ficheTechniqueArtiste);
        $this->entityManager->flush();

        $this->assertGreaterThan(0, $ficheTechniqueArtiste->getId());
        $this->assertSame('Besoin en sonorisation', $ficheTechniqueArtiste->getBesoinSonorisation());
        $this->assertSame('Besoin en éclairage', $ficheTechniqueArtiste->getBesoinEclairage());
        $this->assertSame('Besoin en scène', $ficheTechniqueArtiste->getBesoinScene());
        $this->assertSame('Besoin en backline', $ficheTechniqueArtiste->getBesoinBackline());
        $this->assertSame('Besoin en équipements', $ficheTechniqueArtiste->getBesoinEquipements());
        $this->assertCount(1, $this->ficheTechniqueArtisteRepository->findAll());
    }

    public function testUpdateFicheTechniqueArtiste()
    {
        $ficheTechniqueArtiste = new FicheTechniqueArtiste();
        $ficheTechniqueArtiste->setId(1)
            ->setBesoinSonorisation('Besoin en sonorisation')
            ->setBesoinEclairage('Besoin en éclairage')
            ->setBesoinScene('Besoin en scène')
            ->setBesoinBackline('Besoin en backline')
            ->setBesoinEquipements('Besoin en équipements');

        $this->entityManager->persist($ficheTechniqueArtiste);
        $this->entityManager->flush();

        // Update the entity
        $ficheTechniqueArtiste->setBesoinSonorisation('Nouveau besoin en sonorisation')
            ->setBesoinEclairage('Nouveau besoin en éclairage')
            ->setBesoinScene('Nouveau besoin en scène')
            ->setBesoinBackline('Nouveau besoin en backline')
            ->setBesoinEquipements('Nouveau besoin en équipements');

        $this->entityManager->persist($ficheTechniqueArtiste);
        $this->entityManager->flush();

        $this->assertSame('Nouveau besoin en sonorisation', $ficheTechniqueArtiste->getBesoinSonorisation());
        $this->assertSame('Nouveau besoin en éclairage', $ficheTechniqueArtiste->getBesoinEclairage());
        $this->assertSame('Nouveau besoin en scène', $ficheTechniqueArtiste->getBesoinScene());
        $this->assertSame('Nouveau besoin en backline', $ficheTechniqueArtiste->getBesoinBackline());
        $this->assertSame('Nouveau besoin en équipements', $ficheTechniqueArtiste->getBesoinEquipements());
        $this->assertCount(1, $this->ficheTechniqueArtisteRepository->findAll());
    }

    public function testRemoveFicheTechniqueArtiste()
    {
        $ficheTechniqueArtiste = new FicheTechniqueArtiste();
        $ficheTechniqueArtiste->setBesoinSonorisation('Besoin en sonorisation')
            ->setBesoinEclairage('Besoin en éclairage')
            ->setBesoinScene('Besoin en scène')
            ->setBesoinBackline('Besoin en backline')
            ->setBesoinEquipements('Besoin en équipements');

        $this->ficheTechniqueArtisteRepository->inscritFicheTechniqueArtiste($ficheTechniqueArtiste);

        $ficheTechniqueArtisteId = $ficheTechniqueArtiste->getId();

        $this->ficheTechniqueArtisteRepository->removeFicheTechniqueArtiste($ficheTechniqueArtiste);

        $this->assertNull($this->entityManager->find(FicheTechniqueArtiste::class, $ficheTechniqueArtisteId));
        $this->assertCount(0, $this->ficheTechniqueArtisteRepository->findAll());
    }

    protected function tearDown(): void
    {
        $entityManager = $this->ficheTechniqueArtisteRepository->getEntityManager();
        
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
