<?php

namespace App\Services;

use App\Repository\GenreMusicalRepository;
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
     * @param GenreMusicalRepository $GenreMusicalRepository Le repository des genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les genres musicaux.
     */
    public static function getGenresMusicaux(
        GenreMusicalRepository $GenreMusicalRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les genresMusicaux
        $genresMusicaux = $GenreMusicalRepository->findAll();
        $genresMusicauxJSON = $serializer->serialize($genresMusicaux, 'json', ['groups' => ['genre_musical_detail']]);
        return new JsonResponse([
            'genres_musicaux' => $genresMusicauxJSON,
            'message' => "Liste des genres musicaux",
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
    }

    /**
     * Crée un nouveau genre musical et renvoie une réponse JSON.
     *
     * @param GenreMusicalRepository $GenreMusicalRepository Le repository des genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données du genre musical à créer.
     *
     * @return JsonResponse La réponse JSON après la création du genre musical.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création du genre.
     */
    public static function createGenreMusical(
        GenreMusicalRepository $GenreMusicalRepository,
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
            $rep = $GenreMusicalRepository->inscritGenreMusical($genreMusical);

            // vérification de l'action en BDD
            if ($rep) {
                $genreMusicalJSON = $serializer->serialize($genreMusical, 'json', ['groups' => ['genre_musical_detail']]);
                return new JsonResponse([
                    'genre_musical' => $genreMusicalJSON,
                    'message' => "Genre musical inscrit !",
                    'reponse' => Response::HTTP_CREATED,
                    'headers' => [],
                    'serialized' => true
                ]);
            }
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "Genre musical non inscrit, merci de regarder l'erreur décrite",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création du genre musical", $e->getCode());
        }
    }

    /**
     * Met à jour un genre musical existant et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant du genre musical à mettre à jour.
     * @param GenreMusicalRepository $GenreMusicalRepository Le repository des genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données du genre musical.
     *
     * @return JsonResponse La réponse JSON après la mise à jour du genre musical.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour du genre musical.
     */
    public static function updateGenreMusical(
        int $id,
        GenreMusicalRepository $GenreMusicalRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // récupération du genre
            $genreMusical = $GenreMusicalRepository->find($id);

            // si il n'y pas de genre trouvé
            if ($genreMusical == null) {
                return new JsonResponse([
                    'genre_musical' => null,
                    'message' => 'Genre musical non trouvé, merci de donner un identifiant valide !',
                    'reponse' => Response::HTTP_NOT_FOUND,
                    'headers' => [],
                    'serialized' => true
                ]);
            }

            // on vérifie qu'aucune données ne manque pour la mise à jour
            // et on instancie les données dans l'objet
            if (isset($data['nomGenreMusical'])) {
                $genreMusical->setNomGenreMusical($data['nomGenreMusical']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $GenreMusicalRepository->updateGenreMusical($genreMusical);

            // si l'action à réussi
            if ($rep) {
                $genreMusical = $serializer->serialize($genreMusical, 'json', ['groups' => ['genre_musical_detail']]);

                return new JsonResponse([
                    'genre_musical' => $genreMusical,
                    'message' => "Genre musical modifié avec succès",
                    'reponse' => Response::HTTP_OK,
                    'headers' => [],
                    'serialized' => true
                ]);
            } else {
                return new JsonResponse([
                    'genre_musical' => null,
                    'message' => "Genre musical non modifié, merci de vérifier l'erreur décrite",
                    'reponse' => Response::HTTP_BAD_REQUEST,
                    'headers' => [],
                    'serialized' => false
                ]);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour du genre musical", $e->getCode());
        }
    }

    /**
     * Supprime un genre musical et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant du genre musical à supprimer.
     * @param GenreMusicalRepository $GenreMusicalRepository Le repository des genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression du genre musical.
     */
    public static function deleteGenreMusical(
        int $id,
        GenreMusicalRepository $GenreMusicalRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération du genre musical à supprimer
        $genreMusical = $GenreMusicalRepository->find($id);

        // si pas de genre musical trouvé
        if ($genreMusical == null) {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => 'Genre musical non trouvé, merci de fournir un identifiant valide',
                'reponse' => Response::HTTP_NOT_FOUND,
                'headers' => [],
                'serialized' => false
            ]);
        }

        // suppression du genre musical en BDD
        $rep = $GenreMusicalRepository->removeGenreMusical($genreMusical);

        // si l'action à réussi
        if ($rep) {
            $GenreMusicalJSON = $serializer->serialize($genreMusical, 'json', ['groups' => ['genre_musical_detail']]);
            return new JsonResponse([
                'genre_musical' => $GenreMusicalJSON,
                'message' => 'Genre musical supprimé',
                'reponse' => Response::HTTP_NO_CONTENT,
                'headers' => [],
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => 'Genre musical non supprimé !',
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        }
    }
}
