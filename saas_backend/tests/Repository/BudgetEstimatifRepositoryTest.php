<?php

namespace App\Tests\Repository;

use App\Entity\BudgetEstimatif;
use App\Repository\BudgetEstimatifRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BudgetEstimatifRepositoryTest extends KernelTestCase
{
    private BudgetEstimatifRepository $budgetEstimatifRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->budgetEstimatifRepository = static::getContainer()->get(BudgetEstimatifRepository::class);

        $entityManager = $this->budgetEstimatifRepository->getEntityManager();

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

    public function testInscritBudgetEstimatif(): void
    {
        $budgetEstimatif = (new BudgetEstimatif())
            ->setId(1)
            ->setCachetArtiste(1000)
            ->setFraisDeplacement(200)
            ->setFraisHebergement(300)
            ->setFraisRestauration(150);

        $result = $this->budgetEstimatifRepository->inscritBudgetEstimatif($budgetEstimatif);

        $this->assertTrue($result, 'L\'insertion du budget estimatif a échoué.');
        $this->assertNotNull($budgetEstimatif->getId(), 'L\'ID du budget estimatif aurait dû être défini après insertion.');
    }

    public function testUpdateBudgetEstimatif(): void
    {
        // Crée et insère un budget estimatif pour tester la mise à jour
        $budgetEstimatif = (new BudgetEstimatif())
            ->setId(1)
            ->setCachetArtiste(1000)
            ->setFraisDeplacement(200)
            ->setFraisHebergement(300)
            ->setFraisRestauration(150);

        $this->budgetEstimatifRepository->inscritBudgetEstimatif($budgetEstimatif);

        // Modifie les valeurs
        $budgetEstimatif->setCachetArtiste(1200)
            ->setFraisDeplacement(250);

        $result = $this->budgetEstimatifRepository->updateBudgetEstimatif($budgetEstimatif);

        $this->assertTrue($result, 'La mise à jour du budget estimatif a échoué.');

        // Vérifie que les valeurs ont été mises à jour dans la base
        $updatedBudget = $this->budgetEstimatifRepository->find($budgetEstimatif->getId());
        $this->assertSame(1200, $updatedBudget->getCachetArtiste(), 'Le cachet de l\'artiste n\'a pas été mis à jour.');
        $this->assertSame(250, $updatedBudget->getFraisDeplacement(), 'Les frais de déplacement n\'ont pas été mis à jour.');
    }

    public function testRemoveBudgetEstimatif(): void
    {
        // Crée et insère un budget estimatif pour tester la suppression
        $budgetEstimatif = (new BudgetEstimatif())
            ->setId(1)
            ->setCachetArtiste(1000)
            ->setFraisDeplacement(200)
            ->setFraisHebergement(300)
            ->setFraisRestauration(150);

        $this->budgetEstimatifRepository->inscritBudgetEstimatif($budgetEstimatif);

        $budgetEstimatifId = $budgetEstimatif->getId();

        // Supprime le budget estimatif
        $result = $this->budgetEstimatifRepository->removeBudgetEstimatif($budgetEstimatif);

        $this->assertTrue($result, 'La suppression du budget estimatif a échoué.');

        // Vérifie que l'entité n'existe plus dans la base
        $deletedBudget = $this->budgetEstimatifRepository->find($budgetEstimatifId);
        $this->assertNull($deletedBudget, 'Le budget estimatif aurait dû être supprimé.');
    }

    protected function tearDown(): void
    {
        $entityManager = $this->budgetEstimatifRepository->getEntityManager();
        
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
