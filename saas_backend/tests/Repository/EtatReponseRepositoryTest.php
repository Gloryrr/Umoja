<?php

namespace App\Tests\Entity;

use App\Entity\EtatReponse;
use App\Repository\EtatReponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EtatReponseRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private EtatReponseRepository $etatReponseRepository;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->etatReponseRepository = static::getContainer()->get(EtatReponseRepository::class);

        $this->entityManager = $this->etatReponseRepository->getEntityManager();

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

    public function testCreateEtatReponse()
    {
        $etatReponse = new EtatReponse();
        $etatReponse->setId(1)
                    ->setNomEtatReponse('Responded')
                    ->setDescriptionEtatReponse('Description of the state');

        $this->etatReponseRepository->ajouterEtatReponse($etatReponse);

        $this->assertGreaterThan(0, $etatReponse->getId());
        $this->assertSame('Responded', $etatReponse->getNomEtatReponse());
        $this->assertSame('Description of the state', $etatReponse->getDescriptionEtatReponse());
        $this->assertCount(1, $this->etatReponseRepository->findAll());
    }

    public function testUpdateEtatReponse()
    {
        $etatReponse = new EtatReponse();
        $etatReponse->setId(1)
                    ->setNomEtatReponse('Responded')
                    ->setDescriptionEtatReponse('Description of the state');

        $this->etatReponseRepository->ajouterEtatReponse($etatReponse);

        $etatReponse->setNomEtatReponse('Not Responded')
                    ->setDescriptionEtatReponse('Description of the state');

        $this->etatReponseRepository->modifierEtatReponse($etatReponse);

        $this->assertSame('Not Responded', $etatReponse->getNomEtatReponse());
        $this->assertSame('Description of the state', $etatReponse->getDescriptionEtatReponse());
        $this->assertCount(1, $this->etatReponseRepository->findAll());
    }

    public function testRemoveEtatReponse()
    {
        $etatReponse = new EtatReponse();
        $etatReponse->setId(1)
                    ->setNomEtatReponse('Responded')
                    ->setDescriptionEtatReponse('Description of the state');

        $this->etatReponseRepository->ajouterEtatReponse($etatReponse);

        $etatReponseId = $etatReponse->getId();

        $this->etatReponseRepository->supprimerEtatReponse($etatReponse);

        $this->assertNull($this->entityManager->find(EtatReponse::class, $etatReponseId));
        $this->assertCount(0, $this->etatReponseRepository->findAll());
    }

    protected function tearDown(): void
    {
        $entityManager = $this->etatReponseRepository->getEntityManager();
        
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
