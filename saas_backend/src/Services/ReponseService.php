<?php

namespace App\Services;

use App\Repository\EtatReponseRepository;
use App\Repository\OffreRepository;
use App\Repository\ReponseRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Reponse;

/**
 * Class ReponseService
 * Gestionnaire des réponses (logique métier pour les réponses).
 */
class ReponseService
{
    /**
     * Récupère toutes les réponses et renvoie une réponse JSON.
     *
     * @param ReponseRepository $reponseRepository Le repository des réponses.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les réponses.
     */
    public static function getReponses(
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // On récupère toutes les réponses
        $reponses = $reponseRepository->findAll();
        $reponsesJSON = $serializer->serialize(
            $reponses,
            'json',
            ['groups' => ['reponse:read']]
        );
        return new JsonResponse([
            'reponses' => $reponsesJSON,
            'message' => "Liste des réponses",
            'serialized' => true
        ], Response::HTTP_OK);
    }

    /**
     * Récupère une réponse par son id et renvoie une réponse JSON.
     *
     * @param int $id, L,'identifiant de la réponse
     * @param ReponseRepository $reponseRepository Le repository des réponses.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les réponses.
     */
    public static function getReponseById(
        int $id,
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // On récupère toutes les réponses
        $reponses = $reponseRepository->findBy(['id' => $id]);
        $reponsesJSON = $serializer->serialize(
            $reponses,
            'json',
            ['groups' => ['reponse:read']]
        );
        return new JsonResponse([
            'reponses' => $reponsesJSON,
            'message' => "Liste des réponses",
            'serialized' => true
        ], Response::HTTP_OK);
    }

    /**
     * Récupère une réponse par son id et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de la réponse.
     * @param ReponseRepository $reponseRepository Le repository des réponses.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les réponses.
     */
    public static function getReponse(
        int $id,
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // On récupère toutes les réponses
        $reponses = $reponseRepository->findBy(['id' => $id]);
        $reponsesJSON = $serializer->serialize(
            $reponses,
            'json',
            ['groups' => ['reponse:read']]
        );
        return new JsonResponse([
            'reponse' => $reponsesJSON,
            'message' => "Liste des réponses",
            'serialized' => true
        ], Response::HTTP_OK);
    }

    /**
     * Récupère toutes les réponses pour une offre donnée et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'offre.
     * @param ReponseRepository $reponseRepository Le repository des réponses.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les réponses pour l'offre donnée.
     */
    public static function getReponsesPourOffre(
        int $id,
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // On récupère les réponses pour l'offre donnée
        $reponses = $reponseRepository->findBy(['offre' => $id]);
        $reponsesJSON = $serializer->serialize(
            $reponses,
            'json',
            ['groups' => ['reponse:read']]
        );
        return new JsonResponse([
            'reponses' => $reponsesJSON,
            'message' => "Liste des réponses pour l'offre $id",
            'serialized' => true
        ], Response::HTTP_OK);
    }


    /**
     * Récupère toutes les réponses pour une offre donnée et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'offre.
     * @param ReponseRepository $reponseRepository Le repository des réponses.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les réponses pour l'offre donnée.
     */
    public static function getParticipationGloabalPourOffre(
        int $id,
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // On récupère les réponses pour l'offre donnée
        $reponses = $reponseRepository->findBy(['offre' => $id]);
        $totalPrixParticipation = 0;
        foreach ($reponses as $reponse) {
            if ($reponse->getEtatReponse()->getNomEtatReponse() === 'Validée') {
                $totalPrixParticipation += $reponse->getPrixParticipation();
            }
        }
        return new JsonResponse([
            'totalPrixParticipation' => $totalPrixParticipation,
            'message' => "prix de participation global des réponses pour l'offre $id",
            'serialized' => true
        ], Response::HTTP_OK);
    }

