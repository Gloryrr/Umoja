<?php

namespace App\Controller;

use App\Repository\ArtisteRepository;
use App\Repository\EtatOffreRepository;
use App\Repository\GenreMusicalRepository;
use App\Repository\ReseauRepository;
use App\Repository\TypeOffreRepository;
use App\Repository\UtilisateurRepository;
use App\Services\MailerService;
use App\Services\OffreService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\OffreRepository;
use Knp\Component\Pager\PaginatorInterface;

class OffreController extends AbstractController
{
    /**
     * Récupère tous les Offres.
     *
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offres', name: 'get_Offres', methods: ['GET'])]
    public function getOffres(
        OffreRepository $offreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return OffreService::getOffres(
            $offreRepository,
            $serializer
        );
    }

    /**
     * Récupère une offre en particulière en fonction de son id.
     *
     * @param int $id, l'id de l'offre à récupérer
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/{id}', name: 'get_offre', methods: ['GET'])]
    public function getOffre(
        int $id,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        return OffreService::getOffre(
            $offreRepository,
            $serializer,
            $id
        );
    }

    /**
     * Récupère une liste d'offres en fonction d'une liste d'identifiant.
     *
     * @param Request $request, la requête avec les données de recherche
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offres', name: 'get_offres_by_liste_id', methods: ['POST'])]
    public function getOffresByListId(
        Request $request,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::getOffresByListId(
            $offreRepository,
            $serializer,
            $data
        );
    }

    /**
     * Récupère une liste d'offres en fonction d'une liste d'identifiant.
     *
     * @param Request $request, la requête avec les données de recherche
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offres/reseau', name: 'get_offres_reseau', methods: ['POST'])]
    public function getOffresReseau(
        Request $request,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        PaginatorInterface $paginator,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $page = intval($data['page']);
        $limit = intval($data['limit']);
        $nomReseau = $data['nomReseau'];
        return OffreService::getOffresByReseau(
            $nomReseau,
            $offreRepository,
            $serializer,
            $paginator,
            $page,
            $limit
        );
    }

    /**
     * Récupère les offres fonction de leur titre et de leur appartenance à un réseau.
     *
     * @param Request $request, la requête avec les données de recherche
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des Utilisateurs
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offres/title', name: 'get_offres_by_title', methods: ['POST'])]
    public function getOffresByTitle(
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::getOffresByTitle(
            $utilisateurRepository,
            $offreRepository,
            $serializer,
            $data
        );
    }

    /**
     * Récupère toutes les offres qui sont liés à un utilisateur en particulier.
     *
     * @param Request $request, la requête avec les données de recherche
     * @param string $username, le nom d'utilisateur de l'utilisateur
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/utilisateur/{username}', name: 'get_offre_by_utilisateur', methods: ['POST'])]
    public function getOffreByUtilisateur(
        Request $request,
        string $username,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        PaginatorInterface $paginator,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $page = intval($data['page']);
        $limit = intval($data['limit']);
        return OffreService::getOffreByUtilisateur(
            $offreRepository,
            $serializer,
            $paginator,
            $username,
            $page,
            $limit
        );
    }

    /**
     * Crée une nouvelle Offre.
     *
     * @param Request $request
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/create', name: 'create_offre', methods: ['POST'])]
    public function createOffre(
        Request $request,
        OffreRepository $offreRepository,
        UtilisateurRepository $utilisateurRepository,
        ReseauRepository $reseauRepository,
        GenreMusicalRepository $genreMusicalRepository,
        ArtisteRepository $artisteRepository,
        EtatOffreRepository $etatOffreRepository,
        TypeOffreRepository $typeOffreRepository,
        SerializerInterface $serializer,
        MailerService $mailerService
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::createOffre(
            $offreRepository,
            $utilisateurRepository,
            $reseauRepository,
            $genreMusicalRepository,
            $artisteRepository,
            $etatOffreRepository,
            $typeOffreRepository,
            $serializer,
            $mailerService,
            $data
        );
    }


    /**
     * Met à jour une Offre existante.
     *
     * @param int $id
     * @param Request $request
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @param ReseauRepository $reseauRepository, la classe CRUD des réseaux
     * @param GenreMusicalRepository $genreMusicalRepository, la classe CRUD des genres musicaux
     * @param ArtisteRepository $artisteRepository, la classe CRUD des artistes
     * @param MailerService $mailerService, le service d'envoi de mail
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/update/{id}', name: 'update_offre', methods: ['PATCH'])]
    public function updateOffre(
        int $id,
        Request $request,
        OffreRepository $offreRepository,
        ReseauRepository $reseauRepository,
        GenreMusicalRepository $genreMusicalRepository,
        ArtisteRepository $artisteRepository,
        MailerService $mailerService,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::updateOffre(
            $id,
            $offreRepository,
            $reseauRepository,
            $genreMusicalRepository,
            $artisteRepository,
            $serializer,
            $mailerService,
            $data
        );
    }

    /**
     * Supprime une Offre.
     *
     * @param int $id
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/delete/{id}', name: 'delete_offre', methods: ['DELETE'])]
    public function deleteOffre(
        int $id,
        OffreRepository $offreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return OffreService::deleteOffre(
            $id,
            $offreRepository,
            $serializer
        );
    }

    /**
     * Ajoute un artiste à l'offre
     *
     * @param Request $requete, la requête avec les données d'ajout
     * @param OffreRepository $offreRepository, la classe CRUD des offres
     * @param ArtisteRepository $artisteRepository, la classe CRUD des artistes
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/add-artiste', name: 'add_artiste_offre', methods: ['POST'])]
    public function ajouteArtisteOffre(
        Request $request,
        OffreRepository $offreRepository,
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::ajouteArtisteOffre(
            $data,
            $offreRepository,
            $artisteRepository,
            $serializer
        );
    }

    /**
     * Supprime un artiste de l'offre
     *
     * @param Request $request, la requête avec les données de suppression
     * @param OffreRepository $offreRepository, la classe CRUD des offres
     * @param ArtisteRepository $artisteRepository, la classe CRUD des artistes
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/delete-artiste', name: 'delete_artiste_offre', methods: ['DELETE'])]
    public function supprimeMembreReseau(
        Request $request,
        OffreRepository $offreRepository,
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::retireArtisteOffre(
            $data,
            $offreRepository,
            $artisteRepository,
            $serializer
        );
    }

    /**
     * Ajoute un genre musical préféré à une offre
     *
     * @param Request $requete, la requête avec les données d'jaout
     * @param OffreRepository $offreRepository, la classe CRUD des offrex
     * @param GenreMusicalRepository $genreMusicalRepository, la classe CRUD des genres musicaux
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/add-genre-musical', name: 'add_genre_musical_offre', methods: ['POST'])]
    public function ajouteGenreMusicalReseau(
        Request $request,
        OffreRepository $offreRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::ajouteGenreMusicalReseau(
            $data,
            $offreRepository,
            $genreMusicalRepository,
            $serializer
        );
    }

    /**
     * Retire un genre musical préféré du réseau
     *
     * @param Request $requete, la requête avec les données d'jaout
     * @param OffreRepository $offreRepository, la classe CRUD des réseaux
     * @param GenreMusicalRepository $genreMusicalRepository, la classe CRUD des genres musicaux
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/delete-genre-musical', name: 'delete_genre_musical_offre', methods: ['DELETE'])]
    public function retireGenreMusicalReseau(
        Request $request,
        OffreRepository $offreRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::retireGenreMusicalReseau(
            $data,
            $offreRepository,
            $genreMusicalRepository,
            $serializer
        );
    }
}
