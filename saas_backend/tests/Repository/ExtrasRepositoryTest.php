<?php

namespace App\Tests\Repository;

use App\Entity\Extras;
use App\Repository\ExtrasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ExtrasRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private ExtrasRepository $extrasRepository;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->extrasRepository = static::getContainer()->get(ExtrasRepository::class);
        $this->entityManager = $this->extrasRepository->getEntityManager();

        // Nettoyage des données avant chaque test
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

    public function testAjouterExtras()
    {
        $extras = new Extras();
        $extras->setId(1)
                ->setClausesConfidentialites('Test clauses Extra')
                ->setCoutExtras(5000)
                ->setDescrExtras('Description of the extra')
                ->setException('Test exception')
                ->setExclusivite('Test exclusivity')
                ->setOrdrePassage('Test order');

        // Ajouter un extra
        $result = $this->extrasRepository->ajouterExtras($extras);

        // Vérifier que l'extra a bien été ajouté
        $this->assertTrue($result);
        $this->assertGreaterThan(0, $extras->getId());
        $this->assertSame('Test clauses Extra', $extras->getClausesConfidentialites());
        $this->assertSame(5000, $extras->getCoutExtras());
        $this->assertSame('Description of the extra', $extras->getDescrExtras());
        $this->assertSame('Test exception', $extras->getException());
        $this->assertSame('Test exclusivity', $extras->getExclusivite());
        $this->assertSame('Test order', $extras->getOrdrePassage());
        $this->assertCount(1, $this->extrasRepository->findAll());
    }

    public function testModifierExtras()
    {
        $extras = new Extras();
        $extras->setId(1)
                ->setClausesConfidentialites('Test Extra')
               ->setCoutExtras(100)
               ->setDescrExtras('Description of the extra')
               ->setException('Test exception')
               ->setExclusivite('Test exclusivity')
               ->setOrdrePassage('Test order');

        // Ajouter un extra
        $this->extrasRepository->ajouterExtras($extras);

        // Modifier l'extra
        $extras->setClausesConfidentialites('Updated Extra')
               ->setCoutExtras(4000)
                ->setDescrExtras('Updated description')
                ->setException('Updated exception')
                ->setExclusivite('Updated exclusivity')
                ->setOrdrePassage('Updated order');
        
        $result = $this->extrasRepository->modifierExtras($extras);

        // Vérifier que l'extra a bien été mis à jour
        $this->assertTrue($result);
        $this->assertSame('Updated Extra', $extras->getClausesConfidentialites());
        $this->assertSame(4000, $extras->getCoutExtras());
        $this->assertSame('Updated description', $extras->getDescrExtras());
        $this->assertSame('Updated exception', $extras->getException());
        $this->assertSame('Updated exclusivity', $extras->getExclusivite());
        $this->assertSame('Updated order', $extras->getOrdrePassage());
        $this->assertCount(1, $this->extrasRepository->findAll());
    }

    public function testSupprimerExtras()
    {
        $extras = new Extras();
        $extras->setId(1)
               ->setClausesConfidentialites('Test Extra')
               ->setCoutExtras(100)
               ->setDescrExtras('Description of the extra')
               ->setException('Test exception')
               ->setExclusivite('Test exclusivity')
               ->setOrdrePassage('Test order');

        // Ajouter un extra
        $this->extrasRepository->ajouterExtras($extras);

        $extrasId = $extras->getId();

        // Supprimer l'extra
        $result = $this->extrasRepository->supprimerExtras($extras);

        // Vérifier que l'extra a bien été supprimé
        $this->assertTrue($result);
        $this->assertNull($this->entityManager->find(Extras::class, $extrasId));
        $this->assertCount(0, $this->extrasRepository->findAll());
    }

    protected function tearDown(): void
    {
        $entityManager = $this->extrasRepository->getEntityManager();
        
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
