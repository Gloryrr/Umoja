<?php

namespace App\Services;

use App\Entity\BudgetEstimatif;
use App\Entity\Commentaire;
use App\Entity\ConditionsFinancieres;
use App\Entity\EtatOffre;
use App\Entity\Extras;
use App\Entity\FicheTechniqueArtiste;
use App\Entity\Reponse;
use App\Entity\TypeOffre;
use App\Entity\Artiste;
use App\Entity\Offre;
use App\Repository\CommentaireRepository;
use App\Repository\EtatOffreRepository;
use App\Repository\EtatReponseRepository;
use App\Repository\ReponseRepository;
use App\Repository\OffreRepository;
use App\Repository\TypeOffreRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\ReseauRepository;
use App\Repository\GenreMusicalRepository;
use App\Repository\ArtisteRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class OffreService
 * Est le gestionnaire des offres (gestion de la logique métier)
 */
class OffreService
{
    /**
     * Récupère toutes les offres et renvoie une réponse JSON.
     *
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les offres.
     */
    public static function getOffres(
        OffreRepository $offreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $offres = $offreRepository->findAll();
        $offresJSON = $serializer->serialize(
            $offres,
            'json',
            ['groups' => ['offre:read']]
        );
        return new JsonResponse([
            'offres' => json_decode($offresJSON, true),
            'serialized' => true
        ], Response::HTTP_OK, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Récupère une offre et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'offre à récupérer.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les offres.
     */
    public static function getOffre(
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        int $id
    ): JsonResponse {
        $offre = $offreRepository->find($id);
        $offre->setImage($offre->getImage());
        $offreJSON = $serializer->serialize(
            $offre,
            'json',
            ['groups' => [
                'offre:read',
                'extras:read',
                'budget_estimatif:read',
                'fiche_technique_artiste:read',
                'conditions_financieres:read',
                'artistes:read'
            ]]
        );
        return new JsonResponse([
            'offre' => json_decode($offreJSON, true),
            'serialized' => true
        ], Response::HTTP_OK, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Récupère une liste d'offre par rapport à une litse d'identifiant et renvoie une réponse JSON.
     *
     * @param mixed $data, La liste d'identifiant
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les offres.
     */
    public static function getOffresByListId(
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        $offres = $offreRepository->getOffresByListId($data['listeIdOffre']);
        for ($i = 0; $i < sizeof($offres); $i++) {
            $offres[$i]->setImage($offres[$i]->getImage());
        }
        $offresJSON = $serializer->serialize(
            $offres,
            'json',
            ['groups' => ['offre:read']]
        );
        return new JsonResponse([
            'offres' => $offresJSON,
            'serialized' => true
        ], Response::HTTP_OK, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Récupère les offres d'un réseau par rapport à son nom et renvoie une réponse JSON.
     *
     * @param OffreRepository $offreRepository Le repository des réseaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les réseaux listés.
     */
    public static function getOffresByReseau(
        string $reseauName,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        PaginatorInterface $paginator,
        string $page,
        string $limit
    ): JsonResponse {
        try {
            // on récupère tous les reseaux existants
            $offres = $offreRepository->trouveOffresReseaux($reseauName);
            $paginationOffres = $paginator->paginate($offres, $page, $limit);
            $totalPages = ceil($paginationOffres->getTotalItemCount() / $paginationOffres->getItemNumberPerPage());
            $reseauxJSON = $serializer->serialize(
                $paginationOffres,
                'json',
                ['groups' => ['offre:read']]
            );
            return new JsonResponse([
                'offres' => $reseauxJSON,
                'nb_pages' => $totalPages,
                'message' => "Offres du réseau {$reseauName}",
                'serialized' => true
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Récupère les offres qui appartiennent à un réseau et par leur titre et renvoie une réponse JSON.
     *
     * @param mixed $data Les données de l'offre à récupérer.
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les offres.
     */
    public static function getOffresByTitle(
        UtilisateurRepository $utilisateurRepository,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        $reseaux = $utilisateurRepository->findBy(['username' => $data['username']]);
        $reseaux = $reseaux[0]->getReseaux();
        $offres = [];
        for ($i = 0; $i < sizeof($reseaux); $i++) {
            $offresObject = $offreRepository->getOffresByTitleAndReseau($reseaux[$i]->getId(), $data['title']);
            $offres = array_merge($offres, $offresObject);
        }
        $offreJSON = $serializer->serialize(
            $offres,
            'json',
            ['groups' => ['offre:read']]
        );
        return new JsonResponse([
            'offres' => $offreJSON,
            'serialized' => true
        ], Response::HTTP_OK, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Récupère une offre par son créateur et renvoie une réponse JSON.
     *
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param int $id L'identifiant de l'utilisateur.
     *
     * @return JsonResponse La réponse JSON contenant les offres.
     */
    public static function getOffreByUtilisateur(
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        PaginatorInterface $paginator,
        string $username,
        int $page,
        int $limit
    ): JsonResponse {
        $offres = $offreRepository->trouveOffresUtilisateur($username);
        $paginationOffres = $paginator->paginate($offres, $page, $limit);
        $totalPages = ceil($paginationOffres->getTotalItemCount() / $paginationOffres->getItemNumberPerPage());
        for ($i = 0; $i < sizeof($offres); $i++) {
            $offres[$i]->setImage($offres[$i]->getImage());
        }
        $offreJSON = $serializer->serialize(
            $paginationOffres,
            'json',
            ['groups' => ['offre:read']]
        );
        return new JsonResponse([
            'offres' => $offreJSON,
            'nb_pages' => $totalPages,
            'serialized' => true
        ], Response::HTTP_OK, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Récupère les offres à partir d'une liste de réseaux et renvoie une réponse JSON.
     *
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données des offres à récupérer.
     *
     * @return JsonResponse La réponse JSON contenant les offres.
     */
    public static function getOffresReseaux(
        OffreRepository $offreRepository,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer,
        PaginatorInterface $paginator,
        int $page,
        int $limit,
        Security $security
    ): JsonResponse {

        $user = $security->getUser();

        // Vérifie si aucun utilisateur n'est connecté
        if (!$user) {
            return new JsonResponse(
                ['error' => 'Utilisateur non authentifié'],
                401
            );
        }

        $userArray = $utilisateurRepository->trouveUtilisateurByUsername($user->getUserIdentifier());

        $listeReseaux = $userArray[0]->getReseaux();

        $reseaux = [];
        foreach ($listeReseaux as $reseau) {
            $reseaux[] = $reseau->getNomReseau();
        }

        $offres = $offreRepository->getOffresByNomsReseaux($reseaux);
        $paginationOffres = $paginator->paginate($offres, $page, $limit);
        $totalPages = ceil($paginationOffres->getTotalItemCount() / $paginationOffres->getItemNumberPerPage());
        for ($i = 0; $i < sizeof($offres); $i++) {
            $offres[$i]->setImage($offres[$i]->getImage());
        }
        $offreJSON = $serializer->serialize(
            $paginationOffres,
            'json',
            ['groups' => [
                'offre:read',
                'budget_estimatif:read',
            ]]
        );
        return new JsonResponse([
            'offres' => $offreJSON,
            'nb_pages' => $totalPages,
            'serialized' => true
        ], Response::HTTP_OK, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Crée une nouvelle offre et renvoie une réponse JSON.
     *
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param MailerService $mailerService Le service d'envoi de mail.
     * @param mixed $data Les données de l'offre à créer.
     *
     * @return JsonResponse La réponse JSON après la création de l'offre.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création de l'offre.
     */
    public static function createOffre(
        OffreRepository $offreRepository,
        UtilisateurRepository $utilisateurRepository,
        ReseauRepository $reseauRepository,
        GenreMusicalRepository $genreMusicalRepository,
        ArtisteRepository $artisteRepository,
        EtatOffreRepository $etatOffreRepository,
        TypeOffreRepository $typeOffreRepository,
        SerializerInterface $serializer,
        MailerService $mailerService,
        mixed $data
    ): JsonResponse {
        try {
            // vérifie qu'aucune donnée ne manque pour la création de l'offre
            if (
                (
                empty($data['detailOffre']['titleOffre']) &&
                empty($data['detailOffre']['deadLine']) &&
                empty($data['detailOffre']['descrTournee']) &&
                empty($data['detailOffre']['dateMinProposee']) &&
                empty($data['detailOffre']['dateMaxProposee']) &&
                empty($data['detailOffre']['villeVisee']) &&
                empty($data['detailOffre']['regionVisee']) &&
                empty($data['detailOffre']['placesMin']) &&
                empty($data['detailOffre']['placesMax']) &&
                empty($data['detailOffre']['nbArtistesConcernes']) &&
                empty($data['detailOffre']['nbInvitesConcernes']) &&
                empty($data['extras']) &&
                empty($data['etatOffre']) &&
                empty($data['typeOffre']) &&
                empty($data['conditionsFinancieres']) &&
                empty($data['budgetEstimatif']) &&
                empty($data['ficheTechniqueArtiste']) &&
                empty($data['utilisateur']) &&
                empty($data['donneesSupplementaires']['reseau']) &&
                empty($data['donneesSupplementaires']['genreMusical']) &&
                empty($data['donneesSupplementaires']['artiste']) &&
                empty($data['image']['file'])
                )
            ) {
                throw new \InvalidArgumentException("L'offre n'est pas complète.");
            }

            // création de l'objet et instanciation des données de l'objet
            $offre = new Offre();
            $offre->setTitleOffre($data['detailOffre']['titleOffre']);
            $offre->setDeadLine(date_create($data['detailOffre']['deadLine']));
            $offre->setDescrTournee($data['detailOffre']['descrTournee']);
            $offre->setDateMinProposee(date_create($data['detailOffre']['dateMinProposee']));
            $offre->setDateMaxProposee(date_create($data['detailOffre']['dateMaxProposee']));
            $offre->setVilleVisee($data['detailOffre']['villeVisee']);
            $offre->setRegionVisee($data['detailOffre']['regionVisee']);
            $offre->setPlacesMin(intval($data['detailOffre']['placesMin']));
            $offre->setPlacesMax(intval($data['detailOffre']['placesMax']));
            $offre->setNbArtistesConcernes(
                intval($data['detailOffre']['nbArtistesConcernes'])
            );
            $offre->setNbInvitesConcernes(intval($data['detailOffre']['nbInvitesConcernes']));
            $offre->setImage($data['image']['file']);

            $liens = $data['ficheTechniqueArtiste']['liensPromotionnels'];
            $liensPromotionnels = "";
            foreach ($liens as $lien) {
                $liensPromotionnels .= "{$lien};";
            }
            $offre->setLiensPromotionnels($liensPromotionnels);
            $offre->setNbContributeur(0);

            if (isset($data['extras']['extrasParPDF']) && $data['extras']['extrasParPDF'] == false) {
                $extras = new Extras();
                $extras->setDescrExtras($data['extras']['descrExtras']);
                $extras->setCoutExtras(intval($data['extras']['coutExtras']));
                $extras->setExclusivite($data['extras']['exclusivite']);
                $extras->setException($data['extras']['exception']);
                $extras->setOrdrePassage($data['ficheTechniqueArtiste']['ordrePassage']);
                $extras->setClausesConfidentialites($data['extras']['clausesConfidentialites']);
                $offre->setExtras($extras);
            }

            if ($data['etatOffre']['nomEtatOffre'] == "") {
                $etatOffre = $etatOffreRepository->findBy(['nomEtat' => 'En Cours'])[0];
                $offre->setEtatOffre($etatOffre);
            } else {
                $etatOffre = new EtatOffre();
                $etatOffre->setNomEtat($data['etatOffre']['nomEtatOffre']);
                $offre->setEtatOffre($etatOffre);
            }

            if ($data['typeOffre']['nomTypeOffre'] == "") {
                $typeOffre = $typeOffreRepository->findBy(['nomTypeOffre' => 'Tournée'])[0];
                $offre->setTypeOffre($typeOffre);
            } else {
                $typeOffre = new TypeOffre();
                $typeOffre->setNomTypeOffre($data['typeOffre']['nomTypeOffre']);
                $offre->setTypeOffre($typeOffre);
            }

            if (
                isset($data['conditionsFinancieres']['conditionsFinancieresParPDF']) &&
                $data['conditionsFinancieres']['conditionsFinancieresParPDF'] == false
            ) {
                $conditionsFinancieres = new ConditionsFinancieres();
                $conditionsFinancieres->setMinimunGaranti(intval($data['conditionsFinancieres']['minimunGaranti']));
                $conditionsFinancieres->setConditionsPaiement($data['conditionsFinancieres']['conditionsPaiement']);
                $conditionsFinancieres->setPourcentageRecette(
                    floatval($data['conditionsFinancieres']['pourcentageRecette'])
                );
                $offre->setConditionsFinancieres($conditionsFinancieres);
            }

            if (
                isset($data['budgetEstimatif']['budgetEstimatifParPDF']) &&
                $data['budgetEstimatif']['budgetEstimatifParPDF'] == false
            ) {
                $budgetEstimatif = new BudgetEstimatif();
                $budgetEstimatif->setCachetArtiste(intval($data['budgetEstimatif']['cachetArtiste']));
                $budgetEstimatif->setFraisDeplacement(intval($data['budgetEstimatif']['fraisDeplacement']));
                $budgetEstimatif->setFraisHebergement(intval($data['budgetEstimatif']['fraisHebergement']));
                $budgetEstimatif->setFraisRestauration(intval($data['budgetEstimatif']['fraisRestauration']));
                $offre->setBudgetEstimatif($budgetEstimatif);
            }

            if (
                isset($data['ficheTechniqueArtiste']['ficheTechniqueArtisteParPDF']) &&
                $data['ficheTechniqueArtiste']['ficheTechniqueArtisteParPDF'] == false
            ) {
                $ficheTechniqueArtiste = new FicheTechniqueArtiste();
                $ficheTechniqueArtiste->setBesoinBackline(
                    $data['ficheTechniqueArtiste']['besoinBackline']
                );
                $ficheTechniqueArtiste->setBesoinEclairage(
                    $data['ficheTechniqueArtiste']['besoinEclairage']
                );
                $ficheTechniqueArtiste->setBesoinEquipements(
                    $data['ficheTechniqueArtiste']['besoinEquipements']
                );
                $ficheTechniqueArtiste->setBesoinScene(
                    $data['ficheTechniqueArtiste']['besoinScene']
                );
                $ficheTechniqueArtiste->setBesoinSonorisation(
                    $data['ficheTechniqueArtiste']['besoinSonorisation']
                );
                $offre->setFicheTechniqueArtiste($ficheTechniqueArtiste);
            }

            // création de l'objet de l'utilisateur qui a mit en ligne l'offre
            $utilisateur = $utilisateurRepository->trouveUtilisateurByUsername($data['utilisateur']['username']);
            $offre->setUtilisateur($utilisateur[0]);

            // ajoute l'offre sur le ou les réseau(x) indiqués
            $nb_reseaux = intval($data['donneesSupplementaires']['nbReseaux']);
            $reseaux_list = [];
            for ($i = 0; $i < $nb_reseaux; $i++) {
                $reseau = $reseauRepository->trouveReseauByName($data['donneesSupplementaires']['reseau'][$i]);
                $offre->addReseau($reseau[0]);
                $reseaux_list[] = $reseau[0];
            }

            $nb_genres_musicaux = intval($data['donneesSupplementaires']['nbGenresMusicaux']);
            for ($i = 0; $i < $nb_genres_musicaux; $i++) {
                $genreMusical = $genreMusicalRepository->trouveGenreMusicalByName(
                    $data['donneesSupplementaires']['genreMusical'][$i]
                );
                $offre->addGenreMusical($genreMusical[0]);
            }

            if (
                isset($data['ficheTechniqueArtiste']['ficheTechniqueArtisteParPDF']) &&
                $data['ficheTechniqueArtiste']['ficheTechniqueArtisteParPDF'] == false
            ) {
                $nb_artistes = intval($data['ficheTechniqueArtiste']['nbArtistes']);
                for ($i = 0; $i < $nb_artistes; $i++) {
                    // $artiste = $artisteRepository->trouveArtisteByName(
                    //      $data['ficheTechniqueArtiste']['artiste'][$i]
                    //);
                    // print_r($artiste);
                    // switch (sizeof($artiste)) {
                        // case 0:
                    $artisteObject = new Artiste();
                    $artisteObject->setNomArtiste($data['ficheTechniqueArtiste']['artiste'][$i]['nomArtiste']);
                    $artisteObject->setDescrArtiste("Artiste quelconque");
                    $artisteRepository->inscritArtiste($artisteObject);
                            // break;

                        // default:
                            // $offre->addArtiste($artiste[0]);
                            // break;
                    // }
                }
            }

            // ajout de l'offre en base de données
            $rep = $offreRepository->inscritOffre($offre);

            // vérification de l'action en BDD
            if ($rep) {
                $offreJSON = $serializer->serialize(
                    $offre,
                    'json',
                    ['groups' => ['offre:read']]
                );
                return new JsonResponse([
                    'offre' => $offreJSON,
                    'message' => "Offre inscrite !",
                    'serialized' => true
                ], Response::HTTP_OK, ['Access-Control-Allow-Origin' => '*']);
            }
            return new JsonResponse([
                'offre' => null,
                'message' => "Offre non inscrite, merci de regarder l'erreur décrite",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST, ['Access-Control-Allow-Origin' => '*']);
        } catch (\Exception $e) {
            throw new \RuntimeException(
                "Erreur lors de la création de l'offre",
                $e->getMessage() . ' ' . $e->getLine()
            );
        }
    }

    /**
     * Met à jour une offre existante et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'offre à mettre à jour.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param ReseauRepository $reseauRepository Le repository des réseaux.
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param ArtisteRepository $artisteRepository Le repository des artistes.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param MailerService $mailerService Le service d'envoi de mail.
     * @param mixed $data Les nouvelles données de l'offre.
     *
     * @return JsonResponse La réponse JSON après la mise à jour de l'offre.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour de l'offre.
     */
    public static function updateOffre(
        int $id,
        OffreRepository $offreRepository,
        ReseauRepository $reseauRepository,
        GenreMusicalRepository $genreMusicalRepository,
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer,
        MailerService $mailerService,
        mixed $data
    ): JsonResponse {
        try {
            // récupération de l'offre
            $offre = $offreRepository->find($id);

            // si il n'y pas d'offre trouvé
            if ($offre == null) {
                return new JsonResponse([
                    'offre' => null,
                    'message' => 'offre non trouvée, merci de donner un identifiant valide !',
                    'serialized' => true
                ], Response::HTTP_NOT_FOUND);
            }

            // on vérifie qu'aucune données ne manque pour la mise à jour
            // et on instancie les données dans l'objet
            if (isset($data['detailOffre']['titleOffre'])) {
                $offre->setTitleOffre($data['detailOffre']['titleOffre']);
            }
            if (isset($data['detailOffre']['deadLine'])) {
                $offre->setDeadline(date_create($data['detailOffre']['deadLine']));
            }
            if (isset($data['detailOffre']['descrTournee'])) {
                $offre->setDescrTournee($data['detailOffre']['descrTournee']);
            }
            if (isset($data['detailOffre']['dateMinProposee'])) {
                $offre->setDateMinProposee(date_create($data['detailOffre']['dateMinProposee']));
            }
            if (isset($data['detailOffre']['dateMaxProposee'])) {
                $offre->setDateMaxProposee(date_create($data['detailOffre']['dateMaxProposee']));
            }
            if (isset($data['detailOffre']['villeVisee'])) {
                $offre->setVilleVisee($data['detailOffre']['villeVisee']);
            }
            if (isset($data['detailOffre']['regionVisee'])) {
                $offre->setRegionVisee($data['detailOffre']['regionVisee']);
            }
            if (isset($data['detailOffre']['placesMin'])) {
                $offre->setPlacesMin($data['detailOffre']['placesMin']);
            }
            if (isset($data['detailOffre']['placesMax'])) {
                $offre->setPlacesMax($data['detailOffre']['placesMax']);
            }
            if (isset($data['detailOffre']['nbArtistesConcernes'])) {
                $offre->setNbArtistesConcernes($data['detailOffre']['nbArtistesConcernes']);
            }
            if (isset($data['detailOffre']['nbInvitesConcernes'])) {
                $offre->setNbInvitesConcernes($data['detailOffre']['nbInvitesConcernes']);
            }
            if (isset($data['ficheTechniqueArtiste']['liensPromotionnels'])) {
                $liensPromotionnels = "";
                foreach ($data['ficheTechniqueArtiste']['liensPromotionnels'] as $lien) {
                    $liensPromotionnels .= "{$lien};";
                }
                $offre->setLiensPromotionnels($liensPromotionnels);
            }
            if (isset($data['image']['file'])) {
                $offre->setImage($data['image']['file']);
            }
            if (isset($data['extras']['extrasParPDF']) && $data['extras']['extrasParPDF'] == false) {
                $extras = new Extras();
                if (isset($data['extras']['descrExtras'])) {
                    $extras->setDescrExtras($data['extras']['descrExtras']);
                }
                if (isset($data['extras']['coutExtras'])) {
                    $extras->setCoutExtras($data['extras']['coutExtras']);
                }
                if (isset($data['extras']['exclusivite'])) {
                    $extras->setExclusivite($data['extras']['exclusivite']);
                }
                if (isset($data['extras']['exception'])) {
                    $extras->setException($data['extras']['exception']);
                }
                if (isset($data['ficheTechniqueArtiste']['ordrePassage'])) {
                    $extras->setOrdrePassage($data['ficheTechniqueArtiste']['ordrePassage']);
                }
                if (isset($data['extras']['clausesConfidentialites'])) {
                    $extras->setClausesConfidentialites($data['extras']['clausesConfidentialites']);
                }
                $offre->setExtras($extras);
            }
            if (isset($data['etatOffre'])) {
                $etatOffre = new EtatOffre();
                if (isset($data['etatOffre']['nomEtatOffre'])) {
                    $etatOffre->setNomEtat($data['etatOffre']['nomEtatOffre']);
                }
                $offre->setEtatOffre($etatOffre);
            }
            if (isset($data['typeOffre'])) {
                $typeOffre = new TypeOffre();
                if (isset($data['typeOffre']['nomTypeOffre'])) {
                    $typeOffre->setNomTypeOffre($data['typeOffre']['nomTypeOffre']);
                }
                $offre->setTypeOffre($typeOffre);
            }
            if (
                isset($data['conditionsFinancieres']['conditionsFinancieresParPDF']) &&
                $data['conditionsFinancieres']['conditionsFinancieresParPDF'] == false
            ) {
                $conditionsFinancieres = new ConditionsFinancieres();
                if (isset($data['conditionsFinancieres']['minimunGaranti'])) {
                    $conditionsFinancieres->setMinimunGaranti($data['conditionsFinancieres']['minimunGaranti']);
                }
                if (isset($data['conditionsFinancieres']['conditionsPaiement'])) {
                    $conditionsFinancieres->setConditionsPaiement($data['conditionsFinancieres']['conditionsPaiement']);
                }
                if (isset($data['conditionsFinancieres']['pourcentageRecette'])) {
                    $conditionsFinancieres->setPourcentageRecette($data['conditionsFinancieres']['pourcentageRecette']);
                }
                $offre->setConditionsFinancieres($conditionsFinancieres);
            }
            if (
                isset($data['budgetEstimatif']['budgetEstimatifParPDF']) &&
                $data['budgetEstimatif']['budgetEstimatifParPDF'] == false
            ) {
                $budgetEstimatif = new BudgetEstimatif();
                if (isset($data['budgetEstimatif']['cachetArtiste'])) {
                    $budgetEstimatif->setCachetArtiste($data['budgetEstimatif']['cachetArtiste']);
                }
                if (isset($data['budgetEstimatif']['fraisDeplacement'])) {
                    $budgetEstimatif->setFraisDeplacement($data['budgetEstimatif']['fraisDeplacement']);
                }
                if (isset($data['budgetEstimatif']['fraisHebergement'])) {
                    $budgetEstimatif->setFraisHebergement($data['budgetEstimatif']['fraisHebergement']);
                }
                if (isset($data['budgetEstimatif']['fraisRestauration'])) {
                    $budgetEstimatif->setFraisRestauration($data['budgetEstimatif']['fraisRestauration']);
                }
                $offre->setBudgetEstimatif($budgetEstimatif);
            }
            if (
                isset($data['ficheTechniqueArtiste']['ficheTechniqueArtisteParPDF']) &&
                $data['ficheTechniqueArtiste']['ficheTechniqueArtisteParPDF'] == false
            ) {
                $ficheTechniqueArtiste = new FicheTechniqueArtiste();
                if (isset($data['ficheTechniqueArtiste']['besoinBackline'])) {
                    $ficheTechniqueArtiste->setBesoinBackline(
                        $data['ficheTechniqueArtiste']['besoinBackline']
                    );
                }
                if (isset($data['ficheTechniqueArtiste']['besoinEclairage'])) {
                    $ficheTechniqueArtiste->setBesoinEclairage(
                        $data['ficheTechniqueArtiste']['besoinEclairage']
                    );
                }
                if (isset($data['ficheTechniqueArtiste']['besoinEquipements'])) {
                    $ficheTechniqueArtiste->setBesoinEquipements(
                        $data['ficheTechniqueArtiste']['besoinEquipements']
                    );
                }
                if (isset($data['ficheTechniqueArtiste']['besoinScene'])) {
                    $ficheTechniqueArtiste->setBesoinScene(
                        $data['ficheTechniqueArtiste']['besoinScene']
                    );
                }
                if (isset($data['ficheTechniqueArtiste']['besoinSonorisation'])) {
                    $ficheTechniqueArtiste->setBesoinSonorisation(
                        $data['ficheTechniqueArtiste']['besoinSonorisation']
                    );
                }
                $offre->setFicheTechniqueArtiste($ficheTechniqueArtiste);
            }
            if (isset($data['donneesSupplementaires']['reseau'])) {
                $nb_reseaux = intval($data['donneesSupplementaires']['nbReseaux']);
                $reseaux_list = [];
                for ($i = 0; $i < $nb_reseaux; $i++) {
                    if (isset($data['donneesSupplementaires']['reseau'][$i]['nomReseau'])) {
                        $reseau = $reseauRepository->trouveReseauByName(
                            $data['donneesSupplementaires']['reseau'][$i]['nomReseau']
                        );
                        $offre->addReseau($reseau[0]);
                        $reseaux_list[] = $reseau[0];
                    }
                }
                foreach ($offre->getReseaux() as $reseauOffre) {
                    if (!in_array($reseauOffre, $reseaux_list)) {
                        $offre->removeReseau($reseauOffre);
                    }
                }
            }
            if (isset($data['donneesSupplementaires']['genreMusical'])) {
                $nb_genres_musicaux = intval($data['donneesSupplementaires']['nbGenresMusicaux']);
                $genres_list = [];
                for ($i = 0; $i < $nb_genres_musicaux; $i++) {
                    if (isset($data['donneesSupplementaires']['genreMusical'][$i]['nomGenreMusical'])) {
                        $genreMusical = $genreMusicalRepository->trouveGenreMusicalByName(
                            $data['donneesSupplementaires']['genreMusical'][$i]['nomGenreMusical']
                        );
                        $offre->addGenreMusical($genreMusical[0]);
                        $genres_list[] = $genreMusical[0];
                    }
                }
                foreach ($offre->getGenresMusicaux() as $genreOffre) {
                    if (!in_array($genreOffre, $genres_list)) {
                        $offre->removeGenreMusical($genreOffre);
                    }
                }
            }
            if (isset($data['ficheTechniqueArtiste']['artiste'])) {
                $nb_artistes = intval($data['ficheTechniqueArtiste']['nbArtistes']);
                $artistes_list = [];
                for ($i = 0; $i < $nb_artistes; $i++) {
                    $artiste = $artisteRepository->trouveArtisteByName(
                        $data['ficheTechniqueArtiste']['artiste'][$i]['nomArtiste']
                    );
                    if (count($artiste) == 0) {
                        $artisteObject = new Artiste();
                        $artisteObject->setNomArtiste($data['ficheTechniqueArtiste']['artiste'][$i]['nomArtiste']);
                        $artisteObject->setDescrArtiste("Artiste quelconque");
                        $artisteRepository->inscritArtiste($artisteObject);
                        $offre->addArtiste($artisteObject);
                        $artistes_list[] = $artisteObject;
                    } else {
                        $offre->addArtiste($artiste[0]);
                        $artistes_list[] = $artiste[0];
                    }
                }
                foreach ($offre->getArtistes() as $artisteOffre) {
                    if (!in_array($artisteOffre, $artistes_list)) {
                        $offre->removeArtiste($artisteOffre);
                    }
                }
            }

            // sauvegarde des modifications dans la BDD
            $rep = $offreRepository->updateOffre($offre);

            // si l'action à réussi
            if ($rep) {
                $offreJSON = $serializer->serialize(
                    $offre,
                    'json',
                    ['groups' => ['offre:read']]
                );

                return new JsonResponse([
                    'offre' => $offreJSON,
                    'message' => "Offre modifiée avec succès",
                    'serialized' => true
                ], Response::HTTP_OK);
            } else {
                return new JsonResponse([
                    'offre' => null,
                    'message' => "Offre non modifiée, merci de vérifier l'erreur décrite",
                    'serialized' => false
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException(
                "Erreur lors de la mise à jour de l'offre",
                $e->getMessage() . ' ' . $e->getLine()
            );
        }
    }

    /**
     * Supprime une offre et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'offre à supprimer.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'offre.
     */
    public static function deleteOffre(
        int $id,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre à supprimer
        $offre = $offreRepository->find($id);

        // si pas d'offre trouvé
        if ($offre == null) {
            return new JsonResponse([
                'offre' => null,
                'message' => 'offre non trouvée, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression de l'offre en BDD
        $rep = $offreRepository->removeOffre($offre);

        // si l'action à réussi
        if ($rep) {
            $offreJSON = $serializer->serialize(
                $offre,
                'json',
                ['groups' => ['offre:read']]
            );
            return new JsonResponse([
                'offre' => $offreJSON,
                'message' => 'offre supprimée',
                'serialized' => false
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse([
                'offre' => null,
                'message' => 'offre non supprimée !',
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute artiste correpondant à l'offre et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour ajouter un artiste correpondant à l'offre.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param ArtisteRepository $artisteRepository Le repository des artistes.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives d'ajout d'artiste correpondant à l'offre.
     */
    public static function ajouteArtisteOffre(
        mixed $data,
        OffreRepository $offreRepository,
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre et de l'artiste ciblés
        $offre = $offreRepository->find($data['idOffre']);
        $artiste = $artisteRepository->find($data['idArtiste']);

        // si pas d'offre ou d'artiste trouvé
        if ($offre == null || $artiste == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'Artiste ou offre non trouvés, merci de fournir des identifiants valides',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout de l'objet en BDD
        $offre->addArtiste($artiste);
        $rep = $offreRepository->updateOffre($offre);

        // si l'action à réussi
        if ($rep) {
            $offreJSON = $serializer->serialize(
                $offre,
                'json',
                ['groups' => ['offre:read']]
            );
            return new JsonResponse([
                'offre' => $offreJSON,
                'message' => "Artiste ajouté à l'offre.",
                'serialized' => false
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse([
                'offre' => null,
                'message' => "Artiste non ajouté au à l'offre !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire un artiste de l'offre et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour retirer un artiste de l'offre.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param ArtisteRepository $artisteRepository Le repository des utilisateurs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives de retrait d'un artiste de l'offre.
     */
    public static function retireArtisteOffre(
        mixed $data,
        OffreRepository $offreRepository,
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre et de l'artiste ciblés
        $offre = $offreRepository->find($data['idOffre']);
        $artiste = $artisteRepository->find($data['idArtiste']);

        if ($offre == null || $artiste == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'Artiste ou offre non trouvés, merci de fournir des identifiants valides',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout de l'objet en BDD
        $offre->removeArtiste($artiste);
        $rep = $offreRepository->updateOffre($offre);

        // si l'action à réussi
        if ($rep) {
            $offreJSON = $serializer->serialize(
                $offre,
                'json',
                ['groups' => ['offre:read']]
            );
            return new JsonResponse([
                'offre' => $offreJSON,
                'message' => "Artiste supprimé de l'offre.",
                'serialized' => false
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse([
                'offre' => null,
                'message' => "Artiste non supprimé de l'offre !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute un genre musical à l'offre et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour ajouter un genre à l'offre.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives d'ajout d'un genre musical à l'offre.
     */
    public static function ajouteGenreMusicalReseau(
        mixed $data,
        OffreRepository $offreRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre et du genre musical ciblés
        $offre = $offreRepository->find($data['idOffre']);
        $genreMusical = $genreMusicalRepository->find($data['idGenreMusical']);

        // si pas d'offre ou genre musical trouvé
        if ($offre == null || $genreMusical == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'Offre ou genre musical non trouvé, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout de l'objet en BDD
        $offre->addGenreMusical($genreMusical);
        $rep = $offreRepository->updateOffre($offre);

        // si l'action à réussi
        if ($rep) {
            $offreJSON = $serializer->serialize(
                $offre,
                'json',
                ['groups' => ['offre:read']]
            );
            return new JsonResponse([
                'offre' => $offreJSON,
                'message' => "Genre musical rattaché à l'offre",
                'serialized' => false
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse([
                'offre' => null,
                'message' => "Genre musical non rattaché à l'offre !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire un genre musical du réseau et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour retirer un genre du réseau.
     * @param OffreRepository $offreRepository Le repository des réseaux.
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives de retrait d'un genre musical du réseau.
     */
    public static function retireGenreMusicalReseau(
        mixed $data,
        OffreRepository $offreRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre et du genre musical ciblés
        $offre = $offreRepository->find($data['idOffre']);
        $genreMusical = $genreMusicalRepository->find($data['idGenreMusical']);

        // si pas d'offre ou genre musical trouvé
        if ($offre == null || $genreMusical == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'Offre ou genre musical non trouvé, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout de l'objet en BDD
        $offre->removeGenreMusical($genreMusical);
        $rep = $offreRepository->updateOffre($offre);

        // si l'action à réussi
        if ($rep) {
            $offreJSON = $serializer->serialize(
                $offre,
                'json',
                ['groups' => ['offre:read']]
            );
            return new JsonResponse([
                'offre' => $offreJSON,
                'message' => "Genre musical supprimé de l'offre",
                'serialized' => false
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse([
                'offre' => null,
                'message' => "Genre musical non supprimé de l'offre !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute un réseau à l'offre et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour ajouter un réseau à l'offre.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param ReseauRepository $reseauRepository Le repository des réseaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives d'ajout du réseau à l'offre.
     */
    public static function ajouteReseauOffre(
        mixed $data,
        OffreRepository $offreRepository,
        ReseauRepository $reseauRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre et du réseau ciblés
        $offre = $offreRepository->find($data['idOffre']);
        $reseau = $reseauRepository->find($data['idReseau']);

        // si pas d'offre ou du réseau trouvé
        if ($offre == null || $reseau == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'Réseau ou offre non trouvés, merci de fournir des identifiants valides',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout de l'objet en BDD
        $offre->addReseau($reseau);
        $rep = $offreRepository->updateOffre($offre);

        // si l'action à réussi
        if ($rep) {
            $offreJSON = $serializer->serialize(
                $offre,
                'json',
                ['groups' => ['offre:read']]
            );
            return new JsonResponse([
                'offre' => $offreJSON,
                'message' => "Réseau ajouté à l'offre.",
                'serialized' => false
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse([
                'offre' => null,
                'message' => "Réseau non ajouté au à l'offre !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire un réseau à l'offre et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour retirer un réseau de l'offre.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param ReseauRepository $reseauRepository Le repository des réseaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives de retrait d'un réseau de l'offre.
     */
    public static function retireReseauOffre(
        mixed $data,
        OffreRepository $offreRepository,
        ReseauRepository $reseauRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre et du réseau ciblés
        $offre = $offreRepository->find($data['idOffre']);
        $reseau = $reseauRepository->find($data['idReseau']);

        if ($offre == null || $reseau == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'Réseau ou offre non trouvés, merci de fournir des identifiants valides',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout de l'objet en BDD
        $offre->removeReseau($reseau);
        $rep = $offreRepository->updateOffre($offre);

        // si l'action à réussi
        if ($rep) {
            $offreJSON = $serializer->serialize(
                $offre,
                'json',
                ['groups' => ['offre:read']]
            );
            return new JsonResponse([
                'offre' => $offreJSON,
                'message' => "Réseau supprimé de l'offre.",
                'serialized' => false
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse([
                'offre' => null,
                'message' => "Réseau non supprimé de l'offre !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute un commentaire et un utilisateur qui a commenté l'offre et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour ajouter un commentaire à l'offre.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param CommentaireRepository $commentaireRepository Le repository des commentaires.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives d'ajout d'un commentaire à l'offre.
     */
    public static function ajouteUtilisateurCommentaireOffre(
        mixed $data,
        OffreRepository $offreRepository,
        UtilisateurRepository $utilisateurRepository,
        CommentaireRepository $commentaireRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre et de l'utilisateur ciblés
        $offre = $offreRepository->find($data['idOffre']);
        $utilisateur = $utilisateurRepository->find($data['idUtilisateur']);

        // si pas d'offre ou utilisateur trouvé
        if ($offre == null || $utilisateur == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'Offre ou utilisateur non trouvé, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        $commentaire = new Commentaire();
        $commentaire->setCommentaire($data['contenu']);
        $commentaire->setOffre($offre);
        $commentaire->setUtilisateur($utilisateur);
        $rep = $commentaireRepository->inscritCommentaire($commentaire);

        // si l'action à réussi
        if (!$rep) {
            return new JsonResponse([
                'commentaire' => null,
                'message' => "Commentaire non ajouté à l'offre !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }

        // ajout de l'objet en BDD
        $offre->addCommenteePar($utilisateur);
        $rep = $offreRepository->updateOffre($offre);

        // si l'action à réussi
        if ($rep) {
            $offreJSON = $serializer->serialize(
                $offre,
                'json',
                ['groups' => ['offre:read']]
            );
            return new JsonResponse([
                'offre' => $offreJSON,
                'message' => "Genre musical rattaché à l'offre",
                'serialized' => false
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse([
                'offre' => null,
                'message' => "Genre musical non rattaché à l'offre !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire commentaire à l'offre et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour retirer un genre du réseau.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param CommentaireRepository $commentaireRepository Le repository des commentaires.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives de retrait d'un genre musical du réseau.
     */
    public static function retireUtilisateurCommentaireOffre(
        mixed $data,
        OffreRepository $offreRepository,
        UtilisateurRepository $utilisateurRepository,
        CommentaireRepository $commentaireRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre, de l'utilisateur et du commentaire ciblés
        $offre = $offreRepository->find($data['idOffre']);
        $utilisateur = $utilisateurRepository->find($data['idUtilisateur']);
        $commentaire = $commentaireRepository->find($data['idCommentaire']);

        // si pas d'offre, utilisateur ou commentaire trouvé
        if ($offre == null || $utilisateur == null || $commentaire == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'Offre ou utilisateur ou commentaire non trouvé, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression de l'objet en BDD
        $rep = $commentaireRepository->removeCommentaire($commentaire);
        if (!$rep) {
            return new JsonResponse([
                'commentaire' => null,
                'message' => "Commentaire non supprimé de l'offre !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }

        // suppression de l'objet en BDD
        $offre->removeCommenteePar($utilisateur);
        $rep = $offreRepository->updateOffre($offre);

        // si l'action à réussi
        if ($rep) {
            $offreJSON = $serializer->serialize(
                $offre,
                'json',
                ['groups' => ['offre:read']]
            );
            return new JsonResponse([
                'offre' => $offreJSON,
                'message' => "Genre musical supprimé de l'offre",
                'serialized' => false
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse([
                'offre' => null,
                'message' => "Genre musical non supprimé de l'offre !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute une réponse à une offre et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour ajouter un commentaire à l'offre.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param ReponseRepository $reponseRepository Le repository des réponses.
     * @param EtatReponseRepository $etatReponseRepository Le repository des états réponse.
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives d'ajout d'une réponse à l'offre.
     */
    public static function ajouteReponseOffre(
        mixed $data,
        OffreRepository $offreRepository,
        ReponseRepository $reponseRepository,
        EtatReponseRepository $etatReponseRepository,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre et de la réponse ciblése
        $offre = $offreRepository->find($data['idOffre']);
        $utilisateur = $utilisateurRepository->find($data['idUtilisateur']);
        $etatReponse = $etatReponseRepository->find($data['idEtatReponse']);

        // si pas d'offre ou utilisateur trouvé
        if ($offre == null || $utilisateur == null || $etatReponse == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'Offre, utilisateur ou état réponse non trouvé(e), merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        $reponse = new Reponse();
        $reponse->setEtatReponse($etatReponse);
        $reponse->setOffre($offre);
        $reponse->setUtilisateur($utilisateur);
        $reponseRepository->ajouterReponse($reponse);


        // ajout de l'objet en BDD
        $offre->addReponse($reponse);
        $rep = $offreRepository->updateOffre($offre);

        // si l'action à réussi
        if ($rep) {
            $offreJSON = $serializer->serialize(
                $offre,
                'json',
                ['groups' => ['offre:read']]
            );
            return new JsonResponse([
                'offre' => $offreJSON,
                'message' => "Réponse rattachée à l'offre",
                'serialized' => false
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse([
                'offre' => null,
                'message' => "Réponse non rattachée à l'offre !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire réponse à l'offre et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour retirer uné réponse de l'offre.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param ReponseRepository $reponseRepository Le repository des réponses.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives de retrait d'une réponse à l'offre.
     */
    public static function retireReponseOffre(
        mixed $data,
        OffreRepository $offreRepository,
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre et de la réponse ciblées
        $offre = $offreRepository->find($data['idOffre']);
        $reponse = $reponseRepository->find($data['idReponse']);

        // si pas d'offre ou réponse trouvée
        if ($offre == null || $reponse = null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'Offre ou réponse non trouvé(e), merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression de l'objet en BDD
        $offre->removeReponse($reponse);
        $rep = $offreRepository->updateOffre($offre);

        // si l'action à réussi
        if ($rep) {
            $offreJSON = $serializer->serialize(
                $offre,
                'json',
                ['groups' => ['offre:read']]
            );
            return new JsonResponse([
                'offre' => $offreJSON,
                'message' => "Réponse supprimée de l'offre",
                'serialized' => false
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse([
                'offre' => null,
                'message' => "Réponse non supprimée de l'offre !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
