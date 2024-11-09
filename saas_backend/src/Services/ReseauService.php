<?php

namespace App\Services;

use App\Repository\GenreMusicalRepository;
use App\Repository\UtilisateurRepository;
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
     * @return JsonResponse La réponse JSON contenant les réseaux listés.
     */
    public static function getReseaux(
        ReseauRepository $reseauRepository, 
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les reseaux existants
        $reseaux = $reseauRepository->findAll();
        $reseauxJSON = $serializer->serialize(
            $reseaux, 
            'json', 
            ['groups' => ['reseau:read']]
        );
        return new JsonResponse([
            'reseaux' => $reseauxJSON,
            'message' => "Liste des réseaux",
            'serialized' => true
        ], Response::HTTP_OK);
    }

    /**
     * Créer un nouveau réseau et renvoie une réponse JSON.
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
                $reseauJSON = $serializer->serialize(
                    $reseau, 
                    'json', 
                    ['groups' => ['reseau:read']]
                );
                return new JsonResponse([
                    'reseau' => $reseauJSON,
                    'message' => "réseau ajouté !",
                    'serialized' => true
                ], Response::HTTP_CREATED);
            }
            return new JsonResponse([
                'reseau' => null,
                'message' => "réseau non ajouté, merci de regarder l'erreur décrite",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
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
                    'serialized' => true
                ], Response::HTTP_NOT_FOUND);
            }

            // on vérifie qu'aucune donnée ne manque pour la mise à jour
            // et on instancie les données dans l'objet
            if (isset($data['nomReseau'])) {
                $reseau->setNomReseau($data['nomReseau']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $reseauRepository->updateReseau($reseau);

            // si l'action à réussi
            if ($rep) {
                $reseau = $serializer->serialize(
                    $reseau, 
                    'json', 
                    ['groups' => ['reseau:read']]
                );

                return new JsonResponse([
                    'reseau' => $reseau,
                    'message' => "réseau modifié avec succès",
                    'serialized' => true
                ], Response::HTTP_OK);
            } else {
                return new JsonResponse([
                    'reseau' => null,
                    'message' => "réseau non modifié, merci de vérifier l'erreur décrite",
                    'serialized' => false
                ], Response::HTTP_BAD_REQUEST);
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
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression du réseau en BDD
        $rep = $reseauRepository->removeReseau($reseau);

        // si l'action à réussi
        if ($rep) {
            $reseauJSON = $serializer->serialize(
                $reseau, 
                'json', 
                ['groups' => ['reseau:read']]
            );
            return new JsonResponse([
                'reseau' => $reseauJSON,
                'message' => 'réseau supprimé',
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'reseau' => null,
                'message' => 'réseau non supprimé !',
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute un membre au réseau et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour ajouter un membre au réseau.
     * @param ReseauRepository $reseauRepository Le repository des réseaux.
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives d'ajout d'un membre au réseau.
     */
    public static function ajouteMembreReseau(
        mixed $data,
        ReseauRepository $reseauRepository,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération du réseau ciblé
        $reseau = $reseauRepository->find($data['idReseau']);
        $utilisateur = $utilisateurRepository->find($data['idUtilisateur']);

        // si pas de réseau trouvé
        if ($reseau == null || $utilisateur == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'réseau ou utilisateur non trouvé, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout de l'objet en BDD
        $reseau->addUtilisateur($utilisateur);
        $rep = $reseauRepository->updateReseau($reseau);

        // si l'action à réussi
        if ($rep) {
            $reseauJSON = $serializer->serialize(
                $reseau, 
                'json', 
                ['groups' => ['reseau:read']]
            );
            return new JsonResponse([
                'reseau' => $reseauJSON,
                'message' => 'membre ajouté au réseau.',
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'reseau' => null,
                'message' => 'membre non ajouté au réseau !',
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire un membre du réseau et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour retirer un membre du réseau.
     * @param ReseauRepository $reseauRepository Le repository des réseaux.
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives de retrait d'un membre du réseau.
     */
    public static function retireMembreReseau(
        mixed $data,
        ReseauRepository $reseauRepository,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération du réseau ciblé
        $reseau = $reseauRepository->find($data['idReseau']);
        $utilisateur = $utilisateurRepository->find($data['idUtilisateur']);

        // si pas de réseau trouvé
        if ($reseau == null || $utilisateur == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'réseau ou utilisateur non trouvé, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression du en BDD
        $reseau->removeUtilisateur($utilisateur);
        $rep = $reseauRepository->updateReseau($reseau);

        // si l'action à réussi
        if ($rep) {
            $reseauJSON = $serializer->serialize(
                $reseau, 
                'json', 
                ['groups' => ['reseau:read']]
            );
            return new JsonResponse([
                'reseau' => $reseauJSON,
                'message' => 'membre retiré du réseau.',
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'reseau' => null,
                'message' => 'membre non retiré du réseau !',
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute un genre musical au réseau et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour ajouter un genre au réseau.
     * @param ReseauRepository $reseauRepository Le repository des réseaux.
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives d'ajout d'un genre musical au réseau.
     */
    public static function ajouteGenreMusicalReseau(
        mixed $data,
        ReseauRepository $reseauRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération du réseau ciblé
        $reseau = $reseauRepository->find($data['idReseau']);
        $genreMusical = $genreMusicalRepository->find($data['idGenreMusical']);

        // si pas de réseau trouvé
        if ($reseau == null || $genreMusical == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'réseau ou genre musical non trouvé, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout de l'objet en BDD
        $reseau->addGenreMusical($genreMusical);
        $rep = $reseauRepository->updateReseau($reseau);

        // si l'action à réussi
        if ($rep) {
            $reseauJSON = $serializer->serialize(
                $reseau, 
                'json', 
                ['groups' => ['reseau:read']]
            );
            return new JsonResponse([
                'reseau' => $reseauJSON,
                'message' => 'genre musical ajouté au réseau',
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'reseau' => null,
                'message' => 'genre musical non ajouté au réseau !',
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire un genre musical du réseau et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour retirer un genre du réseau.
     * @param ReseauRepository $reseauRepository Le repository des réseaux.
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives de retrait d'un genre musical du réseau.
     */
    public static function retireGenreMusicalReseau(
        mixed $data,
        ReseauRepository $reseauRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération du réseau ciblé
        $reseau = $reseauRepository->find($data['idReseau']);
        $genreMusical = $genreMusicalRepository->find($data['idGenreMusical']);

        // si pas de réseau trouvé
        if ($reseau == null || $genreMusical == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'réseau ou genre musical non trouvé, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression de l'objet en BDD
        $reseau->removeGenreMusical($genreMusical);
        $rep = $reseauRepository->updateReseau($reseau);

        // si l'action à réussi
        if ($rep) {
            $reseauJSON = $serializer->serialize(
                $reseau, 
                'json', 
                ['groups' => ['reseau:read']]
            );
            return new JsonResponse([
                'reseau' => $reseauJSON,
                'message' => 'genre musical retiré du réseau',
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'reseau' => null,
                'message' => 'genre musical non retiré du réseau !',
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
