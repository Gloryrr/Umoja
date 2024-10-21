<?php

namespace App\Services;

use App\Repository\ExtrasRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Extras;

/**
 * Class ExtrasService
 * Gestionnaire des extras (logique métier).
 */
class ExtrasService
{
    /**
     * Récupère tous les extras et renvoie une réponse JSON.
     *
     * @param ExtrasRepository $extrasRepository Le repository des extras.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les extras.
     */
    public static function getExtras(
        ExtrasRepository $extrasRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // Récupère tous les extras.
        $extras = $extrasRepository->findAll();
        $extrasJSON = $serializer->serialize($extras, 'json');

        return new JsonResponse([
            'extras' => $extrasJSON,
            'message' => "Liste des extras",
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
    }

    /**
     * Crée un nouveau extra et renvoie une réponse JSON.
     *
     * @param ExtrasRepository $extrasRepository Le repository des extras.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données de l'extra à créer.
     *
     * @return JsonResponse La réponse JSON après la création de l'extra.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création de l'extra.
     */
    public static function createExtra(
        ExtrasRepository $extrasRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // Vérification que les données obligatoires sont fournies.
            if (empty($data['descrExtras']) || empty($data['coutExtras'])) {
                throw new \InvalidArgumentException("La description ou le coût de l'extra est requis.");
            }

            // Création et initialisation de l'objet Extra.
            $extra = new Extras();
            $extra->setDescrExtras($data['descrExtras']);
            $extra->setCoutExtras($data['coutExtras']);
            $extra->setExclusivite($data['exclusivite'] ?? null);
            $extra->setException($data['exception'] ?? null);
            $extra->setOrdrePassage($data['ordrePassage'] ?? null);
            $extra->setClausesConfidentialites($data['clausesConfidentialites'] ?? null);

            // Enregistrement dans la base de données.
            $rep = $extrasRepository->inscritExtras($extra);

            if ($rep) {
                $extraJSON = $serializer->serialize($extra, 'json');
                return new JsonResponse([
                    'extra' => $extraJSON,
                    'message' => "Extra créé avec succès !",
                    'reponse' => Response::HTTP_CREATED,
                    'headers' => [],
                    'serialized' => true
                ]);
            }

            return new JsonResponse([
                'extra' => null,
                'message' => "Erreur lors de la création de l'extra.",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création de l'extra", $e->getCode());
        }
    }

    /**
     * Met à jour un extra existant et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'extra à mettre à jour.
     * @param ExtrasRepository $extrasRepository Le repository des extras.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données de l'extra.
     *
     * @return JsonResponse La réponse JSON après la mise à jour de l'extra.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour de l'extra.
     */
    public static function updateExtra(
        int $id,
        ExtrasRepository $extrasRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // Récupération de l'extra.
            $extra = $extrasRepository->find($id);

            if ($extra == null) {
                return new JsonResponse([
                    'extra' => null,
                    'message' => 'Extra non trouvé, merci de fournir un identifiant valide.',
                    'reponse' => Response::HTTP_NOT_FOUND,
                    'headers' => [],
                    'serialized' => false
                ]);
            }

            // Mise à jour des données.
            if (isset($data['descrExtras'])) {
                $extra->setDescrExtras($data['descrExtras']);
            }
            if (isset($data['coutExtras'])) {
                $extra->setCoutExtras($data['coutExtras']);
            }
            if (isset($data['exclusivite'])) {
                $extra->setExclusivite($data['exclusivite']);
            }
            if (isset($data['exception'])) {
                $extra->setException($data['exception']);
            }
            if (isset($data['ordrePassage'])) {
                $extra->setOrdrePassage($data['ordrePassage']);
            }
            if (isset($data['clausesConfidentialites'])) {
                $extra->setClausesConfidentialites($data['clausesConfidentialites']);
            }

            // Enregistrement des modifications dans la base de données.
            $rep = $extrasRepository->updateExtra($extra);

            if ($rep) {
                $extraJSON = $serializer->serialize($extra, 'json');
                return new JsonResponse([
                    'extra' => $extraJSON,
                    'message' => "Extra mis à jour avec succès !",
                    'reponse' => Response::HTTP_OK,
                    'headers' => [],
                    'serialized' => true
                ]);
            }

            return new JsonResponse([
                'extra' => null,
                'message' => "Erreur lors de la mise à jour de l'extra.",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour de l'extra", $e->getCode());
        }
    }

    /**
     * Supprime un extra et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'extra à supprimer.
     * @param ExtrasRepository $extrasRepository Le repository des extras.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'extra.
     */
    public static function deleteExtra(
        int $id,
        ExtrasRepository $extrasRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // Récupération de l'extra à supprimer.
        $extra = $extrasRepository->find($id);

        if ($extra == null) {
            return new JsonResponse([
                'extra' => null,
                'message' => 'Extra non trouvé, merci de fournir un identifiant valide.',
                'reponse' => Response::HTTP_NOT_FOUND,
                'headers' => [],
                'serialized' => false
            ]);
        }

        // Suppression de l'extra dans la base de données.
        $rep = $extrasRepository->removeExtra($extra);

        if ($rep) {
            $extraJSON = $serializer->serialize($extra, 'json');
            return new JsonResponse([
                'extra' => $extraJSON,
                'message' => 'Extra supprimé avec succès.',
                'reponse' => Response::HTTP_NO_CONTENT,
                'headers' => [],
                'serialized' => false
            ]);
        }

        return new JsonResponse([
            'extra' => null,
            'message' => 'Erreur lors de la suppression de l’extra.',
            'reponse' => Response::HTTP_BAD_REQUEST,
            'headers' => [],
            'serialized' => false
        ]);
    }
}
