<?php

namespace App\Tests\Repository;

use App\Entity\Reponse;
use App\Entity\EtatReponse;
use App\Entity\Offre;
use App\Entity\Utilisateur;
use App\Entity\Extras;
use App\Entity\EtatOffre;
use App\Entity\TypeOffre;
use App\Entity\ConditionsFinancieres;
use App\Entity\BudgetEstimatif;
use App\Entity\FicheTechniqueArtiste;
use App\Repository\ReponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReponseRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private ReponseRepository $reponseRepository;

    protected function setUp(): void
    {
        // Charge le kernel de Symfony pour l'accès à l'EntityManager
        self::bootKernel();
        $this->reponseRepository = static::getContainer()->get(ReponseRepository::class);
        $this->entityManager = $this->reponseRepository->getEntityManager();

        // Clean up database before each test
        $this->entityManager->createQuery('DELETE FROM App\Entity\Reponse')->execute();
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
        $this->entityManager->createQuery('DELETE FROM App\Entity\Reseau')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\TypeOffre')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\Utilisateur')->execute();
    }

    public function testCreateReponse(): void
    {
        // Créer des entités de test pour EtatReponse, Offre, et Utilisateur
        $etatReponse = new EtatReponse();
        $etatReponse->setId(1)
                    ->setNomEtatReponse('Acceptée')
                    ->setDescriptionEtatReponse('La réponse a été acceptée.');

        // Create and configure a Utilisateur entity
        $utilisateur = new Utilisateur();
        $utilisateur->setId(1);
        $utilisateur->setEmailUtilisateur('test@example.com');
        $utilisateur->setMdpUtilisateur('securepassword');
        $utilisateur->setRoles('ROLE_USER');
        $utilisateur->setUsername('testuser');

        // Persist the Utilisateur entity
        $this->entityManager->persist($utilisateur);
        $this->entityManager->flush();

        // Create and configure related entities
        $extras = new Extras();
        $extras->setId(1)
                ->setClausesConfidentialites('Test Extra')
                ->setCoutExtras(100)
                ->setDescrExtras('Description of the extra')
                ->setException('Test exception')
                ->setExclusivite('Test exclusivity')
                ->setOrdrePassage('Test order');

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
        $this->entityManager->persist($etatReponse);
        $this->entityManager->persist($utilisateur);
        $this->entityManager->persist($extras);
        $this->entityManager->persist($etatOffre);
        $this->entityManager->persist($typeOffre);
        $this->entityManager->persist($conditionsFinancieres);
        $this->entityManager->persist($budgetEstimatif);
        $this->entityManager->persist($ficheTechniqueArtiste);
        $this->entityManager->flush();

        // Create and configure an Offre entity
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
        $this->entityManager->persist($offre);
        $this->entityManager->flush();

        // Crée une nouvelle Reponse
        $reponse = new Reponse();
        $reponse->setId(1)
            ->setEtatReponse($etatReponse)
            ->setOffre($offre)
            ->setUtilisateur($utilisateur)
            ->setDateDebut(new \DateTime())
            ->setDateFin(new \DateTime())
            ->setPrixParticipation(100.50);

        $this->reponseRepository->ajouterReponse($reponse);

        // Vérifie si la réponse a été correctement persistée
        $savedReponse = $this->reponseRepository->find($reponse->getId());
        $this->assertNotNull($savedReponse);
        $this->assertEquals(100.50, $savedReponse->getPrixParticipation());
        $this->assertEquals($offre->getId(), $savedReponse->getOffre()->getId());
        $this->assertEquals($utilisateur->getId(), $savedReponse->getUtilisateur()->getId());
        $this->assertEquals($etatReponse->getId(), $savedReponse->getEtatReponse()->getId());
    }

    public function testUpdateReponse(): void
    {
        // Créer des entités de test pour EtatReponse, Offre, et Utilisateur
        $etatReponse = new EtatReponse();
        $etatReponse->setId(1)
                    ->setNomEtatReponse('Acceptée')
                    ->setDescriptionEtatReponse('La réponse a été acceptée.');

        // Create and configure a Utilisateur entity
        $utilisateur = new Utilisateur();
        $utilisateur->setId(1);
        $utilisateur->setEmailUtilisateur('test2@example.com');
        $utilisateur->setMdpUtilisateur('securepassword');
        $utilisateur->setRoles('ROLE_USER');
        $utilisateur->setUsername('testuser2');

        // Persist the Utilisateur entity
        $this->entityManager->persist($utilisateur);
        $this->entityManager->flush();

        // Create and configure related entities
        $extras = new Extras();
        $extras->setId(1)
                ->setClausesConfidentialites('Test Extra')
                ->setCoutExtras(100)
                ->setDescrExtras('Description of the extra')
                ->setException('Test exception')
                ->setExclusivite('Test exclusivity')
                ->setOrdrePassage('Test order');

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
        $this->entityManager->persist($etatReponse);
        $this->entityManager->persist($utilisateur);
        $this->entityManager->persist($extras);
        $this->entityManager->persist($etatOffre);
        $this->entityManager->persist($typeOffre);
        $this->entityManager->persist($conditionsFinancieres);
        $this->entityManager->persist($budgetEstimatif);
        $this->entityManager->persist($ficheTechniqueArtiste);
        $this->entityManager->flush();

        // Create and configure an Offre entity
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
        $this->entityManager->persist($offre);
        $this->entityManager->flush();

        // Crée une nouvelle Reponse
        $reponse = new Reponse();
        $reponse->setId(1)
            ->setEtatReponse($etatReponse)
            ->setOffre($offre)
            ->setUtilisateur($utilisateur)
            ->setDateDebut(new \DateTime())
            ->setDateFin(new \DateTime())
            ->setPrixParticipation(100.50);

        $this->reponseRepository->ajouterReponse($reponse);

        // Met à jour le prix de participation
        $reponse->setPrixParticipation(250);

        $this->reponseRepository->modifierReponse($reponse);

        // Vérifie la mise à jour
        $updatedReponse = $this->reponseRepository->find($reponse->getId());
        $this->assertNotNull($updatedReponse);
        $this->assertEquals(250, $updatedReponse->getPrixParticipation());

        // Vérifie que les autres champs n'ont pas été modifiés
        $this->assertEquals($reponse->getOffre()->getId(), $updatedReponse->getOffre()->getId());
        $this->assertEquals($reponse->getUtilisateur()->getId(), $updatedReponse->getUtilisateur()->getId());
        $this->assertEquals($reponse->getEtatReponse()->getId(), $updatedReponse->getEtatReponse()->getId());
    }

    public function testDeleteReponse(): void
    {
        // Créer des entités de test pour EtatReponse, Offre, et Utilisateur
        $etatReponse = new EtatReponse();
        $etatReponse->setId(1)
                    ->setNomEtatReponse('Acceptée')
                    ->setDescriptionEtatReponse('La réponse a été acceptée.');

        // Create and configure a Utilisateur entity
        $utilisateur = new Utilisateur();
        $utilisateur->setId(1);
        $utilisateur->setEmailUtilisateur('test3@example.com');
        $utilisateur->setMdpUtilisateur('securepassword');
        $utilisateur->setRoles('ROLE_USER');
        $utilisateur->setUsername('testuser3');

        // Persist the Utilisateur entity
        $this->entityManager->persist($utilisateur);
        $this->entityManager->flush();

        // Create and configure related entities
        $extras = new Extras();
        $extras->setId(1)
                ->setClausesConfidentialites('Test Extra')
                ->setCoutExtras(100)
                ->setDescrExtras('Description of the extra')
                ->setException('Test exception')
                ->setExclusivite('Test exclusivity')
                ->setOrdrePassage('Test order');

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
        $this->entityManager->persist($etatReponse);
        $this->entityManager->persist($utilisateur);
        $this->entityManager->persist($extras);
        $this->entityManager->persist($etatOffre);
        $this->entityManager->persist($typeOffre);
        $this->entityManager->persist($conditionsFinancieres);
        $this->entityManager->persist($budgetEstimatif);
        $this->entityManager->persist($ficheTechniqueArtiste);
        $this->entityManager->flush();

        // Create and configure an Offre entity
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
        $this->entityManager->persist($offre);
        $this->entityManager->flush();

        // Crée une nouvelle Reponse
        $reponse = new Reponse();
        $reponse->setId(1)
            ->setEtatReponse($etatReponse)
            ->setOffre($offre)
            ->setUtilisateur($utilisateur)
            ->setDateDebut(new \DateTime())
            ->setDateFin(new \DateTime())
            ->setPrixParticipation(100.50);

        $this->reponseRepository->ajouterReponse($reponse);

        $reponseId = $reponse->getId();
        $utilisateurId = $utilisateur->getId();
        $offreId = $offre->getId();
        $etatReponseId = $etatReponse->getId();

        // Supprime la réponse
        $this->reponseRepository->supprimerReponse($reponse);

        // Vérifie que la réponse a bien été supprimée
        $deletedReponse = $this->reponseRepository->find($reponseId);
        $this->assertNull($deletedReponse);

        // Vérifie que l'offre et l'utilisateur associés à la réponse existent toujours
        $offre = $this->entityManager->getRepository(Offre::class)->find($offreId);
        $this->assertNotNull($offre);

        $utilisateur = $this->entityManager->getRepository(Utilisateur::class)->find($utilisateurId);
        $this->assertNotNull($utilisateur);

        // Vérifie que l'état de la réponse associée à la réponse existe toujours
        $etatReponse = $this->entityManager->getRepository(EtatReponse::class)->find($etatReponseId);
        $this->assertNotNull($etatReponse);
    }

    protected function tearDown(): void
    {
        $entityManager = $this->reponseRepository->getEntityManager();
        
        // Effacer toutes les entités pour garder une base de données propre
        $entityManager->createQuery('DELETE FROM App\Entity\Reponse')->execute();
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
        $entityManager->createQuery('DELETE FROM App\Entity\Reseau')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\TypeOffre')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\Utilisateur')->execute();
        
        parent::tearDown();
    }
}
