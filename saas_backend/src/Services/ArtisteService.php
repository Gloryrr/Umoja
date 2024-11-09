<?php

namespace App\Services;

use App\Repository\ArtisteRepository;
use App\Repository\GenreMusicalRepository;
use App\Repository\OffreRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Artiste;

/**
 * Class ArtisteService
 * Est le gestionnaire des artistes (gestion de la logique métier)
 */
class ArtisteService
{
    /**
     * Récupère tous les artistes et renvoie une réponse JSON.
     *
     * @param ArtisteRepository $artisteRepository Le repository des artistes.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les artistes.
     */
    public static function getArtistes(
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les artistes
        $artistes = $artisteRepository->findAll();
        $artistesJSON = $serializer->serialize($artistes, 'json', ['groups' => ['artiste:read']]);
        return new JsonResponse([
            'artistes' => $artistesJSON,
            'message' => "Liste des artistes",
            'serialized' => true
        ], Response::HTTP_OK);
    }

    /**
     * Crée un nouveau artiste et renvoie une réponse JSON.
     *
     * @param ArtisteRepository $artisteRepository Le repository des artistes.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données de l'artiste à créer.
     *
     * @return JsonResponse La réponse JSON après la création de l'artiste.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création de l'artiste.
     */
    public static function createArtiste(
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // vérifie qu'aucune donnée ne manque pour la création de l'artiste
            if (empty($data['nomArtiste']) || empty($data['descrArtiste'])) {
                throw new \InvalidArgumentException("Le contenu ou le nom de l'artiste est requis.");
            }

            // création de l'objet et instanciation des données de l'objet
            $artiste = new Artiste();
            $artiste->setNomArtiste($data['nomArtiste']);
            $artiste->setDescrArtiste($data['descrArtiste']);

            // ajout de l'artiste en base de données
            $rep = $artisteRepository->inscritArtiste($artiste);

            // vérification de l'action en BDD
            if ($rep) {
                $artisteJSON = $serializer->serialize($artiste, 'json', ['groups' => ['artiste:read']]);
                return new JsonResponse([
                    'artiste' => $artisteJSON,
                    'message' => "artiste inscrit !",
                    'serialized' => true
                ], Response::HTTP_CREATED);
            }
            return new JsonResponse([
                'artiste' => null,
                'message' => "artiste non inscrit, merci de regarder l'erreur décrite",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création de l'artiste", $e->getCode());
        }
    }

    /**
     * Met à jour un artiste existant et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'artiste à mettre à jour.
     * @param ArtisteRepository $artisteRepository Le repository des artistes.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données de l'artiste.
     *
     * @return JsonResponse La réponse JSON après la mise à jour de l'artiste.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour de l'artiste.
     */
    public static function updateArtiste(
        int $id,
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // récupération de l'artiste
            $artiste = $artisteRepository->find($id);

            // si il n'y pas d'artiste trouvé
            if ($artiste == null) {
                return new JsonResponse([
                    'artiste' => null,
                    'message' => 'artiste non trouvé, merci de donner un identifiant valide !',
                    'serialized' => true
                ], Response::HTTP_NOT_FOUND);
            }

            // on vérifie qu'aucune données ne manque pour la mise à jour
            // et on instancie les données dans l'objet
            if (isset($data['nomArtiste'])) {
                $artiste->setNomArtiste($data['nomArtiste']);
            }

            if (isset($data['descrArtiste'])) {
                $artiste->setDescrArtiste($data['descrArtiste']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $artisteRepository->updateArtiste($artiste);

            // si l'action à réussi
            if ($rep) {
                $artiste = $serializer->serialize($artiste, 'json', ['groups' => ['artiste:read']]);

                return new JsonResponse([
                    'artiste' => $artiste,
                    'message' => "artiste modifié avec succès",
                    'serialized' => true
                ], Response::HTTP_OK);
            } else {
                return new JsonResponse([
                    'artiste' => null,
                    'message' => "artiste non modifié, merci de vérifier l'erreur décrite",
                    'serialized' => false
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour de l'artiste", $e->getCode());
        }
    }

    /**
     * Supprime un artiste et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'artiste à supprimer.
     * @param ArtisteRepository $artisteRepository Le repository des artistes.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'artiste.
     */
    public static function deleteArtiste(
        int $id,
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'artiste à supprimer
        $artiste = $artisteRepository->find($id);

        // si pas d'artiste trouvé
        if ($artiste == null) {
            return new JsonResponse([
                'artiste' => null,
                'message' => 'artiste non trouvé, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression de l'artiste en BDD
        $rep = $artisteRepository->removeArtiste($artiste);

        // si l'action à réussi
        if ($rep) {
            $artisteJSON = $serializer->serialize($artiste, 'json', ['groups' => ['artiste:read']]);
            return new JsonResponse([
                'artiste' => $artisteJSON,
                'message' => 'artiste supprimé',
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'artiste' => null,
                'message' => 'artiste non supprimé !',
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute un genre musical à l'artiste et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'artiste.
     * @param ArtisteRepository $artisteRepository Le repository des artistes.
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'artiste.
     */
    public static function ajouteGenreMusicalArtiste(
        ArtisteRepository $artisteRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération de l'artiste à supprimer
        $artiste = $artisteRepository->find(intval($data['idArtiste']));
        $genreMusical = $genreMusicalRepository->find(intval($data['idGenreMusical']));

        // si pas trouvé
        if ($artiste == null || $genreMusical == null) { 
            return new JsonResponse([
                'artiste' => null,
                'message' => "artiste ou genre musical non trouvée, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression en BDD
        $artiste->addGenreMusical($genreMusical);
        $rep = $artisteRepository->updateArtiste($artiste);

        // réponse après suppression
        if ($rep) {
            $artisteJSON = $serializer->serialize($artiste, 'json', ['groups' => ['artiste:read']]);
            return new JsonResponse([
                'artiste' => $artisteJSON,
                'message' => "Type d'offre supprimé",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'artiste' => null,
                'message' => "Type d'offre non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire un genre musical à l'artiste et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'artiste.
     * @param ArtisteRepository $artisteRepository Le repository des artistes.
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'artiste.
     */
    public static function retireGenreMusicalArtiste(
        ArtisteRepository $artisteRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération de l'artiste à supprimer
        $artiste = $artisteRepository->find(intval($data['idArtiste']));
        $genreMusical = $genreMusicalRepository->find(intval($data['idGenreMusical']));

        // si pas trouvé
        if ($artiste == null || $genreMusical == null) { 
            return new JsonResponse([
                'artiste' => null,
                'message' => "artiste ou genre musical non trouvée, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression en BDD
        $artiste->removeGenreMusical($genreMusical);
        $rep = $artisteRepository->updateArtiste($artiste);

        // réponse après suppression
        if ($rep) {
            $artisteJSON = $serializer->serialize($artiste, 'json', ['groups' => ['artiste:read']]);
            return new JsonResponse([
                'artiste' => $artisteJSON,
                'message' => "Type d'offre supprimé",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'artiste' => null,
                'message' => "Type d'offre non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute une offre à l'artiste et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'artiste.
     * @param ArtisteRepository $artisteRepository Le repository des artistes.
     * @param OffreRepository $offreRepository Le repository des genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'artiste.
     */
    public static function ajouteOffreArtiste(
        ArtisteRepository $artisteRepository,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération de l'artiste à supprimer
        $artiste = $artisteRepository->find(intval($data['idArtiste']));
        $offre = $offreRepository->find(intval($data['idOffre']));

        // si pas trouvé
        if ($artiste == null || $offre == null) { 
            return new JsonResponse([
                'artiste' => null,
                'message' => "artiste ou genre musical non trouvée, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression en BDD
        $artiste->addOffre($offre);
        $rep = $artisteRepository->updateArtiste($artiste);

        // réponse après suppression
        if ($rep) {
            $artisteJSON = $serializer->serialize($artiste, 'json', ['groups' => ['artiste:read']]);
            return new JsonResponse([
                'artiste' => $artisteJSON,
                'message' => "Type d'offre supprimé",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'artiste' => null,
                'message' => "Type d'offre non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire une offre à l'artiste et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'artiste.
     * @param ArtisteRepository $artisteRepository Le repository des artistes.
     * @param OffreRepository $offreRepository Le repository des genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'artiste.
     */
    public static function retireOffreArtiste(
        ArtisteRepository $artisteRepository,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération de l'artiste à supprimer
        $artiste = $artisteRepository->find(intval($data['idArtiste']));
        $offre = $offreRepository->find(intval($data['idOffre']));

        // si pas trouvé
        if ($artiste == null || $offre == null) { 
            return new JsonResponse([
                'artiste' => null,
                'message' => "artiste ou genre musical non trouvée, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression en BDD
        $artiste->removeOffre($offre);
        $rep = $artisteRepository->updateArtiste($artiste);

        // réponse après suppression
        if ($rep) {
            $artisteJSON = $serializer->serialize($artiste, 'json', ['groups' => ['artiste:read']]);
            return new JsonResponse([
                'artiste' => $artisteJSON,
                'message' => "Type d'offre supprimé",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'artiste' => null,
                'message' => "Type d'offre non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
