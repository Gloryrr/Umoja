<?php

namespace App\Services;

use App\Repository\ReseauRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Reseau;

/**
 * Class ReseauService
 * Est le gestionnaire des réseaux existants dans la BDD (gestion de la logique métier)
 */
class ReseauService
{
    /**
     * Récupère tous les réseaux et renvoie une réponse JSON.
     *
     * @param ReseauRepository $reseauRepository Le repository des réseaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les réseaux.
     */
    public static function getReseaux(
        ReseauRepository $reseauRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les reseaux existants
        $reseaux = $reseauRepository->findAll();
        $reseauxJSON = $serializer->serialize($reseaux, 'json');
        return new JsonResponse([
            'reseaux' => $reseauxJSON,
            'message' => "Liste des réseaux",
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
    }

    /**
     * Crée un nouveau réseau et renvoie une réponse JSON.
     *
     * @param ReseauRepository $reseauRepository Le repository des réseaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données du réseau à créer.
     *
     * @return JsonResponse La réponse JSON après la création du réseau.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création du réseau.
     */
    public static function createReseau(
        ReseauRepository $reseauRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // vérifie qu'aucune donnée ne manque pour la création du réseau
            if (empty($data['nomReseau'])) {
                throw new \InvalidArgumentException("Le nom du réseau est requis.");
            }

            // création de l'objet et instanciation des données de l'objet
            $reseau = new Reseau();
            $reseau->setNomReseau($data['nomReseau']);

            // ajout du reseau en base de données
            $rep = $reseauRepository->inscritReseau($reseau);

            // vérification de l'action en BDD
            if ($rep) {
                $reseauJSON = $serializer->serialize($reseau, 'json');
                return new JsonResponse([
                    'reseau' => $reseauJSON,
                    'message' => "réseau ajouté !",
                    'reponse' => Response::HTTP_CREATED,
                    'headers' => [],
                    'serialized' => true
                ]);
            }
            return new JsonResponse([
                'reseau' => null,
                'message' => "réseau non ajouté, merci de regarder l'erreur décrite",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création du réseau", $e->getCode());
        }
    }

    /**
     * Met à jour un réseau existant et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant du réseau à mettre à jour.
     * @param ReseauRepository $reseauRepository Le repository des réseaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données du réseau.
     *
     * @return JsonResponse La réponse JSON après la mise à jour du réseau.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour du réseau.
     */
    public static function updateReseau(
        int $id,
        ReseauRepository $reseauRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // récupération du réseau
            $reseau = $reseauRepository->find($id);

            // si il n'y pas de réseau trouvé
            if ($reseau == null) {
                return new JsonResponse([
                    'reseau' => null,
                    'message' => 'réseau non trouvé, merci de donner un identifiant valide !',
                    'reponse' => Response::HTTP_NOT_FOUND,
                    'headers' => [],
                    'serialized' => true
                ]);
            }

            // on vérifie qu'aucune données ne manque pour la mise à jour
            // et on instancie les données dans l'objet
            if (isset($data['nomReseau'])) {
                $reseau->setNomReseau($data['nomReseau']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $reseauRepository->updateReseau($reseau);

            // si l'action à réussi
            if ($rep) {
                $reseau = $serializer->serialize($reseau, 'json');

                return new JsonResponse([
                    'reseau' => $reseau,
                    'message' => "réseau modifié avec succès",
                    'reponse' => Response::HTTP_OK,
                    'headers' => [],
                    'serialized' => true
                ]);
            } else {
                return new JsonResponse([
                    'reseau' => null,
                    'message' => "réseau non modifié, merci de vérifier l'erreur décrite",
                    'reponse' => Response::HTTP_BAD_REQUEST,
                    'headers' => [],
                    'serialized' => false
                ]);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour du réseau", $e->getCode());
        }
    }

    /**
     * Supprime un réseau et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant du réseau à supprimer.
     * @param ReseauRepository $reseauRepository Le repository des réseaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression du réseau.
     */
    public static function deleteReseau(
        int $id,
        ReseauRepository $reseauRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération du réseau à supprimer
        $reseau = $reseauRepository->find($id);

        // si pas de réseau trouvé
        if ($reseau == null) {
            return new JsonResponse([
                'reseau' => null,
                'message' => 'réseau non trouvé, merci de fournir un identifiant valide',
                'reponse' => Response::HTTP_NOT_FOUND,
                'headers' => [],
                'serialized' => false
            ]);
        }

        // suppression du réseau en BDD
        $rep = $reseauRepository->removeReseau($reseau);

        // si l'action à réussi
        if ($rep) {
            $reseauJSON = $serializer->serialize($reseau, 'json');
            return new JsonResponse([
                'reseau' => $reseauJSON,
                'message' => 'réseau supprimé',
                'reponse' => Response::HTTP_NO_CONTENT,
                'headers' => [],
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'reseau' => null,
                'message' => 'réseau non supprimé !',
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        }
    }

    // /**
    //  * Ajoute un membre au réseau et renvoie une réponse JSON.
    //  *
    //  * @param int $id L'identifiant de l'utilisateur à supprimer.
    //  * @param ReseauRepository $reseauRepository Le repository des réseaux.
    //  * @param SerializerInterface $serializer Le service de sérialisation.
    //  *
    //  * @return JsonResponse La réponse JSON après la suppression du réseau.
    //  */
    // public static function ajouteMembreReseau(
    //     mixed $data,
    //     ReseauRepository $reseauRepository,
    //     UtilisateurRepository $utilisateurRepository,
    //     SerializerInterface $serializer,
    // ): JsonResponse {
    //     // récupération du réseau ciblé
    //     $reseau = $reseauRepository->find($data['idReseau']);
    //     $utilisateur = $utilisateurRepository->find($data['idUtilisateur']);

    //     // si pas de réseau trouvé
    //     if ($reseau == null || $utilisateur == null) {
    //         return new JsonResponse([
    //             'onject' => null,
    //             'message' => 'réseau ou utilisateur non trouvé, merci de fournir un identifiant valide',
    //             'reponse' => Response::HTTP_NOT_FOUND,
    //             'headers' => [],
    //             'serialized' => false
    //         ]);
    //     }

    //     // suppression du en BDD
    //     $rep = $reseauRepository->removeReseau($reseau);

    //     // si l'action à réussi
    //     if ($rep) {
    //         $reseauJSON = $serializer->serialize($reseau, 'json');
    //         return new JsonResponse([
    //             'reseau' => $reseauJSON,
    //             'message' => 'réseau supprimé',
    //             'reponse' => Response::HTTP_NO_CONTENT,
    //             'headers' => [],
    //             'serialized' => false
    //         ]);
    //     } else {
    //         return new JsonResponse([
    //             'reseau' => null,
    //             'message' => 'réseau non supprimé !',
    //             'reponse' => Response::HTTP_BAD_REQUEST,
    //             'headers' => [],
    //             'serialized' => false
    //         ]);
    //     }
    // }
}
