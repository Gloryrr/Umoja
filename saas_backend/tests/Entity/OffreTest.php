<?php

namespace App\Tests\Entity;

use App\Entity\Offre;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité Offre.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité Offre
 * à l'aide de PHPUnit.
 */
class OffreTest extends TestCase
{
    /**
     * Instance de l'entité Offre à tester.
     *
     * @var Offre
     */
    private Offre $offre;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de Offre.
     */
    protected function setUp(): void
    {
        $this->offre = new Offre();
    }

    /**
     * Test de la méthode getId().
     *
     * Vérifie que l'identifiant est null par défaut avant
     * toute génération.
     */
    public function testGetIdInitial(): void
    {
        $this->assertEquals(0, $this->offre->getId());
    }

    /**
     * Test de la méthode getTitleOffre() et setTitleOffre().
     *
     * Vérifie si le titre de l'offre peut être correctement
     * défini et récupéré.
     */
    public function testSetTitleOffreAndGetTitleOffre(): void
    {
        $title = "Nouvelle Offre";
        $this->offre->setTitleOffre($title);
        $this->assertSame($title, $this->offre->getTitleOffre());
    }

    /**
     * Test de la méthode getDeadLine() et setDeadLine().
     *
     * Vérifie si la date limite peut être correctement
     * définie et récupérée.
     */
    public function testSetDeadLineAndGetDeadLine(): void
    {
        $deadline = new \DateTime('2024-12-31');
        $this->offre->setDeadLine($deadline);
        $this->assertSame($deadline, $this->offre->getDeadLine());
    }

    /**
     * Test de la méthode getDescrTournee() et setDescrTournee().
     *
     * Vérifie si la description de la tournée peut être
     * correctement définie et récupérée.
     */
    public function testSetDescrTourneeAndGetDescrTournee(): void
    {
        $description = "Description de la tournée";
        $this->offre->setDescrTournee($description);
        $this->assertSame($description, $this->offre->getDescrTournee());
    }

    /**
     * Test de la méthode getDateMinProposee() et setDateMinProposee().
     *
     * Vérifie si la date minimale peut être définie et récupérée.
     */
    public function testSetDateMinProposeeAndGetDateMinProposee(): void
    {
        $dateMin = new \DateTime('2024-01-01');
        $this->offre->setDateMinProposee($dateMin);
        $this->assertSame($dateMin, $this->offre->getDateMinProposee());
    }

    /**
     * Test de la méthode getDateMaxProposee() et setDateMaxProposee().
     *
     * Vérifie si la date maximale peut être définie et récupérée.
     */
    public function testSetDateMaxProposeeAndGetDateMaxProposee(): void
    {
        $dateMax = new \DateTime('2024-12-31');
        $this->offre->setDateMaxProposee($dateMax);
        $this->assertSame($dateMax, $this->offre->getDateMaxProposee());
    }

    /**
     * Test de la méthode getVilleVisee() et setVilleVisee().
     *
     * Vérifie si la ville visée peut être définie et récupérée.
     */
    public function testSetVilleViseeAndGetVilleVisee(): void
    {
        $ville = "Paris";
        $this->offre->setVilleVisee($ville);
        $this->assertSame($ville, $this->offre->getVilleVisee());
    }

    /**
     * Test de la méthode getRegionVisee() et setRegionVisee().
     *
     * Vérifie si la région visée peut être définie et récupérée.
     */
    public function testSetRegionViseeAndGetRegionVisee(): void
    {
        $region = "Île-de-France";
        $this->offre->setRegionVisee($region);
        $this->assertSame($region, $this->offre->getRegionVisee());
    }

    /**
     * Test de la méthode getPlacesMin() et setPlacesMin().
     *
     * Vérifie si le nombre minimum de places peut être défini et récupéré.
     */
    public function testSetPlacesMinAndGetPlacesMin(): void
    {
        $placesMin = 10;
        $this->offre->setPlacesMin($placesMin);
        $this->assertSame($placesMin, $this->offre->getPlacesMin());
    }

    /**
     * Test de la méthode getPlacesMax() et setPlacesMax().
     *
     * Vérifie si le nombre maximum de places peut être défini et récupéré.
     */
    public function testSetPlacesMaxAndGetPlacesMax(): void
    {
        $placesMax = 100;
        $this->offre->setPlacesMax($placesMax);
        $this->assertSame($placesMax, $this->offre->getPlacesMax());
    }

