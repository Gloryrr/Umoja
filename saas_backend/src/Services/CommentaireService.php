<?php

namespace App\Services;

use App\Repository\CommentaireRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Commentaire;

/**
 * Class CommentaireService
 * Est le gestionnaire des commentaires (gestion de la logique métier)
 */
class CommentaireService
{
    /**
     * Récupère tous les commentaires et renvoie une réponse JSON.
     *
     * @param CommentaireRepository $commentaireRepository Le repository des commentaires.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les commentaires.
     */
    public static function getCommentaires(
        CommentaireRepository $commentaireRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les Commentaires
        $commentaires = $commentaireRepository->findAll();
        $commentairesJSON = $serializer->serialize($commentaires, 'json');
        return new JsonResponse([
            'commentaires' => $commentairesJSON,
            'message' => "Liste des commentaires",
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
    }

    /**
     * Crée un nouveau commentaire et renvoie une réponse JSON.
     *
     * @param CommentaireRepository $commentaireRepository Le repository des commentaires.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données du commentaire à créer.
     *
     * @return JsonResponse La réponse JSON après la création du commentaire.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création du genre.
     */
    public static function createCommentaire(
        CommentaireRepository $commentaireRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // vérifie qu'aucune donnée ne manque pour la création du genre
            if (empty($data['commentaire'])) {
                throw new \InvalidArgumentException("Le contenu du commentaire est requis.");
            }

            // création de l'objet et instanciation des données de l'objet
            $commentaire = new Commentaire();
            $commentaire->setCommentaire($data['commentaire']);

            // ajout du commentaire en base de données
            $rep = $commentaireRepository->inscritCommentaire($commentaire);

            // vérification de l'action en BDD
            if ($rep) {
                $commentaireJSON = $serializer->serialize($commentaire, 'json');
                return new JsonResponse([
                    'commentaire' => $commentaireJSON,
                    'message' => "commentaire inscrit !",
                    'reponse' => Response::HTTP_CREATED,
                    'headers' => [],
                    'serialized' => true
                ]);
            }
            return new JsonResponse([
                'commentaire' => null,
                'message' => "commentaire non inscrit, merci de regarder l'erreur décrite",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création du commentaire", $e->getCode());
        }
    }

    /**
     * Met à jour un commentaire existant et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant du commentaire à mettre à jour.
     * @param CommentaireRepository $commentaireRepository Le repository des commentaires.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données du commentaire.
     *
     * @return JsonResponse La réponse JSON après la mise à jour du commentaire.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour du commentaire.
     */
    public static function updateCommentaire(
        int $id,
        CommentaireRepository $commentaireRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // récupération du genre
            $commentaire = $commentaireRepository->find($id);

            // si il n'y pas de genre trouvé
            if ($commentaire == null) {
                return new JsonResponse([
                    'commentaire' => null,
                    'message' => 'commentaire non trouvé, merci de donner un identifiant valide !',
                    'reponse' => Response::HTTP_NOT_FOUND,
                    'headers' => [],
                    'serialized' => true
                ]);
            }

            // on vérifie qu'aucune données ne manque pour la mise à jour
            // et on instancie les données dans l'objet
            if (isset($data['commentaire'])) {
                $commentaire->setCommentaire($data['commentaire']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $commentaireRepository->updateCommentaire($commentaire);

            // si l'action à réussi
            if ($rep) {
                $commentaire = $serializer->serialize($commentaire, 'json');

                return new JsonResponse([
                    'commentaire' => $commentaire,
                    'message' => "commentaire modifié avec succès",
                    'reponse' => Response::HTTP_OK,
                    'headers' => [],
                    'serialized' => true
                ]);
            } else {
                return new JsonResponse([
                    'commentaire' => null,
                    'message' => "commentaire non modifié, merci de vérifier l'erreur décrite",
                    'reponse' => Response::HTTP_BAD_REQUEST,
                    'headers' => [],
                    'serialized' => false
                ]);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour du commentaire", $e->getCode());
        }
    }

    /**
     * Supprime un commentaire et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant du commentaire à supprimer.
     * @param CommentaireRepository $commentaireRepository Le repository des commentaires.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression du commentaire.
     */
    public static function deleteCommentaire(
        int $id,
        CommentaireRepository $commentaireRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération du commentaire à supprimer
        $commentaire = $commentaireRepository->find($id);

        // si pas de commentaire trouvé
        if ($commentaire == null) {
            return new JsonResponse([
                'commentaire' => null,
                'message' => 'commentaire non trouvé, merci de fournir un identifiant valide',
                'reponse' => Response::HTTP_NOT_FOUND,
                'headers' => [],
                'serialized' => false
            ]);
        }

        // suppression du commentaire en BDD
        $rep = $commentaireRepository->removeCommentaire($commentaire);

        // si l'action à réussi
        if ($rep) {
            $commentaireJSON = $serializer->serialize($commentaire, 'json');
            return new JsonResponse([
                'commentaire' => $commentaireJSON,
                'message' => 'commentaire supprimé',
                'reponse' => Response::HTTP_NO_CONTENT,
                'headers' => [],
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'commentaire' => null,
                'message' => 'commentaire non supprimé !',
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        }
    }
}
