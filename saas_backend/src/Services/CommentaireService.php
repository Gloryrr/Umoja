<?php

namespace App\Services;

use App\Repository\CommentaireRepository;
use App\Repository\OffreRepository;
use App\Repository\UtilisateurRepository;
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
        $commentairesJSON = $serializer->serialize(
            $commentaires,
            'json',
            ['groups' => ['commentaire:read']]
        );
        return new JsonResponse([
            'commentaires' => $commentairesJSON,
            'message' => "Liste des commentaires",
            'serialized' => true
        ], Response::HTTP_OK);
    }

    /**
     * Récupère un commentaire par son identifiant et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant du commentaire à récupérer.
     * @param CommentaireRepository $commentaireRepository Le repository des commentaires.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les commentaires.
     */
    public static function getCommentaireById(
        int $id,
        CommentaireRepository $commentaireRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les Commentaires
        $commentaires = $commentaireRepository->find($id);
        $commentairesJSON = $serializer->serialize(
            $commentaires,
            'json',
            ['groups' => ['commentaire:read']]
        );
        return new JsonResponse([
            'commentaires' => $commentairesJSON,
            'message' => "Liste des commentaires",
            'serialized' => true
        ], Response::HTTP_OK);
    }

    /**
     * Crée un nouveau commentaire et renvoie une réponse JSON.
     *
     * @param CommentaireRepository $commentaireRepository Le repository des commentaires.
     * @param OffreRepository $offreRepository Le repository des offres
     * @param UtilisateurRepository $utilisateurRepository Le repository des offres
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
        OffreRepository $offreRepository,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // vérifie qu'aucune donnée ne manque pour la création du genre
            if (empty($data['commentaire'])) {
                throw new \InvalidArgumentException("Le contenu du commentaire est requis.");
            }

            $offre = $offreRepository->find(intval($data['commentaire']['idOffre']));
            $utilisateur = $utilisateurRepository->findBy(['username' => $data['commentaire']['username']]);

            // création de l'objet et instanciation des données de l'objet
            $commentaire = new Commentaire();
            $commentaire->setCommentaire($data['commentaire']['contenu']);
            $commentaire->setOffre($offre);
            $commentaire->setUtilisateur($utilisateur[0]);

            // ajout du commentaire en base de données
            $rep = $commentaireRepository->inscritCommentaire($commentaire);

            // vérification de l'action en BDD
            if ($rep) {
                $commentaireJSON = $serializer->serialize(
                    $commentaire,
                    'json',
                    ['groups' => ['commentaire:read']]
                );
                return new JsonResponse([
                    'commentaire' => $commentaireJSON,
                    'message' => "commentaire inscrit !",
                    'serialized' => true
                ], Response::HTTP_CREATED);
            }
            return new JsonResponse([
                'commentaire' => null,
                'message' => "commentaire non inscrit, merci de regarder l'erreur décrite",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
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
                    'serialized' => true
                ], Response::HTTP_NOT_FOUND);
            }

            // on vérifie qu'aucune données ne manque pour la mise à jour
            // et on instancie les données dans l'objet
            if (isset($data['commentaire']['contenu'])) {
                $commentaire->setCommentaire($data['commentaire']['contenu']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $commentaireRepository->updateCommentaire($commentaire);

            // si l'action à réussi
            if ($rep) {
                $commentaire = $serializer->serialize(
                    $commentaire,
                    'json',
                    ['groups' => ['commentaire:read']]
                );

                return new JsonResponse([
                    'commentaire' => $commentaire,
                    'message' => "commentaire modifié avec succès",
                    'serialized' => true
                ], Response::HTTP_OK);
            } else {
                return new JsonResponse([
                    'commentaire' => null,
                    'message' => "commentaire non modifié, merci de vérifier l'erreur décrite",
                    'serialized' => false
                ], Response::HTTP_BAD_REQUEST);
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
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression du commentaire en BDD
        $rep = $commentaireRepository->removeCommentaire($commentaire);

        // si l'action à réussi
        if ($rep) {
            $commentaireJSON = $serializer->serialize(
                $commentaire,
                'json',
                ['groups' => ['commentaire:read']]
            );
            return new JsonResponse([
                'commentaire' => $commentaireJSON,
                'message' => 'commentaire supprimé',
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'commentaire' => null,
                'message' => 'commentaire non supprimé !',
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
