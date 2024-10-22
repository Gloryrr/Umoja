<?php

namespace App\Services;

use App\Repository\TypeOffreRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\TypeOffre;

/**
 * Class TypeOffreService
 * Est le gestionnaire des types d'offre (gestion de la logique métier)
 */
class TypeOffreService
{
    /**
     * Récupère tous les types d'offre et renvoie une réponse JSON.
     *
     * @param TypeOffreRepository $typeOffreRepository Le repository des types d'offre.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les types d'offre.
     */
    public static function getTypesOffre(
        TypeOffreRepository $typeOffreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les types d'offre
        $typesOffre = $typeOffreRepository->findAll();
        $typesOffreJSON = $serializer->serialize($typesOffre, 'json');
        return new JsonResponse([
            'types_offre' => $typesOffreJSON,
            'message' => "Liste des types d'offre",
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
    }

    /**
     * Crée un nouveau type d'offre et renvoie une réponse JSON.
     *
     * @param TypeOffreRepository $typeOffreRepository Le repository des types d'offre.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données du type d'offre à créer.
     *
     * @return JsonResponse La réponse JSON après la création du type d'offre.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création du type.
     */
    public static function createTypeOffre(
        TypeOffreRepository $typeOffreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // vérifie qu'aucune donnée ne manque pour la création du type
            if (empty($data['nomTypeOffre'])) {
                throw new \InvalidArgumentException("Le nom du type d'offre est requis.");
            }

            // création de l'objet et instanciation des données de l'objet
            $typeOffre = new TypeOffre();
            $typeOffre->setNomTypeOffre($data['nomTypeOffre']);

            // ajout du nouveau type en base de données
            $rep = $typeOffreRepository->inscritOffre($typeOffre);

            // vérification de l'action en BDD
            if ($rep) {
                $typeOffreJSON = $serializer->serialize($typeOffre, 'json');
                return new JsonResponse([
                    'type_offre' => $typeOffreJSON,
                    'message' => "Type d'offre ajouté !",
                    'reponse' => Response::HTTP_CREATED,
                    'headers' => [],
                    'serialized' => true
                ]);
            }
            return new JsonResponse([
                'type_offre' => null,
                'message' => "Type d'offre non inscrit, merci de vérifier l'erreur décrite",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création du type d'offre", $e->getCode());
        }
    }

    /**
     * Met à jour un type d'offre existant et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant du type d'offre à mettre à jour.
     * @param TypeOffreRepository $typeOffreRepository Le repository des types d'offre.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données du type d'offre.
     *
     * @return JsonResponse La réponse JSON après la mise à jour du type d'offre.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour du type d'offre.
     */
    public static function updateTypeOffre(
        int $id,
        TypeOffreRepository $typeOffreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // récupération du type
            $typeOffre = $typeOffreRepository->find($id);

            // si pas trouvé
            if ($typeOffre == null) {
                return new JsonResponse([
                    'type_offre' => null,
                    'message' => "Type d'offre non trouvé, merci de donner un identifiant valide !",
                    'reponse' => Response::HTTP_NOT_FOUND,
                    'headers' => [],
                    'serialized' => true
                ]);
            }

            // mise à jour des données
            if (isset($data['nomTypeOffre'])) {
                $typeOffre->setNomTypeOffre($data['nomTypeOffre']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $typeOffreRepository->updateOffre($typeOffre);

            // réponse après la mise à jour
            if ($rep) {
                $typeOffre = $serializer->serialize($typeOffre, 'json');
                return new JsonResponse([
                    'type_offre' => $typeOffre,
                    'message' => "Type d'offre modifié avec succès",
                    'reponse' => Response::HTTP_OK,
                    'headers' => [],
                    'serialized' => true
                ]);
            } else {
                return new JsonResponse([
                    'type_offre' => null,
                    'message' => "Type d'offre non modifié, merci de vérifier l'erreur décrite",
                    'reponse' => Response::HTTP_BAD_REQUEST,
                    'headers' => [],
                    'serialized' => false
                ]);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour du type d'offre", $e->getCode());
        }
    }

    /**
     * Supprime un type d'offre et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant du type d'offre à supprimer.
     * @param TypeOffreRepository $typeOffreRepository Le repository des types d'offre.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression du type d'offre.
     */
    public static function deleteTypeOffre(
        int $id,
        TypeOffreRepository $typeOffreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // récupération du type d'offre à supprimer
        $typeOffre = $typeOffreRepository->find($id);

        // si pas trouvé
        if ($typeOffre == null) {
            return new JsonResponse([
                'type_offre' => null,
                'message' => "Type d'offre non trouvé, merci de fournir un identifiant valide",
                'reponse' => Response::HTTP_NOT_FOUND,
                'headers' => [],
                'serialized' => false
            ]);
        }

        // suppression en BDD
        $rep = $typeOffreRepository->removeOffre($typeOffre);

        // réponse après suppression
        if ($rep) {
            $typeOffreJSON = $serializer->serialize($typeOffre, 'json');
            return new JsonResponse([
                'type_offre' => $typeOffreJSON,
                'message' => "Type d'offre supprimé",
                'reponse' => Response::HTTP_NO_CONTENT,
                'headers' => [],
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'type_offre' => null,
                'message' => "Type d'offre non supprimé !",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        }
    }
}
