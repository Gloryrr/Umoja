<?php

namespace App\Tests\Repository;

use App\Entity\Commentaire;
use App\Entity\Offre;
use App\Entity\Utilisateur;
use App\Entity\Extras;
use App\Entity\EtatOffre;
use App\Entity\TypeOffre;
use App\Entity\ConditionsFinancieres;
use App\Entity\BudgetEstimatif;
use App\Entity\FicheTechniqueArtiste;
use App\Repository\CommentaireRepository;
use App\Repository\OffreRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CommentaireRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private CommentaireRepository $commentaireRepository;
    private OffreRepository $offreRepository;
    private UtilisateurRepository $utilisateurRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->commentaireRepository = static::getContainer()->get(CommentaireRepository::class);
        $this->offreRepository = static::getContainer()->get(OffreRepository::class);
        $this->utilisateurRepository = static::getContainer()->get(UtilisateurRepository::class);

        $this->entityManager = $this->commentaireRepository->getEntityManager();
        
        // Clear the database before each test
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

    public function testCreateCommentaire(): void
    {
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
        $etatOffre->setId(1);
        $etatOffre->setNomEtat('Active');

        $typeOffre = new TypeOffre();
        $typeOffre->setId(1);
        $typeOffre->setNomTypeOffre('Type Test');

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

        // Assert that the Offre entity has been persisted
        $this->assertNotNull($offre->getId(), 'The offer should be successfully persisted.');

        // Create and configure a Commentaire entity
        $commentaire = new Commentaire();
        $commentaire->setId(1);
        $commentaire->setCommentaire('This is a test comment.');
        $commentaire->setOffre($offre);
        $commentaire->setUtilisateur($utilisateur);

        // Persist the Commentaire entity
        $this->commentaireRepository->inscritCommentaire($commentaire);

        // Assert that the Commentaire entity has been persisted
        $this->assertNotNull($commentaire->getId(), 'The comment should be successfully persisted.');
    }

    public function testUpdateCommentaire(): void
    {
        $this->testCreateCommentaire();

        // Retrieve a comment
        $commentaire = $this->commentaireRepository->findOneBy(['commentaire' => 'This is a test comment.']);
        $this->assertNotNull($commentaire, 'The comment should exist.');

        // Update the comment
        $commentaire->setCommentaire('This is an updated test comment.');
        
        // Persist the updated comment
        $this->commentaireRepository->updateCommentaire($commentaire);

        // Assert the comment is updated
        $updatedComment = $this->commentaireRepository->findOneBy(['commentaire' => 'This is an updated test comment.']);
        $this->assertNotNull($updatedComment, 'The comment should be updated.');
    }

    public function testDeleteCommentaire(): void
    {
        $this->testCreateCommentaire();

        // Retrieve a comment
        $commentaire = $this->commentaireRepository->findOneBy(['commentaire' => 'This is a test comment.']);
        $this->assertNotNull($commentaire, 'The comment should exist.');

        // Delete the comment
        $this->commentaireRepository->removeCommentaire($commentaire);

        // Assert the comment is deleted
        $deletedComment = $this->commentaireRepository->findOneBy(['commentaire' => 'This is a test comment.']);
        $this->assertNull($deletedComment, 'The comment should be deleted.');
    }

    protected function tearDown(): void
    {
        $entityManager = $this->commentaireRepository->getEntityManager();
        
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