    /**
     * Test de la méthode getNbArtistesConcernes() et setNbArtistesConcernes().
     *
     * Vérifie si le nombre d'artistes concernés peut être défini et récupéré.
     */
    public function testSetNbArtistesConcernesAndGetNbArtistesConcernes(): void
    {
        $nbArtistes = 5;
        $this->offre->setNbArtistesConcernes($nbArtistes);
        $this->assertSame($nbArtistes, $this->offre->getNbArtistesConcernes());
    }

    /**
     * Test de la méthode getNbInvitesConcernes() et setNbInvitesConcernes().
     *
     * Vérifie si le nombre d'invités concernés peut être défini et récupéré.
     */
    public function testSetNbInvitesConcernesAndGetNbInvitesConcernes(): void
    {
        $nbInvites = 20;
        $this->offre->setNbInvitesConcernes($nbInvites);
        $this->assertSame($nbInvites, $this->offre->getNbInvitesConcernes());
    }

    /**
     * Test de la méthode getLiensPromotionnels() et setLiensPromotionnels().
     *
     * Vérifie si les liens promotionnels peuvent être définis et récupérés.
     */
    public function testSetLiensPromotionnelsAndGetLiensPromotionnels(): void
    {
        $lienPromo = "http://promotion.com";
        $this->offre->setLiensPromotionnels($lienPromo);
        $this->assertSame($lienPromo, $this->offre->getLiensPromotionnels());
    }

        /**
     * Test de la méthode getExtras() et setExtras().
     *
     * Vérifie si l'entité Extras peut être définie et récupérée.
     */
    public function testSetExtrasAndGetExtras(): void
    {
        $extras = $this->createMock(\App\Entity\Extras::class);
        $this->offre->setExtras($extras);
        $this->assertSame($extras, $this->offre->getExtras());
    }

    /**
     * Test de la méthode getEtatOffre() et setEtatOffre().
     *
     * Vérifie si l'état de l'offre peut être défini et récupéré.
     */
    public function testSetEtatOffreAndGetEtatOffre(): void
    {
        $etatOffre = $this->createMock(\App\Entity\EtatOffre::class);
        $this->offre->setEtatOffre($etatOffre);
        $this->assertSame($etatOffre, $this->offre->getEtatOffre());
    }

    /**
     * Test de la méthode getTypeOffre() et setTypeOffre().
     *
     * Vérifie si le type de l'offre peut être défini et récupéré.
     */
    public function testSetTypeOffreAndGetTypeOffre(): void
    {
        $typeOffre = $this->createMock(\App\Entity\TypeOffre::class);
        $this->offre->setTypeOffre($typeOffre);
        $this->assertSame($typeOffre, $this->offre->getTypeOffre());
    }

    /**
     * Test de la méthode getConditionsFinancieres() et setConditionsFinancieres().
     *
     * Vérifie si les conditions financières peuvent être définies et récupérées.
     */
    public function testSetConditionsFinancieresAndGetConditionsFinancieres(): void
    {
        $conditionsFinancieres = $this->createMock(\App\Entity\ConditionsFinancieres::class);
        $this->offre->setConditionsFinancieres($conditionsFinancieres);
        $this->assertSame($conditionsFinancieres, $this->offre->getConditionsFinancieres());
    }

    /**
     * Test de la méthode getBudgetEstimatif() et setBudgetEstimatif().
     *
     * Vérifie si le budget estimatif peut être défini et récupéré.
     */
    public function testSetBudgetEstimatifAndGetBudgetEstimatif(): void
    {
        $budgetEstimatif = $this->createMock(\App\Entity\BudgetEstimatif::class);
        $this->offre->setBudgetEstimatif($budgetEstimatif);
        $this->assertSame($budgetEstimatif, $this->offre->getBudgetEstimatif());
    }

    /**
     * Test de la méthode getFicheTechniqueArtiste() et setFicheTechniqueArtiste().
     *
     * Vérifie si la fiche technique de l'artiste peut être définie et récupérée.
     */
    public function testSetFicheTechniqueArtisteAndGetFicheTechniqueArtiste(): void
    {
        $ficheTechniqueArtiste = $this->createMock(\App\Entity\FicheTechniqueArtiste::class);
        $this->offre->setFicheTechniqueArtiste($ficheTechniqueArtiste);
        $this->assertSame($ficheTechniqueArtiste, $this->offre->getFicheTechniqueArtiste());
    }
}
