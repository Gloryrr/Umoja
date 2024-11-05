<?php

namespace App\Services;

use App\DTO\UtilisateurDTO;
use App\Entity\Preferencer;
use App\Repository\AppartenirRepository;
use App\Repository\GenreMusicalRepository;
use App\Repository\PreferencerRepository;
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
        AppartenirRepository $appartenirRepository,
        PreferencerRepository $preferencerRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les utilisateurs
        $utilisateurs = $utilisateurRepository->findAll();
        $arrayUtilisateursDTO = [];
        foreach ($utilisateurs as $indUser => $utilisateur) {
            $utilisateurDTO = new UtilisateurDTO(
                $utilisateur->getIdUtilisateur(),
                $utilisateur->getEmailUtilisateur(),
                $utilisateur->getRoles(),
                $utilisateur->getUsername(),
                $utilisateur->getNomUtilisateur(),
                $utilisateur->getPrenomUtilisateur()
            );

            $arrayReseaux = $appartenirRepository->trouveReseauxParIdUtilisateur(
                $utilisateur->getIdUtilisateur()
            );
            $arrayGenresMusicaux = $preferencerRepository->trouveGenresMusicauxParIdUtilisateur(
                $utilisateur->getIdUtilisateur()
            );

            foreach ($arrayReseaux as $indR => $reseau) {
                array_push($utilisateurDTO->membreDesReseaux, $reseau);
            }
            foreach ($arrayGenresMusicaux as $indGM => $genreMusical) {
                array_push($utilisateurDTO->genresMusicauxPreferes, $genreMusical);
            }

            array_push($arrayUtilisateursDTO, $utilisateurDTO);
        }

        $utilisateursJSON = $serializer->serialize($arrayUtilisateursDTO, 'json');
        return new JsonResponse([
            'utilisateurs' => $utilisateursJSON,
            'message' => "Liste des utilisateurs",
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
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
        AppartenirRepository $appartenirRepository,
        PreferencerRepository $preferencerRepository,
        mixed $data,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les utilisateurs
        $utilisateurs = $utilisateurRepository->trouveUtilisateurByUsername($data['username']);
        $arrayUtilisateursDTO = [];
        foreach ($utilisateurs as $indUser => $utilisateur) {
            $utilisateurDTO = new UtilisateurDTO(
                $utilisateur->getIdUtilisateur(),
                $utilisateur->getEmailUtilisateur(),
                $utilisateur->getRoles(),
                $utilisateur->getUsername(),
                $utilisateur->getNomUtilisateur(),
                $utilisateur->getPrenomUtilisateur()
            );

            $arrayReseaux = $appartenirRepository->trouveReseauxParIdUtilisateur(
                $utilisateur->getIdUtilisateur()
            );
            $arrayGenresMusicaux = $preferencerRepository->trouveGenresMusicauxParIdUtilisateur(
                $utilisateur->getIdUtilisateur()
            );

            foreach ($arrayReseaux as $indR => $reseau) {
                array_push($utilisateurDTO->membreDesReseaux, $reseau);
            }
            foreach ($arrayGenresMusicaux as $indGM => $genreMusical) {
                array_push($utilisateurDTO->genresMusicauxPreferes, $genreMusical);
            }

            array_push($arrayUtilisateursDTO, $utilisateurDTO);
        }

        $utilisateursJSON = $serializer->serialize($arrayUtilisateursDTO, 'json');
        return new JsonResponse([
            'utilisateur' => $utilisateursJSON,
            'message' => "Utilisateur trouvé",
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

            $utilisateurDTO = new UtilisateurDTO(
                $utilisateur->getIdUtilisateur(),
                $utilisateur->getEmailUtilisateur(),
                $utilisateur->getRoles(),
                $utilisateur->getUsername(),
                $utilisateur->getNomUtilisateur(),
                $utilisateur->getPrenomUtilisateur()
            );

            // vérification de l'action en BDD
            if ($rep) {
                $utilisateurJSON = $serializer->serialize($utilisateurDTO, 'json');
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

    /**
     * Ajoute un genre musical préférée à un utilisateur et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour ajouter un genre musical préféré.
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param PreferencerRepository $preferencerRepository Le repository des préférences de genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives d'ajout d'un membre au réseau.
     */
    public static function ajouteGenreMusicalUtilisateur(
        mixed $data,
        UtilisateurRepository $utilisateurRepository,
        PreferencerRepository $preferencerRepository,
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
                'reponse' => Response::HTTP_NOT_FOUND,
                'headers' => [],
                'serialized' => false
            ]);
        }

        // ajout de l'objet en BDD
        $preferencerObject = new Preferencer();
        $preferencerObject->setIdGenreMusical($genreMusical);
        $preferencerObject->setIdUtilisateur($utilisateur);
        $rep = $preferencerRepository->ajouteGenreMusicalUtilisateur($preferencerObject);

        // si l'action à réussi
        if ($rep) {
            $utilisateurJSON = $serializer->serialize($utilisateur, 'json');
            return new JsonResponse([
                'object' => $utilisateurJSON,
                'message' => "genre musical ajouté aux préférences de l'utilisateur.",
                'reponse' => Response::HTTP_NO_CONTENT,
                'headers' => [],
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'object' => null,
                'message' => "genre musical non ajouté aux préférences de l'utilisateur !",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        }
    }

    /**
     * Retire un genre musical préféré à un utilisateur et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour retirer un genre musical préféré.
     * @param UtilisateurRepository $utilisateurRepository Le repository des utilisateurs.
     * @param PreferencerRepository $preferencerRepository Le repository des préférences de genres musicaux.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives de suppression de préférence.
     */
    public static function retireGenreMusicalUtilisateur(
        mixed $data,
        UtilisateurRepository $utilisateurRepository,
        PreferencerRepository $preferencerRepository,
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
                'reponse' => Response::HTTP_NOT_FOUND,
                'headers' => [],
                'serialized' => false
            ]);
        }

        // ajout de l'objet en BDD
        $preferencerObject = new Preferencer();
        $preferencerObject->setIdGenreMusical($genreMusical);
        $preferencerObject->setIdUtilisateur($utilisateur);
        $rep = $preferencerRepository->retireGenreMusicalUtilisateur($preferencerObject);

        // si l'action à réussi
        if ($rep) {
            $utilisateurJSON = $serializer->serialize($utilisateur, 'json');
            return new JsonResponse([
                'object' => $utilisateurJSON,
                'message' => "genre musical retiré aux préférences de l'utilisateur.",
                'reponse' => Response::HTTP_NO_CONTENT,
                'headers' => [],
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'object' => null,
                'message' => "genre musical non retiré aux préférences de l'utilisateur !",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        }
    }
}
