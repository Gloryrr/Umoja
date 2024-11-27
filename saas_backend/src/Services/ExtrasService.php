<?php

namespace App\Services;

use App\Repository\ExtrasRepository;
use App\Repository\OffreRepository;
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
        $extrasJSON = $serializer->serialize(
            $extras,
            'json',
            ['groups' => ['extras:read']]
        );

        return new JsonResponse([
            'extras' => $extrasJSON,
            'message' => "Liste des extras",
            'serialized' => true
        ], Response::HTTP_OK);
    }

    /**
     * Récupère un extras oar rapport à son id et renvoie une réponse JSON.
     *
     * @param int $id, L'id de l'extras en particulier
     * @param ExtrasRepository $extrasRepository Le repository des extras.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les extras.
     */
    public static function getExtrasById(
        ExtrasRepository $extrasRepository,
        SerializerInterface $serializer,
        int $id
    ): JsonResponse {
        // Récupère tous les extras.
        $extras = $extrasRepository->findBy(['id' => $id]);
        $extrasJSON = $serializer->serialize(
            $extras,
            'json',
            ['groups' => ['extras:read']]
        );

        return new JsonResponse([
            'extras' => $extrasJSON,
            'message' => "Liste des extras",
            'serialized' => true
        ], Response::HTTP_OK);
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
            if (empty($data['extras']['descrExtras']) || empty($data['extras']['coutExtras'])) {
                throw new \InvalidArgumentException("La description ou le coût de l'extra est requis.");
            }

            // Création et initialisation de l'objet Extra.
            $extra = new Extras();
            $extra->setDescrExtras($data['extras']['descrExtras']);
            $extra->setCoutExtras($data['extras']['coutExtras']);
            $extra->setExclusivite($data['extras']['exclusivite'] ?? null);
            $extra->setException($data['extras']['exception'] ?? null);
            $extra->setOrdrePassage($data['extras']['ordrePassage'] ?? null);
            $extra->setClausesConfidentialites($data['extras']['clausesConfidentialites'] ?? null);

            // Enregistrement dans la base de données.
            $rep = $extrasRepository->ajouterExtras($extra);

            if ($rep) {
                $extraJSON = $serializer->serialize(
                    $extra,
                    'json',
                    ['groups' => ['extras:read']]
                );
                return new JsonResponse([
                    'extra' => $extraJSON,
                    'message' => "Extra créé avec succès !",
                    'serialized' => true
                ], Response::HTTP_CREATED);
            }

            return new JsonResponse([
                'extra' => null,
                'message' => "Erreur lors de la création de l'extra.",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
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
                    'serialized' => false
                ], Response::HTTP_NOT_FOUND);
            }

            // Mise à jour des données.
            if (isset($data['extras']['descrExtras'])) {
                $extra->setDescrExtras($data['extras']['descrExtras']);
            }
            if (isset($data['extras']['coutExtras'])) {
                $extra->setCoutExtras($data['extras']['coutExtras']);
            }
            if (isset($data['extras']['exclusivite'])) {
                $extra->setExclusivite($data['extras']['exclusivite']);
            }
            if (isset($data['extras']['exception'])) {
                $extra->setException($data['extras']['exception']);
            }
            if (isset($data['extras']['ordrePassage'])) {
                $extra->setOrdrePassage($data['extras']['ordrePassage']);
            }
            if (isset($data['extras']['clausesConfidentialites'])) {
                $extra->setClausesConfidentialites($data['extras']['clausesConfidentialites']);
            }

            // Enregistrement des modifications dans la base de données.
            $rep = $extrasRepository->modifierExtras($extra);

            if ($rep) {
                $extraJSON = $serializer->serialize(
                    $extra,
                    'json',
                    ['groups' => ['extras:read']]
                );
                return new JsonResponse([
                    'extra' => $extraJSON,
                    'message' => "Extra mis à jour avec succès !",
                    'serialized' => true
                ], Response::HTTP_OK);
            }

            return new JsonResponse([
                'extra' => null,
                'message' => "Erreur lors de la mise à jour de l'extra.",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
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
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // Suppression de l'extra dans la base de données.
        $rep = $extrasRepository->supprimerExtras($extra);

        if ($rep) {
            $extraJSON = $serializer->serialize(
                $extra,
                'json',
                ['groups' => ['extras:read']]
            );
            return new JsonResponse([
                'extra' => $extraJSON,
                'message' => 'Extra supprimé avec succès.',
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse([
            'extra' => null,
            'message' => 'Erreur lors de la suppression de l’extra.',
            'serialized' => false
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Ajoute une offre à l'extras et renvoie une réponse JSON.
     *
     * @param ExtrasRepository $extrasRepository Le repository de l'extras.
     * @param OffreRepository $offreRepository Le repository des offres .
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'extras.
     */
    public static function ajouteOffreExtras(
        ExtrasRepository $extrasRepository,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération de l'extras
        $extras = $extrasRepository->find(intval($data['idExtras']));
        $offre = $offreRepository->find(intval($data['idOffre']));

        // si pas trouvée
        if ($extras == null || $offre == null) {
            return new JsonResponse([
                'extras' => null,
                'message' => "extras ou offre non trouvée, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout en BDD
        $extras->addOffre($offre);
        $rep = $extrasRepository->modifierExtras($extras);

        // réponse après suppression
        if ($rep) {
            $extrasJSON = $serializer->serialize(
                $extras,
                'json',
                ['groups' => ['extras:read']]
            );
            return new JsonResponse([
                'extras' => $extrasJSON,
                'message' => "Type d'offre supprimé",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'extras' => null,
                'message' => "Type d'offre non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire une offre à l'extras et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'extras.
     * @param ExtrasRepository $extrasRepository Le repository de l'extras.
     * @param OffreRepository $offreRepository Le repository desoffres .
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'extras.
     */
    public static function retireOffreExtras(
        ExtrasRepository $extrasRepository,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération de l'extras à supprimer
        $extras = $extrasRepository->find(intval($data['idExtras']));
        $offre = $offreRepository->find(intval($data['idOffre']));

        // si pas trouvé
        if ($extras == null || $offre == null) {
            return new JsonResponse([
                'extras' => null,
                'message' => "extras ou offre non trouvée, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression en BDD
        $extras->removeOffre($offre);
        $rep = $extrasRepository->modifierExtras($extras);

        // réponse après suppression
        if ($rep) {
            $extrasJSON = $serializer->serialize(
                $extras,
                'json',
                ['groups' => ['extras:read']]
            );
            return new JsonResponse([
                'extras' => $extrasJSON,
                'message' => "Type d'offre supprimé",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'extras' => null,
                'message' => "Type d'offre non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
