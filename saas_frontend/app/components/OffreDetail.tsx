"use client";

import { useEffect, useState } from "react";
import { Button, Card, TextInput, Label, Modal } from "flowbite-react";
import { HiArrowLeft, HiPencil, HiTrash } from "react-icons/hi";
import { apiGet, apiDelete, apiPatch } from "@/app/services/internalApiClients";

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
  typeOffre: { nomTypeOffre: string };
  conditionsFinancieres: { id: number };
  budgetEstimatif: { id: number };
  utilisateur: { username: string };
  artistes: { nomArtiste: string }[];
  reseaux: { nomReseau: string }[];
}

async function fetchOffreDetails(id: number): Promise<Offre> {
  const response = await apiGet(`/offre/${id}`);
  if (!response) {
    throw new Error("Erreur lors de la récupération des détails de l'offre");
  }
  return JSON.parse(response.offre);
}

async function fetchExtrasOffre(idExtras: number): Promise<any> {
  const response = await apiGet(`/extras/${idExtras}`);
  if (!response) {
    throw new Error("Erreur lors de la récupération des détails de l'offre");
  }
  return JSON.parse(response.extras);
}

async function fecthEtatOffre(idEtatOffre: number): Promise<any> {
  const response = await apiGet(`/etat-offre/${idEtatOffre}`);
  if (!response) {
    throw new Error("Erreur lors de la récupération des détails de l'offre");
  }
  return JSON.parse(response.etat_offre);
}

async function fetchConditionsFinancieres(idConditionFinancieres: number): Promise<any> {
  const response = await apiGet(`/condition-financiere/${idConditionFinancieres}`);
  if (!response) {
    throw new Error("Erreur lors de la récupération des détails de l'offre");
  }
  return JSON.parse(response.condition_financiere);
}

async function fetchBudgetEstimatif(idBudgetEstimatif: number): Promise<any> {
  const response = await apiGet(`/budget-estimatif/${idBudgetEstimatif}`);
  if (!response) {
    throw new Error("Erreur lors de la récupération des détails de l'offre");
  }
  return JSON.parse(response.budget_estimatif);
}

interface OffreDetailProps {
  offreId: number;
}

