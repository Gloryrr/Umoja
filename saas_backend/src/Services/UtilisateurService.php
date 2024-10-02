<?php

namespace App\Services;

use App\Repository\UtilisateurRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Utilisateur;

/**
 * Class UtilisateurService
 * Est le gestionnaire des utilisateurs (gestion de la logique métier)
 */
class UtilisateurService
{
    /**
     * Récupère tous les utilisateurs et renvoie une réponse JSON.
     *
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les utilisateurs.
     */
    public static function getUtilisateurs(
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les utilisateurs
        $utilisateurs = $utilisateurRepository->findAll();
        $utilisateursJSON = $serializer->serialize($utilisateurs, 'json');
        return new JsonResponse([
            'utilisateurs' => $utilisateursJSON,
            'message' => "Liste des utilisateurs",
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
    }

    /**
     * Crée un nouvel utilisateur et renvoie une réponse JSON.
     *
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données de l'utilisateur à créer.
     *
     * @return JsonResponse La réponse JSON après la création de l'utilisateur.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création de l'utilisateur.
     */
    public static function createUtilisateur(
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // vérifie qu'aucune donnée ne manque pour la création du compte
            if ((empty($data['emailUtilisateur']) && empty($data['username']))) {
                throw new \InvalidArgumentException("L'email ou le username de l'utilisateur est requis.");
            } elseif (empty($data['mdpUtilisateur'])) {
                throw new \InvalidArgumentException("Le mot de passe utilisateur est requis.");
            }
            // création de l'objet et instanciation des données de l'objet
            $utilisateur = new Utilisateur();
            $utilisateur->setEmailUtilisateur(
                !(empty($data['emailUtilisateur'])) ? $data['emailUtilisateur'] : ""
            );
            $utilisateur->setMdpUtilisateur($data['mdpUtilisateur']);
            $utilisateur->setRoleUtilisateur("USER");
            $utilisateur->setUsername(!(empty($data['username'])) ? $data['username'] : "");
            $utilisateur->setNumTelUtilisateur($data['numTelUtilisateur'] ?? null);
            $utilisateur->setNomUtilisateur($data['nomUtilisateur'] ?? null);
            $utilisateur->setPrenomUtilisateur($data['prenomUtilisateur'] ?? null);

            // ajout de l'utilisateur en base de données
            $rep = $utilisateurRepository->inscritUtilisateur($utilisateur);

            // vérification de l'action en BDD
            if ($rep) {
                $utilisateurJSON = $serializer->serialize($utilisateur, 'json');
                return new JsonResponse([
                    'utilisateur' => $utilisateurJSON,
                    'message' => "Utilisateur inscrit !",
                    'reponse' => Response::HTTP_CREATED,
                    'headers' => [],
                    'serialized' => true
                ]);
            }
            return new JsonResponse([
                'utilisateur' => null,
                'message' => "Utilisateur non inscrit, merci de regarder l'erreur décrite",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création de l'utilisateur", $e->getMessage());
        }
    }

    /**
     * Met à jour un utilisateur existant et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'utilisateur à mettre à jour.
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données de l'utilisateur.
     *
     * @return JsonResponse La réponse JSON après la mise à jour de l'utilisateur.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour de l'utilisateur.
     */
    public static function updateUtilisateur(
        int $id,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // récupération de l'utilisateur
            $utilisateur = $utilisateurRepository->find($id);

            // si il n'y pas d'utilisateur trouvé
            if ($utilisateur == null) {
                return new JsonResponse([
                    'utilisateur' => null,
                    'message' => 'Utilisateur non trouvé, merci de donner un identifiant valide !',
                    'reponse' => Response::HTTP_NOT_FOUND,
                    'headers' => [],
                    'serialized' => true
                ]);
            }

            // on vérifie qu'aucune données ne manque pour la mise à jour
            // et on instancie les données dans l'objet
            if (isset($data['emailUtilisateur'])) {
                $utilisateur->setEmailUtilisateur($data['emailUtilisateur']);
            }
            if (isset($data['mdpUtilisateur'])) {
                $utilisateur->setMdpUtilisateur($data['mdpUtilisateur']);
            }
            if (isset($data['roleUtilisateur'])) {
                $utilisateur->setRoleUtilisateur($data['roleUtilisateur']);
            }
            if (isset($data['username'])) {
                $utilisateur->setUsername($data['username']);
            }
            if (isset($data['numTelUtilisateur'])) {
                $utilisateur->setNumTelUtilisateur($data['numTelUtilisateur']);
            }
            if (isset($data['nomUtilisateur'])) {
                $utilisateur->setNomUtilisateur($data['nomUtilisateur']);
            }
            if (isset($data['prenomUtilisateur'])) {
                $utilisateur->setPrenomUtilisateur($data['prenomUtilisateur']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $utilisateurRepository->updateUtilisateur($utilisateur);

            // si l'action à réussi
            if ($rep) {
                $utilisateurJSON = $serializer->serialize($utilisateur, 'json');

                return new JsonResponse([
                    'utilisateur' => $utilisateurJSON,
                    'message' => "Utilisateur modifié avec succès",
                    'reponse' => Response::HTTP_OK,
                    'headers' => [],
                    'serialized' => true
                ]);
            } else {
                return new JsonResponse([
                    'utilisateur' => null,
                    'message' => "Utilisateur non modifié, merci de vérifier l'erreur décrite",
                    'reponse' => Response::HTTP_BAD_REQUEST,
                    'headers' => [],
                    'serialized' => false
                ]);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour de l'utilisateur", $e->getMessage());
        }
    }

    /**
     * Supprime un utilisateur et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'utilisateur à supprimer.
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'utilisateur.
     */
    public static function deleteUtilisateur(
        int $id,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'utilisateur à supprimer
        $utilisateur = $utilisateurRepository->find($id);

        // si pas d'utilisateur trouvé
        if ($utilisateur == null) {
            return new JsonResponse([
                'utilisateur' => null,
                'message' => 'Utilisateur non trouvé, merci de fournir un identifiant valide',
                'reponse' => Response::HTTP_NOT_FOUND,
                'headers' => [],
                'serialized' => false
            ]);
        }

        // suppression de l'utilisateur en BDD
        $rep = $utilisateurRepository->removeUtilisateur($utilisateur);

        // si l'action à réussi
        if ($rep) {
            $utilisateurJSON = $serializer->serialize($utilisateur, 'json');
            return new JsonResponse([
                'utilisateur' => $utilisateurJSON,
                'message' => 'Utilisateur supprimé',
                'reponse' => Response::HTTP_NO_CONTENT,
                'headers' => [],
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'utilisateur' => null,
                'message' => 'Utilisateur non supprimé !',
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        }
    }
}
