<?php

namespace App\Tests\Entity;

use App\Entity\ConditionsFinancieres;
use App\Repository\ConditionsFinancieresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ConditionsFinancieresRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private ConditionsFinancieresRepository $conditionsFinancieresRepository;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->conditionsFinancieresRepository = static::getContainer()->get(ConditionsFinancieresRepository::class);

        $this->entityManager = $this->conditionsFinancieresRepository->getEntityManager();

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

    public function testCreateConditionsFinancieres()
    {
        $conditionsFinancieres = new ConditionsFinancieres();
        $conditionsFinancieres->setId(1);
        $conditionsFinancieres->setMinimunGaranti(5000);
        $conditionsFinancieres->setConditionsPaiement("Paiement en 3 fois");
        $conditionsFinancieres->setPourcentageRecette(25.5);

        $this->conditionsFinancieresRepository->inscritConditionsFinancieres($conditionsFinancieres);

        $this->assertGreaterThan(0, $conditionsFinancieres->getId());
    }

    public function testUpdateConditionsFinancieres()
    {
        $conditionsFinancieres = new ConditionsFinancieres();
        $conditionsFinancieres->setId(1);
        $conditionsFinancieres->setMinimunGaranti(5000);
        $conditionsFinancieres->setConditionsPaiement("Paiement en 3 fois");
        $conditionsFinancieres->setPourcentageRecette(25.5);

        $this->conditionsFinancieresRepository->inscritConditionsFinancieres($conditionsFinancieres);

        $conditionsFinancieres->setMinimunGaranti(10000);
        $conditionsFinancieres->setConditionsPaiement("Paiement en 4 fois");
        $conditionsFinancieres->setPourcentageRecette(50.5);

        $this->conditionsFinancieresRepository->updateConditionsFinancieres($conditionsFinancieres);

        $this->assertSame(10000, $conditionsFinancieres->getMinimunGaranti());
        $this->assertSame("Paiement en 4 fois", $conditionsFinancieres->getConditionsPaiement());
        $this->assertSame(50.5, $conditionsFinancieres->getPourcentageRecette());
    }

    public function testRemoveConditionsFinancieres()
    {
        $conditionsFinancieres = new ConditionsFinancieres();
        $conditionsFinancieres->setId(1);
        $conditionsFinancieres->setMinimunGaranti(5000);
        $conditionsFinancieres->setConditionsPaiement("Paiement en 3 fois");
        $conditionsFinancieres->setPourcentageRecette(25.5);

        $this->conditionsFinancieresRepository->inscritConditionsFinancieres($conditionsFinancieres);

        $conditionsFinancieresId = $conditionsFinancieres->getId();

        $this->conditionsFinancieresRepository->removeConditionsFinancieres($conditionsFinancieres);

        $this->assertEmpty($this->conditionsFinancieresRepository->findAll());
        $this->assertNull($this->entityManager->find(ConditionsFinancieres::class, $conditionsFinancieresId));
    }

    protected function tearDown(): void
    {
        $entityManager = $this->conditionsFinancieresRepository->getEntityManager();
        
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
