<?php

namespace App\Services;

use App\Repository\FicheTechniqueArtisteRepository;
use App\Repository\OffreRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\FicheTechniqueArtiste;

/**
 * Class FicheTechniqueArtisteService
 * Est le gestionnaire des fiches techniques des artistes (gestion de la logique métier)
 */
class FicheTechniqueArtisteService
{
    /**
     * Récupère toutes les fiches techniques des artistes et renvoie une réponse JSON.
     *
     * @param FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository, le repository des fiches techniques.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les fiches techniques des artistes.
     */
    public static function getFichesTechniquesArtiste(
        FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère toutes les fiches techniques
        $fichesTechniquesArtiste = $ficheTechniqueArtisteRepository->findAll();
        $fichesTechniquesArtisteJSON = $serializer->serialize(
            $fichesTechniquesArtiste,
            'json',
            ['groups' => ['fiche_technique_artiste:read']]
        );
        return new JsonResponse([
            'fiches_techniques_artistes' => $fichesTechniquesArtisteJSON,
            'message' => "Liste des fiches techniques des artistes",
            'serialized' => true
        ], Response::HTTP_OK);
    }

    /**
     * Récupère une fiche technique d'artiste par son id et renvoie une réponse JSON.
     *
     * @param int $id, L'identifiant de la fiche tehcnique
     * @param FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository, le repository des fiches techniques.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les fiches techniques des artistes.
     */
    public static function getFichesTechniqueArtisteById(
        int $id,
        FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère toutes les fiches techniques
        $fichesTechniquesArtiste = $ficheTechniqueArtisteRepository->findBy(['id' => $id]);
        $fichesTechniquesArtisteJSON = $serializer->serialize(
            $fichesTechniquesArtiste,
            'json',
            ['groups' => ['fiche_technique_artiste:read']]
        );
        return new JsonResponse([
            'fiches_techniques_artistes' => $fichesTechniquesArtisteJSON,
            'message' => "Liste des fiches techniques des artistes",
            'serialized' => true
        ], Response::HTTP_OK);
    }