export default function OffreDetail({ offreId }: OffreDetailProps) {
  const [offre, setOffre] = useState<Offre | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [isEditing, setIsEditing] = useState(false);
  const [showDeleteModal, setShowDeleteModal] = useState(false);

  useEffect(() => {
    fetchOffreDetails(offreId)
      .then((data) => {
        setOffre(data);
        setLoading(false);
        fetchExtrasOffre(data.extras.id).then(
          (data => console.log(data[0]))
        ) // récupération de l'extras
        fecthEtatOffre(data.etatOffre.id).then(
          (data => console.log(data[0]))
        ) // récupération de l'état actuel de l'offre
        fetchConditionsFinancieres(data.conditionsFinancieres.id).then(
          (data => console.log(data[0]))
        )
        fetchBudgetEstimatif(data.budgetEstimatif.id).then(
          (data => console.log(data[0]))
        )
      })
      .catch((err) => {
        setError(err.message);
        setLoading(false);
      });
  }, [offreId]);

  const handleEditToggle = () => {
    setIsEditing(!isEditing);
  };

  const handleDelete = async () => {
    await apiDelete(`/offre/${offreId}`);
    alert("Offre supprimée avec succès.");
    window.location.href = "/umodja/home";
  };

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
      <Button color="light" href={"/umodja/home"} className="mb-4">
        <HiArrowLeft className="mr-2" /> Retour
      </Button>
      <h1 className="text-3xl font-bold mb-6">{offre.titleOffre}</h1>

      <Card className="w-full md:w-[60%] mx-auto shadow-lg">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <Label value="Titre de l'offre" />
            <TextInput
              value={offre.titleOffre}
              readOnly={!isEditing}
              onChange={(e) => setOffre({ ...offre, titleOffre: e.target.value })}
            />
          </div>

          <div>
            <Label value="Description de la tournée" />
            <TextInput
              value={offre.descrTournee}
              readOnly={!isEditing}
              onChange={(e) => setOffre({ ...offre, descrTournee: e.target.value })}
            />
          </div>

          <div>
            <Label value="Date limite" />
            <TextInput
              type="date"
              value={new Date(offre.deadLine).toLocaleDateString()} 
              // à régler plus tard, le format pose problème pour afficher la date dans un input type Date
              readOnly={!isEditing}
              onChange={(e) => setOffre({ ...offre, deadLine: e.target.value })}
            />
          </div>

          <div>
            <Label value="Date minimale de l'offre" />
            <TextInput
              type="date"
              value={offre.dateMinProposee}
              readOnly={!isEditing}
              onChange={(e) => setOffre({ ...offre, dateMinProposee: e.target.value })}
            />
          </div>

          <div>
            <Label value="Date maximale de l'offre" />
            <TextInput
              type="date"
              value={offre.dateMaxProposee}
              readOnly={!isEditing}
              onChange={(e) => setOffre({ ...offre, dateMaxProposee: e.target.value })}
            />
          </div>

          <div>
            <Label value="Ville visée" />
            <TextInput
              value={offre.villeVisee}
              readOnly={!isEditing}
              onChange={(e) => setOffre({ ...offre, villeVisee: e.target.value })}
            />
          </div>

          <div>
            <Label value="Région visée" />
            <TextInput
              value={offre.regionVisee}
              readOnly={!isEditing}
              onChange={(e) => setOffre({ ...offre, regionVisee: e.target.value })}
            />
          </div>

          <div>
            <Label value="Nombre de places (min)" />
            <TextInput
              type="number"
              value={offre.placesMin}
              readOnly={!isEditing}
              onChange={(e) => setOffre({ ...offre, placesMin: parseInt(e.target.value) })}
            />
          </div>

          <div>
            <Label value="Nombre de places (max)" />
            <TextInput
              type="number"
              value={offre.placesMax}
              readOnly={!isEditing}
              onChange={(e) => setOffre({ ...offre, placesMax: parseInt(e.target.value) })}
            />
          </div>

          <div>
            <Label value="Artistes concernés" />
            <span className="block">{offre.artistes.map((artiste) => artiste.nomArtiste).join(", ")}</span>
          </div>

          <div>
            <Label value="Réseaux sociaux" />
            <span className="block">{offre.reseaux.map((reseau) => reseau.nomReseau).join(", ")}</span>
          </div>

          <div>
            <Label value="Type de l'offre" />
            <TextInput value={offre.typeOffre.nomTypeOffre} readOnly />
          </div>

          <div>
            <Label value="Les liens promotionnels de l'artiste" />
            <TextInput
              value={offre.liensPromotionnels}
              readOnly={!isEditing}
              onChange={(e) => setOffre({ ...offre, liensPromotionnels: e.target.value })}
            />
          </div>

          <div>
            <Label value="Nombre d'artistes concernés" />
            <TextInput
              type="number"
              value={offre.nbArtistesConcernes}
              readOnly={!isEditing}
              onChange={(e) => setOffre({ ...offre, nbArtistesConcernes: parseInt(e.target.value) })}
            />
          </div>

          <div>
            <Label value="Nombre de d'invités concernés" />
            <TextInput
              type="number"
              value={offre.nbInvitesConcernes}
              readOnly={!isEditing}
              onChange={(e) => setOffre({ ...offre, nbInvitesConcernes: parseInt(e.target.value) })}
            />
          </div>
        </div>

        <div className="flex justify-end mt-4">
          <Button color="warning" onClick={handleEditToggle}>
            <HiPencil className="mr-2" />
            {isEditing ? "Annuler" : "Modifier"}
          </Button>
          <Button color="failure" className="ml-2" onClick={() => setShowDeleteModal(true)}>
            <HiTrash className="mr-2" />
            Supprimer
          </Button>
        </div>
      </Card>

      <Modal show={showDeleteModal} onClose={() => setShowDeleteModal(false)}>
        <Modal.Header>Confirmer la suppression</Modal.Header>
        <Modal.Body>
          <p>Êtes-vous sûr de vouloir supprimer cette offre ? Cette action est irréversible.</p>
        </Modal.Body>
        <Modal.Footer>
          <Button color="failure" onClick={handleDelete}>
            Supprimer
          </Button>
          <Button color="light" onClick={() => setShowDeleteModal(false)}>
            Annuler
          </Button>
        </Modal.Footer>
      </Modal>
    </div>
  );
}
