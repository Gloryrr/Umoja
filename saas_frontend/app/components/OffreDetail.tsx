"use client";

import { useEffect, useState } from "react";
import { Button, Badge, Card, Tooltip } from "flowbite-react";
import { HiArrowLeft, HiLocationMarker, HiCalendar, HiUsers, HiLink } from "react-icons/hi";
import { apiGet } from "@/app/services/internalApiClients";

interface Offre {
  id: string;
  titleOffre: string;
  deadLine: string;
  descrTournee: string;
  dateMinProposee: string;
  dateMaxProposee: string;
  villeVisee: string;
  regionVisee: string;
  placesMin: number;
  placesMax: number;
  nbArtistesConcernes: number;
  nbInvitesConcernes: number;
  liensPromotionnels: string;
  extras: { id: number };
  etatOffre: { id: number };
  typeOffre: { id: number };
  conditionsFinancieres: { id: number };
  budgetEstimatif: { id: number };
  ficheTechniqueArtiste: { id: number };
  utilisateur: { id: number };
}

async function fetchOffreDetails(id: number): Promise<Offre> {
  const response = await apiGet(`/offre/${id}`);
  if (!response) {
    throw new Error("Erreur lors de la récupération des détails de l'offre");
  }
  return JSON.parse(response.offre);
}

interface OffreDetailProps {
  offreId: number;
}

export default function OffreDetail({ offreId }: OffreDetailProps) {
  const [offre, setOffre] = useState<Offre | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    fetchOffreDetails(offreId)
      .then((data) => {
        setOffre(data);
        setLoading(false);
      })
      .catch((err) => {
        setError(err.message);
        setLoading(false);
      });
  }, [offreId]);

  if (loading) {
    return <p>Chargement des détails de l'offre...</p>;
  }

  if (error) {
    return <p>Erreur : {error}</p>;
  }

  if (!offre) {
    return <p>Aucune offre trouvée.</p>;
  }

  return (
    <div className="p-6">
      {/* Header avec bouton de retour */}
      <div className="flex items-center mb-6">
        <Button color="light" href={"/umodja/home"} className="mr-4">
          <HiArrowLeft className="mr-2" /> Retour
        </Button>
        <h1 className="text-3xl font-bold">{offre.titleOffre}</h1>
      </div>

      {/* Carte d'information */}
      <Card className="w-[50%] mx-auto">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          {/* Colonne gauche : Détails principaux */}
          <div>
            <p className="mb-2">
              <HiCalendar className="inline-block mr-2" />
              <strong>Deadline :</strong> {offre.deadLine}
            </p>
            <p className="mb-4">{offre.descrTournee}</p>

            <p className="mb-2">
              <HiCalendar className="inline-block mr-2" />
              <strong>Dates proposées :</strong> {offre.dateMinProposee} - {offre.dateMaxProposee}
            </p>

            <p className="mb-2">
              <HiUsers className="inline-block mr-2" />
              <strong>Places disponibles :</strong> {offre.placesMin} - {offre.placesMax}
            </p>

            <p className="mb-2">
              <HiUsers className="inline-block mr-2" />
              <strong>Artistes concernés :</strong> {offre.nbArtistesConcernes}
            </p>

            <p className="mb-2">
              <HiUsers className="inline-block mr-2" />
              <strong>Invités concernés :</strong> {offre.nbInvitesConcernes}
            </p>
          </div>

          {/* Colonne droite : Badges et extras */}
          <div>
            <div className="mb-4">
              <Badge color="info">
                <HiLocationMarker className="inline-block mr-1" />
                Ville : {offre.villeVisee}
              </Badge>
              <Badge color="info" className="ml-2">
                Région : {offre.regionVisee}
              </Badge>
            </div>

            <div className="mb-4">
              <Badge color="success">Type d'offre : {offre.typeOffre.id}</Badge>
              <Badge color="warning" className="ml-2">État : {offre.etatOffre.id}</Badge>
            </div>

            <div className="mb-4">
              <Badge color="purple">Budget : {offre.budgetEstimatif.id}</Badge>
              <Badge color="indigo" className="ml-2">Conditions financières : {offre.conditionsFinancieres.id}</Badge>
            </div>

            <div className="mb-4">
              <Tooltip content="Voir les liens promotionnels">
                <HiLink className="inline-block mr-1" />
                <strong>Liens :</strong> {offre.liensPromotionnels}
              </Tooltip>
            </div>

            <p>
              <strong>Extras :</strong> {offre.extras.id}
            </p>
            <p>
              <strong>Fiche technique :</strong> {offre.ficheTechniqueArtiste.id}
            </p>
            <p>
              <strong>Utilisateur :</strong> {offre.utilisateur.id}
            </p>
          </div>
        </div>
      </Card>
    </div>
  );
}
