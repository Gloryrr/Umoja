<?php

namespace App\Tests\Entity;

use App\Entity\GenreMusical;
use App\Repository\GenreMusicalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GenreMusicalRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private GenreMusicalRepository $genreMusicalRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->genreMusicalRepository = static::getContainer()->get(GenreMusicalRepository::class);
        $this->entityManager = $this->genreMusicalRepository->getEntityManager();

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

    public function testCreateGenreMusical(): void
    {
        // Créer une instance de GenreMusical
        $genreMusical = new GenreMusical();
        $genreMusical->setId(1)
            ->setNomGenreMusical('Rock');

        // Persister l'entité
        $this->genreMusicalRepository->inscritGenreMusical($genreMusical);

        // Vérifier si l'entité est bien persistée dans la base de données
        $this->assertGreaterThan(0, $genreMusical->getId());

        // Rechercher l'entité dans la base de données
        $retrievedGenreMusical = $this->genreMusicalRepository->find($genreMusical->getId());

        // Vérifier que l'entité récupérée correspond à celle persistée
        $this->assertEquals($genreMusical->getNomGenreMusical(), $retrievedGenreMusical->getNomGenreMusical());
    }

    public function testUpdateGenreMusical(): void
    {
        // Créer une instance de GenreMusical et la persister
        $genreMusical = new GenreMusical();
        $genreMusical->setId(1)
            ->setNomGenreMusical('Jazz');
        $this->genreMusicalRepository->inscritGenreMusical($genreMusical);

        // Modifier l'entité
        $genreMusical->setNomGenreMusical('Blues');
        $this->genreMusicalRepository->updateGenreMusical($genreMusical);

        // Rechercher l'entité dans la base de données et vérifier la mise à jour
        $retrievedGenreMusical = $this->genreMusicalRepository->find($genreMusical->getId());
        $this->assertEquals('Blues', $retrievedGenreMusical->getNomGenreMusical());
    }

    public function testDeleteGenreMusical(): void
    {
        // Créer une instance de GenreMusical et la persister
        $genreMusical = new GenreMusical();
        $genreMusical->setId(1)
            ->setNomGenreMusical('Classical');
        $this->genreMusicalRepository->inscritGenreMusical($genreMusical);

        // Récupérer l'ID de l'entité pour la suppression
        $genreMusicalId = $genreMusical->getId();

        // Supprimer l'entité
        $this->genreMusicalRepository->removeGenreMusical($genreMusical);

        // Vérifier si l'entité a été supprimée
        $deletedGenreMusical = $this->genreMusicalRepository->find($genreMusicalId);
        $this->assertNull($deletedGenreMusical);
    }

    protected function tearDown(): void
    {
        $entityManager = $this->genreMusicalRepository->getEntityManager();
        
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
