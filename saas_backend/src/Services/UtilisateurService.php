<?php

namespace App\Services;

use App\Repository\GenreMusicalRepository;
use App\Repository\OffreRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Utilisateur;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
        try {
            // on récupère tous les utilisateurs
            $utilisateurs = $utilisateurRepository->findAll();
            $utilisateursJSON = $serializer->serialize($utilisateurs, 'json', ['groups' => ['utilisateur:read']]);
            return new JsonResponse([
                'utilisateurs' => $utilisateursJSON,
                'message' => "Liste des utilisateurs",
                'serialized' => true
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw new \RuntimeException("ERREUR " . $e->getMessage());
        }
    }

    /**
     * Récupère un utilisateur par son nom et renvoie une réponse JSON.
     *
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data les données (username) de l'utilisateur à rechercher
     *
     * @return JsonResponse La réponse JSON contenant l'utilisateur.
     */
    public static function getUtilisateur(
        UtilisateurRepository $utilisateurRepository,
        mixed $data,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les utilisateurs
        $utilisateurs = $utilisateurRepository->trouveUtilisateurByUsername($data['username']);
        $context = [
            'circular_reference_handler' => fn($object) => $object->getId(),
        ];
        $utilisateursJSON = $serializer->serialize(
            $utilisateurs,
            'json',
            ['groups' => ['utilisateur:read']], 
        );
        return new JsonResponse([
            'utilisateur' => $utilisateursJSON,
            'message' => "Utilisateur trouvé",
            'serialized' => true
        ], Response::HTTP_OK);
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
        UserPasswordHasherInterface $passwordHasher,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // vérifie qu'aucune donnée ne manque pour la création du compte
            if (empty($data['username'])) {
                throw new \InvalidArgumentException("Le nom d'utilisateur de l'utilisateur est requis.");
            } elseif (empty($data['mdpUtilisateur'])) {
                throw new \InvalidArgumentException("Le mot de passe utilisateur est requis.");
            }

            // création de l'objet et instanciation des données de l'objet
            $utilisateur = new Utilisateur();
            $utilisateur->setEmailUtilisateur(
                !(empty($data['emailUtilisateur'])) ? $data['emailUtilisateur'] : ""
            );

            // hashage du mot de passe
            $hashedPassword = $passwordHasher->hashPassword(
                $utilisateur,
                $data['mdpUtilisateur']
            );
            $utilisateur->setMdpUtilisateur($hashedPassword);
            $utilisateur->setRoles("ROLE_USER");
            $utilisateur->setUsername(!(empty($data['username'])) ? $data['username'] : "");
            $utilisateur->setNumTelUtilisateur($data['numTelUtilisateur'] ?? null);
            $utilisateur->setNomUtilisateur($data['nomUtilisateur'] ?? null);
            $utilisateur->setPrenomUtilisateur($data['prenomUtilisateur'] ?? null);

            // ajout de l'utilisateur en base de données
            $rep = $utilisateurRepository->inscritUtilisateur($utilisateur);

            // vérification de l'action en BDD
            if ($rep) {
                $utilisateurJSON = $serializer->serialize(
                    $utilisateur,
                    'json',
                    ['groups' => ['utilisateur:write']]
                );
                return new JsonResponse([
                    'utilisateur' => $utilisateurJSON,
                    'message' => "Utilisateur inscrit !",
                    'serialized' => true
                ], Response::HTTP_CREATED);
            }
            return new JsonResponse([
                'utilisateur' => null,
                'message' => "Utilisateur non inscrit, merci de regarder l'erreur décrite",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
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
                    'serialized' => true
                ], Response::HTTP_NOT_FOUND);
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
                $utilisateur->setRoles($data['roleUtilisateur']);
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
                $utilisateurJSON = $serializer->serialize(
                    $utilisateur,
                    'json',
                    ['groups' => ['utilisateur:read']]
                );

                return new JsonResponse([
                    'utilisateur' => $utilisateurJSON,
                    'message' => "Utilisateur modifié avec succès",
                    'serialized' => true
                ], Response::HTTP_OK);
            } else {
                return new JsonResponse([
                    'utilisateur' => null,
                    'message' => "Utilisateur non modifié, merci de vérifier l'erreur décrite",
                    'serialized' => false
                ], Response::HTTP_BAD_REQUEST);
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
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression de l'utilisateur en BDD
        $rep = $utilisateurRepository->removeUtilisateur($utilisateur);

        // si l'action à réussi
        if ($rep) {
            $utilisateurJSON = $serializer->serialize($utilisateur, 'json');
            return new JsonResponse([
                'utilisateur' => $utilisateurJSON,
                'message' => 'Utilisateur supprimé',
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'utilisateur' => null,
                'message' => 'Utilisateur non supprimé !',
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute un offre à un utilisateur et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour ajouter un genre musical préféré.
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives d'ajout d'un membre au offre.
     */
    public static function ajouteGenreMusicalUtilisateur(
        mixed $data,
        UtilisateurRepository $utilisateurRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération du genre musical et de l'utilisateur ciblé
        $genreMusical = $genreMusicalRepository->find($data['idGenreMusical']);
        $utilisateur = $utilisateurRepository->find($data['idUtilisateur']);

        // si pas de genre musical OU de l'utilisateur trouvé
        if ($genreMusical == null || $utilisateur == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'genre musical ou utilisateur non trouvé, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout de l'objet en BDD
        $utilisateur->addGenreMusical($genreMusical);
        $rep = $utilisateurRepository->updateUtilisateur($utilisateur);

        // si l'action à réussi
        if ($rep) {
            $utilisateurJSON = $serializer->serialize(
                $utilisateur,
                'json',
                ['groups' => ['utilisateur:read']]
            );
            return new JsonResponse([
                'object' => $utilisateurJSON,
                'message' => "genre musical ajouté aux préférences de l'utilisateur.",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'object' => null,
                'message' => "genre musical non ajouté aux préférences de l'utilisateur !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire un genre musical préféré à un utilisateur et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour retirer un genre musical préféré.
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives de suppression de préférence.
     */
    public static function retireGenreMusicalUtilisateur(
        mixed $data,
        UtilisateurRepository $utilisateurRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération du genre musical et de l'utilisateur ciblé
        $genreMusical = $genreMusicalRepository->find($data['idGenreMusical']);
        $utilisateur = $utilisateurRepository->find($data['idUtilisateur']);

        // si pas de genre musical OU de l'utilisateur trouvé
        if ($genreMusical == null || $utilisateur == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'genre musical ou utilisateur non trouvé, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout de l'objet en BDD
        $utilisateur->removeGenreMusical($genreMusical);
        $rep = $utilisateurRepository->updateUtilisateur($utilisateur);

        // si l'action à réussi
        if ($rep) {
            $utilisateurJSON = $serializer->serialize(
                $utilisateur,
                'json',
                ['groups' => ['utilisateur:read']]
            );
            return new JsonResponse([
                'object' => $utilisateurJSON,
                'message' => "genre musical retiré aux préférences de l'utilisateur.",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'object' => null,
                'message' => "genre musical non retiré aux préférences de l'utilisateur !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute une offre à un utilisateur et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour ajouter un genre musical préféré.
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives d'ajout d'une offre à un utilisateur.
     */
    public static function ajouteOffreUtilisateur(
        mixed $data,
        UtilisateurRepository $utilisateurRepository,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre et de l'utilisateur ciblé
        $offre = $offreRepository->find($data['diOffre']);
        $utilisateur = $utilisateurRepository->find($data['idUtilisateur']);

        // si pas d'offre OU d'utilisateur trouvé(e)
        if ($offre == null || $utilisateur == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'Offre ou utilisateur non trouvé, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout de l'objet en BDD
        $utilisateur->addOffre($offre);
        $rep = $utilisateurRepository->updateUtilisateur($utilisateur);

        // si l'action à réussi
        if ($rep) {
            $utilisateurJSON = $serializer->serialize(
                $utilisateur,
                'json',
                ['groups' => ['utilisateur:read']]
            );
            return new JsonResponse([
                'object' => $utilisateurJSON,
                'message' => "Offre ajoutée aux créations de l'utilisateur.",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'object' => null,
                'message' => "Offre non ajoutée aux créations de l'utilisateur !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire une offre à un utilisateur et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour retirer un offre à l'utilisateur.
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives de suppression de préférence.
     */
    public static function retireOffreUtilisateur(
        mixed $data,
        UtilisateurRepository $utilisateurRepository,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération du offre et de l'utilisateur ciblé
        $offre = $offreRepository->find($data['idOffre']);
        $utilisateur = $utilisateurRepository->find($data['idUtilisateur']);

        // si pas de offre OU de l'utilisateur trouvé
        if ($offre == null || $utilisateur == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'offre ou utilisateur non trouvé, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression de l'objet en BDD
        $utilisateur->removeOffre($offre);
        $rep = $utilisateurRepository->updateUtilisateur($utilisateur);

        // si l'action à réussi
        if ($rep) {
            $utilisateurJSON = $serializer->serialize(
                $utilisateur,
                'json',
                ['groups' => ['utilisateur:read']]
            );
            return new JsonResponse([
                'object' => $utilisateurJSON,
                'message' => "offre retiré aux préférences de l'utilisateur.",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'object' => null,
                'message' => "offre non retiré aux préférences de l'utilisateur !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