    /**
     * Crée une nouvelle réponse et renvoie une réponse JSON.
     *
     * @param ReponseRepository $reponseRepository Le repository des réponses.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données de la réponse à créer.
     *
     * @return JsonResponse La réponse JSON après la création de la réponse.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création de la réponse.
     */
    public static function createReponse(
        ReponseRepository $reponseRepository,
        UtilisateurRepository $utilisateurRepository,
        OffreRepository $offreRepository,
        EtatReponseRepository $etatReponseRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // Vérifie que les données nécessaires sont présentes
            if (
                (
                    empty($data['username']) ||
                    empty($data['idOffre']) ||
                    empty($data['prixParticipation']) ||
                    empty($data['nomSalleFestival']) ||
                    empty($data['nomSalleConcert']) ||
                    empty($data['ville']) ||
                    empty($data['datesPossible']) ||
                    empty($data['capacite']) ||
                    empty($data['deadline']) ||
                    empty($data['dureeShow']) ||
                    empty($data['montantCachet']) ||
                    empty($data['deviseCachet']) ||
                    empty($data['extras']) ||
                    empty($data['coutsExtras']) ||
                    empty($data['ordrePassage']) ||
                    empty($data['conditionsGenerales'])
                )
            ) {
                throw new \InvalidArgumentException("Toutes les données de la réponse sont requises.");
            }

            $dates = "";
            for ($i = 0; $i < count($data['datesPossible']); $i++) {
                $dates .= (new \DateTime(
                    $data['datesPossible'][$i]["dateDebut"]
                ))->format('Y-m-d') . " - ";
                $dates .= (new \DateTime(
                    $data['datesPossible'][$i]["dateFin"]
                ))->format('Y-m-d') . " - ";
            }

            // Création de l'objet Reponse
            $reponse = new Reponse();
            // $reponse->setDateDebut(new \DateTime($data['dateDebut']));
            // $reponse->setDateFin(new \DateTime($data['dateFin']));
            $reponse->setNomSalleFestival($data['nomSalleFestival']);
            $reponse->setNomSalleConcert($data['nomSalleConcert']);
            $reponse->setVille($data['ville']);
            $reponse->setCapacite($data['capacite']);
            $reponse->setDatesPossible($dates);
            $reponse->setDeadline(new \DateTime($data['deadline']));
            $reponse->setDureeShow($data['dureeShow']);
            $reponse->setMontantCachet($data['montantCachet']);
            $reponse->setDeviseCachet($data['deviseCachet']);
            $reponse->setExtras($data['extras']);
            $reponse->setCoutExtras($data['coutsExtras']);
            $reponse->setOrdrePassage($data['ordrePassage']);
            $reponse->setConditionsGenerales($data['conditionsGenerales']);
            $reponse->setPrixParticipation($data['prixParticipation']);

            $utilisateur = $utilisateurRepository->trouveUtilisateurByUsername($data['username']);
            if ($utilisateur === null || count($utilisateur) === 0) {
                return new JsonResponse([
                    'reponse_offre' => null,
                    'message' => "Utilisateur non trouvé, merci de vérifier les données fournies",
                    'serialized' => false
                ], Response::HTTP_BAD_REQUEST);
            }
            $reponse->setUtilisateur($utilisateur[0]);

            $offre = $offreRepository->find(intval($data['idOffre']));
            if ($offre === null) {
                return new JsonResponse([
                    'reponse_offre' => null,
                    'message' => "Offre non trouvée, merci de vérifier les données fournies",
                    'serialized' => false
                ], Response::HTTP_BAD_REQUEST);
            }
            $reponse->setOffre($offre);

            $etatReponse = $etatReponseRepository->find(1);
            if ($etatReponse === null) {
                return new JsonResponse([
                    'reponse_offre' => null,
                    'message' => "L'état de la réponse n'a pas été intialisée, merci de réitérer votre réponse",
                    'serialized' => false
                ], Response::HTTP_BAD_REQUEST);
            }
            $reponse->setEtatReponse($etatReponse);

            // Ajout de la réponse en base de données
            $rep = $reponseRepository->ajouterReponse($reponse);

            // Vérification de l'insertion en BDD
            if ($rep) {
                $reponseJSON = $serializer->serialize(
                    $reponse,
                    'json',
                    ['groups' => ['reponse:read']]
                );
                return new JsonResponse([
                    'reponse_offre' => $reponseJSON,
                    'message' => "Réponse créée avec succès",
                    'serialized' => true
                ], Response::HTTP_CREATED);
            }
            return new JsonResponse([
                'reponse_offre' => null,
                'message' => "Réponse non créée, merci de vérifier les données fournies",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création de la réponse", $e->getCode() . $e->getMessage());
        }
    }

    /**
     * Met à jour une réponse existante et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de la réponse à mettre à jour.
     * @param ReponseRepository $reponseRepository Le repository des réponses.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données de la réponse.
     *
     * @return JsonResponse La réponse JSON après la mise à jour.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour de la réponse.
     */
    public static function updateReponse(
        int $id,
        ReponseRepository $reponseRepository,
        EtatReponseRepository $etatReponseRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // Récupération de la réponse existante
            $reponse = $reponseRepository->find($id);

            // Vérification si la réponse existe
            if ($reponse == null) {
                return new JsonResponse([
                    'reponse_offre' => null,
                    'message' => 'Réponse non trouvée, merci de fournir un identifiant valide !',
                    'serialized' => false
                ], Response::HTTP_NOT_FOUND);
            }

            // Mise à jour des données de la réponse
            if (isset($data['etatReponse'])) {
                $etatReponse = null;
                switch ($data['etatReponse']['nomEtatReponse']) {
                    case 'Validée':
                        $etatReponse = $etatReponseRepository->find(2); // est l'ID de validation
                        break;
                    case 'Refusée':
                        $etatReponse = $etatReponseRepository->find(3); // est l'ID de refus
                        break;
                    default:
                        break;
                }
                if ($etatReponse === null) {
                    return new JsonResponse([
                        'reponse_offre' => null,
                        'message' => "L'état de la réponse n'a pas été intialisée, merci de réitérer votre réponse",
                        'serialized' => false
                    ], Response::HTTP_BAD_REQUEST);
                }
                $reponse->setEtatReponse($etatReponse);
            }
            if (isset($data['dateDebut'])) {
                $reponse->setDateDebut(new \DateTime($data['dateDebut']));
            }
            if (isset($data['dateFin'])) {
                $reponse->setDateFin(new \DateTime($data['dateFin']));
            }
            if (isset($data['prixParticipation'])) {
                $reponse->setPrixParticipation($data['prixParticipation']);
            }

            // Sauvegarde des modifications dans la BDD
            $rep = $reponseRepository->modifierReponse($reponse);

            // Si la mise à jour a réussi
            if ($rep) {
                $reponseJSON = $serializer->serialize(
                    $reponse,
                    'json',
                    ['groups' => ['reponse:read']]
                );
                return new JsonResponse([
                    'reponse_offre' => $reponseJSON,
                    'message' => "Réponse mise à jour avec succès",
                    'serialized' => true
                ], Response::HTTP_OK);
            } else {
                return new JsonResponse([
                    'reponse_offre' => null,
                    'message' => "Réponse non mise à jour, merci de vérifier les données fournies",
                    'serialized' => false
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour de la réponse", $e->getCode());
        }
    }

    /**
     * Supprime une réponse et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de la réponse à supprimer.
     * @param ReponseRepository $reponseRepository Le repository des réponses.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de la réponse.
     */
    public static function deleteReponse(
        int $id,
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // Récupération de la réponse à supprimer
        $reponse = $reponseRepository->find($id);

        // Si la réponse n'existe pas
        if ($reponse == null) {
            return new JsonResponse([
                'reponse_offre' => null,
                'message' => 'Réponse non trouvée, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // Suppression de la réponse dans la BDD
        $rep = $reponseRepository->supprimerReponse($reponse);

        // Si la suppression a réussi
        if ($rep) {
            $reponseJSON = $serializer->serialize(
                $reponse,
                'json',
                ['groups' => ['reponse:read']]
            );
            return new JsonResponse([
                'reponse_offre' => $reponseJSON,
                'message' => 'Réponse supprimée',
                'serialized' => true
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse([
                'reponse_offre' => null,
                'message' => 'Réponse non supprimée !',
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