    /**
     * Créer une nouvelle fiche technique d'artiste et renvoie une réponse JSON.
     *
     * @param FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository Le repository des fiches techniques.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données de la fiche technique à créer.
     *
     * @return JsonResponse La réponse JSON après la création de la fiche technique.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création de la fiche technique.
     */
    public static function createFicheTechniqueArtiste(
        FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // création de l'objet et instanciation des données de l'objet
            $ficheTechniqueArtiste = new FicheTechniqueArtiste();
            $ficheTechniqueArtiste->setBesoinSonorisation(
                !(empty($data['ficheTechniqueArtiste']['besoinSonorisation'])) ?
                    $data['ficheTechniqueArtiste']['besoinSonorisation'] :
                    null
            );
            $ficheTechniqueArtiste->setBesoinEclairage(
                !(empty($data['ficheTechniqueArtiste']['besoinEclairage'])) ?
                    $data['ficheTechniqueArtiste']['besoinEclairage'] :
                    null
            );
            $ficheTechniqueArtiste->setBesoinScene(
                !(empty($data['ficheTechniqueArtiste']['besoinScene'])) ?
                    $data['ficheTechniqueArtiste']['besoinScene'] :
                    null
            );
            $ficheTechniqueArtiste->setBesoinBackline(
                !(empty($data['ficheTechniqueArtiste']['besoinBackline'])) ?
                    $data['ficheTechniqueArtiste']['besoinBackline'] :
                    null
            );
            $ficheTechniqueArtiste->setBesoinEquipements(
                !(empty($data['ficheTechniqueArtiste']['besoinEquipements'])) ?
                    $data['ficheTechniqueArtiste']['besoinEquipements'] :
                    null
            );

            // ajout de la fiche technique en base de données
            $rep = $ficheTechniqueArtisteRepository->inscritFicheTechniqueArtiste($ficheTechniqueArtiste);

            // vérification de l'action en BDD
            if ($rep) {
                $ficheTechniqueArtisteJSON = $serializer->serialize(
                    $ficheTechniqueArtiste,
                    'json',
                    ['groups' => ['fiche_technique_artiste:read']]
                );
                return new JsonResponse([
                    'fiche_technique_artiste' => $ficheTechniqueArtisteJSON,
                    'message' => "fiche technique de l'artiste inscrit !",
                    'serialized' => true
                ], Response::HTTP_CREATED);
            }
            return new JsonResponse([
                'fiche_technique_artiste' => null,
                'message' => "fiche technique de l'artiste non inscrit, merci de regarder l'erreur décrite",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création de la fiche technique", $e->getMessage());
        }
    }

    /**
     * Met à jour une fiche technique de l'artiste existant et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de la fiche technique à mettre à jour.
     * @param FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository Le repository des fiches techniques.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données de la fiche technique.
     *
     * @return JsonResponse La réponse JSON après la mise à jour de la fiche technique.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour de la fiche technique.
     */
    public static function updateFicheTechniqueArtiste(
        int $id,
        FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // récupération de la fiche technique
            $ficheTechniqueArtiste = $ficheTechniqueArtisteRepository->find($id);

            // si il n'y pas de fiche technique trouvée
            if ($ficheTechniqueArtiste == null) {
                return new JsonResponse([
                    'fiche_technique_artiste' => null,
                    'message' => "fiche technique de l'artiste non trouvée, merci de donner un identifiant valide !",
                    'serialized' => true
                ], Response::HTTP_NOT_FOUND);
            }

            // on vérifie qu'aucune données ne manque pour la mise à jour
            // et on instancie les données dans l'objet
            if (isset($data['ficheTechniqueArtiste']['besoinSonorisation'])) {
                $ficheTechniqueArtiste->setBesoinSonorisation($data['ficheTechniqueArtiste']['besoinSonorisation']);
            }
            if (isset($data['ficheTechniqueArtiste']['besoinEclairage'])) {
                $ficheTechniqueArtiste->setBesoinEclairage($data['ficheTechniqueArtiste']['besoinEclairage']);
            }
            if (isset($data['ficheTechniqueArtiste']['besoinScene'])) {
                $ficheTechniqueArtiste->setBesoinScene($data['ficheTechniqueArtiste']['besoinScene']);
            }
            if (isset($data['ficheTechniqueArtiste']['besoinBackline'])) {
                $ficheTechniqueArtiste->setBesoinBackline($data['ficheTechniqueArtiste']['besoinBackline']);
            }
            if (isset($data['ficheTechniqueArtiste']['setBesoinEquipements'])) {
                $ficheTechniqueArtiste->setBesoinEquipements($data['ficheTechniqueArtiste']['setBesoinEquipements']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $ficheTechniqueArtisteRepository->updateFicheTechniqueArtiste($ficheTechniqueArtiste);

            // si l'action à réussi
            if ($rep) {
                $ficheTechniqueArtisteJSON = $serializer->serialize(
                    $ficheTechniqueArtiste,
                    'json',
                    ['groups' => ['fiche_technique_artiste:read']]
                );

                return new JsonResponse([
                    'fiche_technique_artiste' => $ficheTechniqueArtisteJSON,
                    'message' => "fiche technique de l'artiste modifiée avec succès",
                    'serialized' => true
                ], Response::HTTP_OK);
            } else {
                return new JsonResponse([
                    'fiche_technique_artiste' => null,
                    'message' => "fiche technique de l'artiste non modifiée, merci de vérifier l'erreur décrite",
                    'serialized' => false
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour de la fiche technique", $e->getMessage());
        }
    }

    /**
     * Supprime une fiche technique de l'artiste et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de la fiche technique à supprimer.
     * @param FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository Le repository des fiches techniques.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de la fiche technique.
     */
    public static function deleteFicheTechniqueArtiste(
        int $id,
        FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de la fiche technique à supprimer
        $ficheTechniqueArtiste = $ficheTechniqueArtisteRepository->find($id);

        // si pas de fiche technique trouvée
        if ($ficheTechniqueArtiste == null) {
            return new JsonResponse([
                'fiche_technique_artiste' => null,
                'message' => "fiche technique de l'artiste non trouvée, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression de la fiche technique en BDD
        $rep = $ficheTechniqueArtisteRepository->removeFicheTechniqueArtiste($ficheTechniqueArtiste);

        // si l'action à réussi
        if ($rep) {
            $ficheTechniqueArtisteJSON = $serializer->serialize(
                $ficheTechniqueArtiste,
                'json',
                ['groups' => ['fiche_technique_artiste:read']]
            );
            return new JsonResponse([
                'fiche_technique_artiste' => $ficheTechniqueArtisteJSON,
                'message' => "fiche technique de l'artiste supprimé",
                'serialized' => false
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse([
                'fiche_technique_artiste' => null,
                'message' => "fiche technique de l'artiste non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute une offre à la fiche technique de l'artiste et renvoie une réponse JSON.
     *
     * @param FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository Le repository de la fiche de l'artiste.
     * @param OffreRepository $offreRepository Le repository des offres .
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de la fiche technique de l'artiste.
     */
    public static function ajouteOffreFicheTechniqueArtiste(
        FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération de la fiche technique de l'artiste
        $ficheTechniqueArtiste = $ficheTechniqueArtisteRepository->find(intval($data['idFicheTechniqueArtiste']));
        $offre = $offreRepository->find(intval($data['idOffre']));

        // si pas trouvée
        if ($ficheTechniqueArtiste == null || $offre == null) {
            return new JsonResponse([
                'fiche_technique_artiste' => null,
                'message' => "fiche de l'artiste ou offre non trouvée, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout en BDD
        $ficheTechniqueArtiste->addOffre($offre);
        $rep = $ficheTechniqueArtisteRepository->updateFicheTechniqueArtiste($ficheTechniqueArtiste);

        // réponse après suppression
        if ($rep) {
            $ficheTechniqueArtisteJSON = $serializer->serialize(
                $ficheTechniqueArtiste,
                'json',
                ['groups' => ['fiche_technique_artiste:read']]
            );
            return new JsonResponse([
                'fiche_technique_artiste' => $ficheTechniqueArtisteJSON,
                'message' => "Type d'offre supprimé",
                'serialized' => false
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse([
                'fiche_technique_artiste' => null,
                'message' => "Type d'offre non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire une offre à la fiche technique de l'artiste et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de la fiche technique de l'artiste.
     * @param FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository Le repository de la fiche de l'artiste.
     * @param OffreRepository $offreRepository Le repository desoffres .
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de la fiche technique de l'artiste.
     */
    public static function retireOffreFicheTechniqueArtiste(
        FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération de la fiche technique de l'artiste à supprimer
        $ficheTechniqueArtiste = $ficheTechniqueArtisteRepository->find(intval($data['idFicheTechniqueArtiste']));
        $offre = $offreRepository->find(intval($data['idOffre']));

        // si pas trouvé
        if ($ficheTechniqueArtiste == null || $offre == null) {
            return new JsonResponse([
                'fiche_technique_artiste' => null,
                'message' => "fiche de l'artiste ou offre non trouvée, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression en BDD
        $ficheTechniqueArtiste->removeOffre($offre);
        $rep = $ficheTechniqueArtisteRepository->updateFicheTechniqueArtiste($ficheTechniqueArtiste);

        // réponse après suppression
        if ($rep) {
            $ficheTechniqueArtisteJSON = $serializer->serialize(
                $ficheTechniqueArtiste,
                'json',
                ['groups' => ['fiche_technique_artiste:read']]
            );
            return new JsonResponse([
                'fiche_technique_artiste' => $ficheTechniqueArtisteJSON,
                'message' => "Type d'offre supprimé",
                'serialized' => false
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse([
                'fiche_technique_artiste' => null,
                'message' => "Type d'offre non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
