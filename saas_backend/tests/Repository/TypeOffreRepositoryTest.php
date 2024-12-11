<?php

namespace App\Tests\Repository;

use App\Entity\TypeOffre;
use App\Repository\TypeOffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TypeOffreRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private TypeOffreRepository $typeOffreRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->typeOffreRepository = static::getContainer()->get(TypeOffreRepository::class);
        $this->entityManager = $this->typeOffreRepository->getEntityManager();

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

    public function testCreateTypeOffre(): void
    {
        // Créer un nouvel objet TypeOffre
        $typeOffre = new TypeOffre();
        $typeOffre->setId(1)
            ->setNomTypeOffre('Test TypeOffre');

        // Persister et flush
        $this->typeOffreRepository->inscritTypeOffre($typeOffre);

        // Vérifier que l'objet a bien été persité
        $this->assertGreaterThan(0, $typeOffre->getId());
        $this->assertEquals('Test TypeOffre', $typeOffre->getNomTypeOffre());
    }

    public function testFindTypeOffreById(): void
    {
        // Créer et persister un type d'offre
        $typeOffre = new TypeOffre();
        $typeOffre->setId(1)
            ->setNomTypeOffre('Test TypeOffre');
        $this->typeOffreRepository->inscritTypeOffre($typeOffre);

        // Récupérer le type d'offre via le repository
        $foundTypeOffre = $this->typeOffreRepository->find($typeOffre->getId());

        // Vérifier que le type d'offre trouvé est le même que celui qui a été créé
        $this->assertEquals('Test TypeOffre', $foundTypeOffre->getNomTypeOffre());
    }

    public function testUpdateTypeOffre(): void
    {
        // Créer et persister un type d'offre
        $typeOffre = new TypeOffre();
        $typeOffre->setId(1)
            ->setNomTypeOffre('Old TypeOffre');
        $this->typeOffreRepository->inscritTypeOffre($typeOffre);

        // Mettre à jour le type d'offre
        $typeOffre->setNomTypeOffre('Updated TypeOffre');
        $this->typeOffreRepository->updateTypeOffre($typeOffre);

        // Vérifier que le nom du type d'offre a bien été mis à jour
        $updatedTypeOffre = $this->typeOffreRepository->find($typeOffre->getId());
        $this->assertEquals('Updated TypeOffre', $updatedTypeOffre->getNomTypeOffre());
    }

    public function testDeleteTypeOffre(): void
    {
        // Créer et persister un type d'offre
        $typeOffre = new TypeOffre();
        $typeOffre->setId(1)
            ->setNomTypeOffre('TypeOffre to delete');
        $this->typeOffreRepository->inscritTypeOffre($typeOffre);

        $typeOffreId = $typeOffre->getId();

        // Supprimer le type d'offre
        $this->typeOffreRepository->removeTypeOffre($typeOffre);

        // Vérifier que le type d'offre a bien été supprimé
        $deletedTypeOffre = $this->typeOffreRepository->find($typeOffreId);
        $this->assertNull($deletedTypeOffre);
    }

    protected function tearDown(): void
    {
        $entityManager = $this->typeOffreRepository->getEntityManager();
        
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
