<?php

namespace App\Services;

use App\Repository\GenreMusicalRepository;
use App\Repository\ReseauRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\OffreRepository;
use App\Repository\ArtisteRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\GenreMusical;

/**
 * Class GenreMusicalService
 * Est le gestionnaire des genres de musiques (gestion de la logique métier)
 */
class GenreMusicalService
{
    /**
     * Récupère tous les genres musicaux et renvoie une réponse JSON.
     *
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les genres musicaux.
     */
    public static function getGenresMusicaux(
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les genresMusicaux
        $genresMusicaux = $genreMusicalRepository->findAll();
        $genresMusicauxJSON = $serializer->serialize(
            $genresMusicaux,
            'json',
            ['groups' => ['genreMusical:read']]
        );
        return new JsonResponse([
            'genres_musicaux' => $genresMusicauxJSON,
            'message' => "Liste des genres musicaux",
            'serialized' => true
        ], Response::HTTP_OK);
    }

    /**
     * Crée un nouveau genre musical et renvoie une réponse JSON.
     *
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données du genre musical à créer.
     *
     * @return JsonResponse La réponse JSON après la création du genre musical.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création du genre.
     */
    public static function createGenreMusical(
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // vérifie qu'aucune donnée ne manque pour la création du genre
            if (empty($data['nomGenreMusical'])) {
                throw new \InvalidArgumentException("Le nom du genre musical est requis.");
            }

            // création de l'objet et instanciation des données de l'objet
            $genreMusical = new GenreMusical();
            $genreMusical->setNomGenreMusical($data['nomGenreMusical']);

            // ajout de l'genre_musical en base de données
            $rep = $genreMusicalRepository->inscritGenreMusical($genreMusical);

            // vérification de l'action en BDD
            if ($rep) {
                $genreMusicalJSON = $serializer->serialize(
                    $genreMusical,
                    'json',
                    ['groups' => ['genreMusical:read']]
                );
                return new JsonResponse([
                    'genre_musical' => $genreMusicalJSON,
                    'message' => "Genre musical inscrit !",
                    'serialized' => true
                ], Response::HTTP_CREATED);
            }
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "Genre musical non inscrit, merci de regarder l'erreur décrite",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création du genre musical", $e->getCode());
        }
    }

    /**
     * Met à jour un utilisateur existant et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant du genre musical à mettre à jour.
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données du genre musical.
     *
     * @return JsonResponse La réponse JSON après la mise à jour du genre musical.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour du genre musical.
     */
    public static function updateGenreMusical(
        int $id,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // récupération du genre
            $genreMusical = $genreMusicalRepository->find($id);

            // si il n'y pas de genre trouvé
            if ($genreMusical == null) {
                return new JsonResponse([
                    'genre_musical' => null,
                    'message' => 'Genre musical non trouvé, merci de donner un identifiant valide !',
                    'serialized' => true
                ], Response::HTTP_NOT_FOUND);
            }

            // on vérifie qu'aucune données ne manque pour la mise à jour
            // et on instancie les données dans l'objet
            if (isset($data['nomGenreMusical'])) {
                $genreMusical->setNomGenreMusical($data['nomGenreMusical']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $genreMusicalRepository->updateGenreMusical($genreMusical);

            // si l'action à réussi
            if ($rep) {
                $genreMusical = $serializer->serialize(
                    $genreMusical,
                    'json',
                    ['groups' => ['genreMusical:read']]
                );

                return new JsonResponse([
                    'genre_musical' => $genreMusical,
                    'message' => "Genre musical modifié avec succès",
                    'serialized' => true
                ], Response::HTTP_OK);
            } else {
                return new JsonResponse([
                    'genre_musical' => null,
                    'message' => "Genre musical non modifié, merci de vérifier l'erreur décrite",
                    'serialized' => false
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour du genre musical", $e->getCode());
        }
    }

    /**
     * Supprime un utilisateur et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant du genre musical à supprimer.
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression du genre musical.
     */
    public static function deleteGenreMusical(
        int $id,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération du genre musical à supprimer
        $genreMusical = $genreMusicalRepository->find($id);

        // si pas de genre musical trouvé
        if ($genreMusical == null) {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => 'Genre musical non trouvé, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression du genre musical en BDD
        $rep = $genreMusicalRepository->removeGenreMusical($genreMusical);

        // si l'action à réussi
        if ($rep) {
            $GenreMusicalJSON = $serializer->serialize(
                $genreMusical,
                'json',
                ['groups' => ['genreMusical:read']]
            );
            return new JsonResponse([
                'genre_musical' => $GenreMusicalJSON,
                'message' => 'Genre musical supprimé',
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => 'Genre musical non supprimé !',
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute un utilisateur au genre musical et renvoie une réponse JSON.
     *
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après l'ajout de l'utilisateur au genre musical.
     */
    public static function ajouteUtilisateurGenreMusical(
        GenreMusicalRepository $genreMusicalRepository,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération du genre musical et de l'utilisateur
        $genreMusical = $genreMusicalRepository->find(intval($data['idGenreMusical']));
        $utilisateur = $utilisateurRepository->find(intval($data['idUtilisateur']));

        // si pas trouvé
        if ($genreMusical == null || $utilisateur == null) {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "genre musical ou utilisateur non trouvé, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout en BDD
        $genreMusical->addUtilisateur($utilisateur);
        $rep = $genreMusicalRepository->updateGenreMusical($genreMusical);

        // réponse après suppression
        if ($rep) {
            $genreMusicalJSON = $serializer->serialize(
                $genreMusical,
                'json',
                ['groups' => ['genreMusical:read']]
            );
            return new JsonResponse([
                'genre_musical' => $genreMusicalJSON,
                'message' => "Utilisateur ajouté au genre musical",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "Utilisateur non ajouté au genre musical !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire un utilisateur au genre musical et renvoie une réponse JSON.
     *
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'utilisateur au genre musical.
     */
    public static function retireUtilisateurGenreMusical(
        GenreMusicalRepository $genreMusicalRepository,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération du genre musical à supprimer
        $genreMusical = $genreMusicalRepository->find(intval($data['idGenreMusical']));
        $utilisateur = $utilisateurRepository->find(intval($data['idUtilisateur']));

        // si pas trouvé
        if ($genreMusical == null || $utilisateur == null) {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "genre musical ou utilisateur non trouvé, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression en BDD
        $genreMusical->removeUtilisateur($genreMusical);
        $rep = $genreMusicalRepository->updateGenreMusical($genreMusical);

        // réponse après suppression
        if ($rep) {
            $genreMusicalJSON = $serializer->serialize(
                $genreMusical,
                'json',
                ['groups' => ['genreMusical:read']]
            );
            return new JsonResponse([
                'genre_musical' => $genreMusicalJSON,
                'message' => "Utilisateur retiré",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "Utilisateur non retiré du genre musical !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute un artiste au genre musical et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant du genre musical.
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param ArtisteRepository $artisteRepository Le repository des artistes.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après l'ajout de l'artiste au genre musical.
     */
    public static function ajouteArtisteGenreMusical(
        GenreMusicalRepository $genreMusicalRepository,
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération du genre musical
        $genreMusical = $genreMusicalRepository->find(intval($data['idGenreMusical']));
        $artiste = $artisteRepository->find(intval($data['idArtiste']));

        // si pas trouvé
        if ($genreMusical == null || $artiste == null) {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "genre musical ou artiste non trouvé, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout en BDD
        $genreMusical->addArtiste($artiste);
        $rep = $genreMusicalRepository->updateGenreMusical($genreMusical);

        // réponse après ajout
        if ($rep) {
            $genreMusicalJSON = $serializer->serialize(
                $genreMusical,
                'json',
                ['groups' => ['genreMusical:read']]
            );
            return new JsonResponse([
                'genre_musical' => $genreMusicalJSON,
                'message' => "Artiste ajouté au genre musical",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "Artiste non ajouté au genre de musique !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire un artiste au genre musical et renvoie une réponse JSON.
     *
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param ArtisteRepository $artisteRepository Le repository des artistes.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'artiste au genre musical.
     */
    public static function retireArtisteGenreMusical(
        GenreMusicalRepository $genreMusicalRepository,
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération du genre musical et de l'artiste
        $genreMusical = $genreMusicalRepository->find(intval($data['idGenreMusical']));
        $artiste = $artisteRepository->find(intval($data['idArtiste']));

        // si pas trouvé
        if ($genreMusical == null || $artiste == null) {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "genre musical ou artiste non trouvé, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression en BDD
        $genreMusical->removeArtiste($artiste);
        $rep = $genreMusicalRepository->updateGenreMusical($genreMusical);

        // réponse après suppression
        if ($rep) {
            $genreMusicalJSON = $serializer->serialize(
                $genreMusical,
                'json',
                ['groups' => ['genreMusical:read']]
            );
            return new JsonResponse([
                'genre_musical' => $genreMusicalJSON,
                'message' => "Genre musical supprimé",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "Genre musical non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute un réseau au genre musical et renvoie une réponse JSON.
     *
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param ReseauRepository $reseauRepository Le repository des réseaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la lisaison d'un réseau au genre musical.
     */
    public static function ajouteReseauGenreMusical(
        GenreMusicalRepository $genreMusicalRepository,
        ReseauRepository $reseauRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération du genre musical et du réseau
        $genreMusical = $genreMusicalRepository->find(intval($data['idGenreMusical']));
        $reseau = $reseauRepository->find(intval($data['idReseau']));

        // si pas trouvé
        if ($genreMusical == null || $reseau == null) {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "genre musical ou réseau non trouvé, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout en BDD
        $genreMusical->addReseau($reseau);
        $rep = $genreMusicalRepository->updateGenreMusical($genreMusical);

        // réponse après ajout
        if ($rep) {
            $genreMusicalJSON = $serializer->serialize(
                $genreMusical,
                'json',
                ['groups' => ['genreMusical:read']]
            );
            return new JsonResponse([
                'genre_musical' => $genreMusicalJSON,
                'message' => "Réseau lié au genre musical",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "Réseau non lié au genre musical !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire un réseau au genre musical et renvoie une réponse JSON.
     *
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param ReseauRepository $reseauRepository Le repository des réseaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression du genre musical.
     */
    public static function retireReseauGenreMusical(
        GenreMusicalRepository $genreMusicalRepository,
        ReseauRepository $reseauRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération du genre musical et du réseau
        $genreMusical = $genreMusicalRepository->find(intval($data['idGenreMusical']));
        $reseau = $reseauRepository->find(intval($data['idReseau']));

        // si pas trouvé
        if ($genreMusical == null || $reseau == null) {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "genre musical ou réseau non trouvé, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression en BDD
        $genreMusical->removeReseau($reseau);
        $rep = $genreMusicalRepository->updateGenreMusical($genreMusical);

        // réponse après suppression
        if ($rep) {
            $genreMusicalJSON = $serializer->serialize(
                $genreMusical,
                'json',
                ['groups' => ['genreMusical:read']]
            );
            return new JsonResponse([
                'genre_musical' => $genreMusicalJSON,
                'message' => "Réseau retiré du genre de musique",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "Réseau non retiré du genre de musique !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute une offre au genre musical et renvoie une réponse JSON.
     *
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après l'ajout de l'offre au genre musical.
     */
    public static function ajouteOffreArtiste(
        GenreMusicalRepository $genreMusicalRepository,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération du genre musical et de l'offre
        $genreMusical = $genreMusicalRepository->find(intval($data['idArtiste']));
        $offre = $offreRepository->find(intval($data['idOffre']));

        // si pas trouvé
        if ($genreMusical == null || $offre == null) {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "genre musical ou offre non trouvé(e), merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout en BDD
        $genreMusical->addOffre($offre);
        $rep = $genreMusicalRepository->updateArtiste($genreMusical);

        // réponse après ajout
        if ($rep) {
            $genreMusicalJSON = $serializer->serialize(
                $genreMusical,
                'json',
                ['groups' => ['genreMusical:read']]
            );
            return new JsonResponse([
                'genre_musical' => $genreMusicalJSON,
                'message' => "Offre ajouté au genre musical",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "Offre non ajouté au genre musical !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire une offre au genre musical et renvoie une réponse JSON.
     *
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données contenant les identifiants de nos instances respectives
     *
     * @return JsonResponse La réponse JSON après la suppression de l'offre au genre musical.
     */
    public static function retireOffreArtiste(
        GenreMusicalRepository $genreMusicalRepository,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération du genre musical et de l'offre
        $genreMusical = $genreMusicalRepository->find(intval($data['idArtiste']));
        $offre = $offreRepository->find(intval($data['idOffre']));

        // si pas trouvé
        if ($genreMusical == null || $offre == null) {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "genre musical ou offre non trouvé, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression en BDD
        $genreMusical->removeOffre($offre);
        $rep = $genreMusicalRepository->updateArtiste($genreMusical);

        // réponse après suppression
        if ($rep) {
            $genreMusicalJSON = $serializer->serialize(
                $genreMusical,
                'json',
                ['groups' => ['genreMusical:read']]
            );
            return new JsonResponse([
                'genre_musical' => $genreMusicalJSON,
                'message' => "Offre retiré du genre de musique",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "Offre non retiré du genre musical !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
