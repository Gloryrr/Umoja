<?php

namespace App\Tests\Entity;

use App\Entity\EtatOffre;
use App\Repository\EtatOffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EtatOffreRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private EtatOffreRepository $etatOffreRepository;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->etatOffreRepository = static::getContainer()->get(EtatOffreRepository::class);

        $this->entityManager = $this->etatOffreRepository->getEntityManager();

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

    public function testCreateEtatOffre()
    {
        $etatOffre = new EtatOffre();
        $etatOffre->setId(1);
        $etatOffre->setNomEtat('Active');

        $this->etatOffreRepository->inscritEtatOffre($etatOffre);

        $this->assertGreaterThan(0, $etatOffre->getId());
        $this->assertSame('Active', $etatOffre->getNomEtat());
        $this->assertCount(1, $this->etatOffreRepository->findAll());
    }

    public function testUpdateEtatOffre()
    {
        $etatOffre = new EtatOffre();
        $etatOffre->setId(1);
        $etatOffre->setNomEtat('Active');

        $this->etatOffreRepository->inscritEtatOffre($etatOffre);

        $etatOffre->setNomEtat('Inactive');
        $this->etatOffreRepository->updateEtatOffre($etatOffre);

        $this->assertSame('Inactive', $etatOffre->getNomEtat());
        $this->assertCount(1, $this->etatOffreRepository->findAll());
    }

    public function testRemoveEtatOffre()
    {
        $etatOffre = new EtatOffre();
        $etatOffre->setId(1);
        $etatOffre->setNomEtat('Active');

        $this->etatOffreRepository->inscritEtatOffre($etatOffre);

        $etatOffreId = $etatOffre->getId();

        $this->etatOffreRepository->removeEtatOffre($etatOffre);

        $this->assertNull($this->entityManager->find(EtatOffre::class, $etatOffreId));
        $this->assertCount(0, $this->etatOffreRepository->findAll());
    }

    protected function tearDown(): void
    {
        $entityManager = $this->etatOffreRepository->getEntityManager();
        
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
