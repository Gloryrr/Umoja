<?php

namespace App\Tests\Repository;

use App\Entity\Offre;
use App\Entity\Utilisateur;
use App\Entity\EtatOffre;
use App\Entity\TypeOffre;
use App\Entity\ConditionsFinancieres;
use App\Entity\BudgetEstimatif;
use App\Entity\FicheTechniqueArtiste;
use App\Entity\Extras;
use App\Repository\OffreRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OffreRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private OffreRepository $offreRepository;
    private UtilisateurRepository $utilisateurRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->offreRepository = static::getContainer()->get(OffreRepository::class);
        $this->utilisateurRepository = static::getContainer()->get(UtilisateurRepository::class);

        $this->entityManager = $this->offreRepository->getEntityManager();

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

    public function testCreateOffre(): void
    {
        // Create and persist a Utilisateur entity
        $utilisateur = new Utilisateur();
        $utilisateur->setId(1);
        $utilisateur->setEmailUtilisateur('test@example.com');
        $utilisateur->setMdpUtilisateur('securepassword');
        $utilisateur->setRoles('ROLE_USER');
        $utilisateur->setUsername('testuser');

        $this->utilisateurRepository->inscritUtilisateur($utilisateur);

        // Create and configure related entities
        $extras = new Extras();
        $extras->setId(1);
        $extras->setClausesConfidentialites('Test Extra')
                ->setCoutExtras(100)
                ->setDescrExtras('Description of the extra')
                ->setException('Test exception')
                ->setExclusivite('Test exclusivity')
                ->setOrdrePassage('Test order');

        // Create and persist related entities
        $etatOffre = new EtatOffre();
        $etatOffre->setId(1)
            ->setNomEtat('Active');
        
        $typeOffre = new TypeOffre();
        $typeOffre->setId(1)
            ->setNomTypeOffre('Type Test');

        $conditionsFinancieres = new ConditionsFinancieres();
        $conditionsFinancieres->setId(1)
                              ->setConditionsPaiement(1000)
                              ->setMinimunGaranti(50)
                              ->setPourcentageRecette(1.5);

        $budgetEstimatif = new BudgetEstimatif();
        $budgetEstimatif->setId(1)
                        ->setCachetArtiste(5000)
                        ->setFraisDeplacement(1000)
                        ->setFraisHebergement(2000)
                        ->setFraisRestauration(500);

        $ficheTechniqueArtiste = new FicheTechniqueArtiste();
        $ficheTechniqueArtiste->setId(1)
                              ->setBesoinBackline('Fiche technique de l\'artiste')
                              ->setBesoinEclairage('Eclairage de l\'artiste')
                              ->setBesoinScene('Scène de l\'artiste')
                              ->setBesoinEquipements('Equipement de l\'artiste')
                              ->setBesoinSonorisation('Sonorisation de l\'artiste');

        // Persist related entities
        $this->entityManager->persist($etatOffre);
        $this->entityManager->persist($typeOffre);
        $this->entityManager->persist($conditionsFinancieres);
        $this->entityManager->persist($budgetEstimatif);
        $this->entityManager->persist($ficheTechniqueArtiste);
        $this->entityManager->persist($extras);
        $this->entityManager->flush();

        // Create and configure the Offre entity
        $offre = new Offre();
        $offre->setId(1);
        $offre->setTitleOffre('Test Offer');
        $offre->setDeadLine(new \DateTime('2024-12-31'));
        $offre->setDescrTournee('Description de la tournée');
        $offre->setDateMinProposee(new \DateTime('2024-12-01'));
        $offre->setDateMaxProposee(new \DateTime('2024-12-10'));
        $offre->setVilleVisee('Paris');
        $offre->setRegionVisee('Île-de-France');
        $offre->setPlacesMin(10);
        $offre->setNbContributeur(5);
        $offre->setPlacesMax(100);
        $offre->setNbArtistesConcernes(5);
        $offre->setNbInvitesConcernes(20);
        $offre->setLiensPromotionnels('https://example.com');
        $offre->setExtras($extras);
        $offre->setEtatOffre($etatOffre);
        $offre->setTypeOffre($typeOffre);
        $offre->setConditionsFinancieres($conditionsFinancieres);
        $offre->setBudgetEstimatif($budgetEstimatif);
        $offre->setFicheTechniqueArtiste($ficheTechniqueArtiste);
        $offre->setUtilisateur($utilisateur);

        // Persist the Offre entity
        $this->offreRepository->inscritOffre($offre);

        // Assert that the Offre entity has been persisted
        $this->assertNotNull($offre->getId(), 'The offer should be successfully persisted.');
    }

    public function testUpdateOffre(): void
    {
        $this->testCreateOffre(); // Create an offer for update test

        // Retrieve the offer
        $offre = $this->offreRepository->findOneBy(['titleOffre' => 'Test Offer']);
        $this->assertNotNull($offre, 'The offer should exist.');

        // Update the offer
        $offre->setTitleOffre('Updated Test Offer')
                ->setDeadLine(new \DateTime('2025-12-31'))
                ->setDescrTournee('Updated description of the tour')
                ->setDateMinProposee(new \DateTime('2025-12-01'))
                ->setDateMaxProposee(new \DateTime('2025-12-10'))
                ->setVilleVisee('Lyon')
                ->setRegionVisee('Auvergne-Rhône-Alpes')
                ->setPlacesMin(20)
                ->setNbContributeur(10)
                ->setPlacesMax(200)
                ->setNbArtistesConcernes(10)
                ->setNbInvitesConcernes(40)
                ->setLiensPromotionnels('https://example.com/updated');
        
        // Persist the updated offer
        $this->offreRepository->updateOffre($offre);

        // Assert the offer is updated
        $updatedOffre = $this->offreRepository->findOneBy(['titleOffre' => 'Updated Test Offer']);
        $this->assertNotNull($updatedOffre, 'The offer should be updated.');
        $this->assertEquals('Updated Test Offer', $updatedOffre->getTitleOffre());
        $this->assertEquals(new \DateTime('2025-12-31'), $updatedOffre->getDeadLine());
        $this->assertEquals('Updated description of the tour', $updatedOffre->getDescrTournee());
        $this->assertEquals(new \DateTime('2025-12-01'), $updatedOffre->getDateMinProposee());
        $this->assertEquals(new \DateTime('2025-12-10'), $updatedOffre->getDateMaxProposee());
        $this->assertEquals('Lyon', $updatedOffre->getVilleVisee());
        $this->assertEquals('Auvergne-Rhône-Alpes', $updatedOffre->getRegionVisee());
        $this->assertEquals(20, $updatedOffre->getPlacesMin());
        $this->assertEquals(10, $updatedOffre->getNbContributeur());
        $this->assertEquals(200, $updatedOffre->getPlacesMax());
        $this->assertEquals(10, $updatedOffre->getNbArtistesConcernes());
        $this->assertEquals(40, $updatedOffre->getNbInvitesConcernes());
        $this->assertEquals('https://example.com/updated', $updatedOffre->getLiensPromotionnels());
    }

    public function testDeleteOffre(): void
    {
        $this->testCreateOffre(); // Create an offer for deletion test

        // Retrieve the offer
        $offre = $this->offreRepository->findOneBy(['titleOffre' => 'Test Offer']);
        $this->assertNotNull($offre, 'The offer should exist.');

        $offreId = $offre->getId();

        // Delete the offer
        $this->offreRepository->removeOffre($offre);

        // Assert the offer is deleted
        $deletedOffre = $this->offreRepository->find($offreId);
        $this->assertNull($deletedOffre, 'The offer should be deleted.');
    }

    protected function tearDown(): void
    {
        $entityManager = $this->offreRepository->getEntityManager();
        
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
