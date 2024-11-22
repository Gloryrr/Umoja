"use client";

import { useEffect, useState } from "react";
import { Button, Label, Modal, Progress, Accordion, Textarea } from "flowbite-react";
import { HiArrowLeft, HiPencil, HiTrash } from "react-icons/hi";
import { apiGet, apiDelete, apiPost } from "@/app/services/internalApiClients";
import CommentaireSection from "@/app/components/Commentaires/CommentaireSection";

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
  reponses: { id: number }[];
  commenteesPar: { id: number }[];
}

interface Extras {
  id: number;
  descrExtras: string;
  coutExtras: number;
  exclusivite: string;
  exception: string;
  ordrePassage: string;
  clausesConfidentialites: string;
}

interface EtatOffre {
  id: number;
  nomEtatOffre: string;
}

interface ConditionsFinancieres {
  id: number;
  minimumGaranti: number;
  conditionsPaiement: string;
  pourcentageRecette: number;
}

interface BudgetEstimatif {
  id: number;
  cachetArtiste: number;
  fraisDeplacement: number;
  fraisHebergement: number;
  fraisRestauration: number;
}

interface Reponse {
  id: number;
  etatReponseId: number;
  offreId: number;
  utilisateurId: number;
  dateDebut: string;
  dateFin: string;
  prixParticipation: number;
}

interface Commentaire {
  id: number;
  utilisateur : {
      username : string;
  }
  commentaire: string;
}

async function fetchOffreDetails(id: number): Promise<Offre> {
  const response = await apiGet(`/offre/${id}`);
  if (!response) {
    throw new Error("Erreur lors de la récupération des détails de l'offre");
  }
  return JSON.parse(response.offre);
}

async function fetchExtrasOffre(idExtras: number): Promise<Extras[]> {
  const response = await apiGet(`/extras/${idExtras}`);
  if (!response) {
    throw new Error("Erreur lors de la récupération des détails de l'offre");
  }
  return JSON.parse(response.extras);
}

async function fecthEtatOffre(idEtatOffre: number): Promise<EtatOffre[]> {
  const response = await apiGet(`/etat-offre/${idEtatOffre}`);
  if (!response) {
    throw new Error("Erreur lors de la récupération des détails de l'offre");
  }
  return JSON.parse(response.etat_offre);
}

async function fetchConditionsFinancieres(idConditionFinancieres: number): Promise<ConditionsFinancieres[]> {
  const response = await apiGet(`/condition-financiere/${idConditionFinancieres}`);
  if (!response) {
    throw new Error("Erreur lors de la récupération des détails de l'offre");
  }
  return JSON.parse(response.condition_financiere);
}

async function fetchBudgetEstimatif(idBudgetEstimatif: number): Promise<BudgetEstimatif[]> {
  const response = await apiGet(`/budget-estimatif/${idBudgetEstimatif}`);
  if (!response) {
    throw new Error("Erreur lors de la récupération des détails de l'offre");
  }
  return JSON.parse(response.budget_estimatif);
}

async function fetchReponse(idReponse: number): Promise<Reponse[]> {
  const response = await apiGet(`/reponse/${idReponse}`);
  if (!response) {
    throw new Error("Erreur lors de la récupération de la réponse");
  }
  return JSON.parse(response.reponse);
}

async function fetchCommentaire(idCommenaire: number): Promise<Commentaire[]> {
  const response = await apiGet(`/commentaire/${idCommenaire}`);
  if (!response) {
    throw new Error("Erreur lors de la récupération du commentaire");
  }
  return JSON.parse(response.commentaires);
}

interface OffreDetailProps {
  offreId: number;
}

export default function OffreDetail({ offreId }: OffreDetailProps) {
  const [commentaire, setCommentaire] = useState("");
  const [offre, setOffre] = useState<Offre | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [isEditing, setIsEditing] = useState(false);
  const [showDeleteModal, setShowDeleteModal] = useState(false);
  const [extras, setExtras] = useState<Extras | null>(null);
  const [etatOffre, setEtatOffre] = useState<EtatOffre | null>(null);
  const [conditionsFinancieres, setConditionsFinancieres] = useState<ConditionsFinancieres | null>(null);
  const [budgetEstimatif, setBudgetEstimatif] = useState<BudgetEstimatif | null>(null);
  const [reponses, setReponses] = useState<Reponse[]>([]);
  const [commentaires, setCommentaires] = useState<Commentaire[]>([]);
  const [montantTotal, setMontantTotal] = useState<number>(0);
  const [montantTotalRecu, setMontantTotalRecu] = useState<number>(5);
  const [timeLeft, setTimeLeft] = useState<string | null>(null);

  useEffect(() => {
    fetchOffreDetails(offreId)
      .then((data) => {
        setOffre(data);
        setLoading(false);
        fetchExtrasOffre(data.extras.id).then((data => {setExtras(data[0])})) // récupération de l'extras
        fecthEtatOffre(data.etatOffre.id).then((data => {setEtatOffre(data[0])})) // récupération de l'état actuel de l'offre
        fetchConditionsFinancieres(data.conditionsFinancieres.id).then((data => {setConditionsFinancieres(data[0])}))
        fetchBudgetEstimatif(data.budgetEstimatif.id).then((data => {setBudgetEstimatif(data[0])}))
        const allReponses: Reponse[] = [];
        data.reponses.forEach((reponse) => {
          fetchReponse(reponse.id).then((reponseData) => {
            allReponses.push(...reponseData);
            if (allReponses.length === data.reponses.length) {
              setReponses(allReponses);
              setMontantTotalRecu(calculSommeTotalRecu(allReponses));
            }
          });
        });
        const allCommentaires: Commentaire[] = [];
        console.log(data.commenteesPar);
        data.commenteesPar.forEach((commentaire) => {
          fetchCommentaire(commentaire.id).then((commentaireData) => {
            allCommentaires.push(...commentaireData);
            if (allCommentaires.length === data.commenteesPar.length) {
              setCommentaires(allCommentaires);
            }
          });
        });
      })
      .catch((err) => {
        setError(err.message);
        setLoading(false);
      });
  }, [offreId]);

  useEffect(() => {
    if (!offre || !offre.deadLine) return;

    const deadlineDate = new Date(offre.deadLine).getTime();

    const updateCountdown = () => {
      const now = Date.now();
      const diff = deadlineDate - now;

      if (diff <= 0) {
        setTimeLeft("Délai expiré");
        return;
      }

      const days = Math.floor(diff / (1000 * 60 * 60 * 24));
      const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((diff % (1000 * 60)) / 1000);

      setTimeLeft(`${days}j ${hours}h ${minutes}m ${seconds}s`);
    };

    const intervalId = setInterval(updateCountdown, 1000);

    return () => clearInterval(intervalId);
  }, [offre]);

  useEffect(() => {
    if (budgetEstimatif) {
      const total = 
        budgetEstimatif.cachetArtiste + 
        budgetEstimatif.fraisDeplacement + 
        budgetEstimatif.fraisHebergement + 
        budgetEstimatif.fraisRestauration;
  
      setMontantTotal(total);
      console.log("Montant total calculé :", total);
    }
  }, [budgetEstimatif]);  

  const handleEditToggle = () => {
    setIsEditing(!isEditing);
  };

  const calculSommeTotalRecu = (reponses: Reponse[]) => {
    return reponses.reduce(
      (acc, reponse) => acc + reponse.prixParticipation, 0
    );
  };  

  const calculPourcentageMontantTotalRecu = () => {
    if (!montantTotal) {
      return 0;
    }
    const pourcentage = (montantTotalRecu / montantTotal) * 100;
    return parseFloat(pourcentage.toFixed(1));
  }

  const handleDelete = async () => {
    await apiDelete(`/offre/${offreId}`);
    alert("Offre supprimée avec succès.");
    window.location.href = "/umodja/home";
  };

  interface Commentaire {
    id: number;
    utilisateur : {
      username: string;
    },
    commentaire: string;
  }

  const handleCommentSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();

    if (!commentaire.trim()) {
      setError("Le commentaire ne peut pas être vide.");
      return;
    }

    setLoading(true);
    setError("");

    const data = JSON.stringify({
      commentaire: {
        idOffre: offre?.id,
        username: localStorage.getItem("username"),
        contenu: commentaire,
      },
    });

    try {
      await apiPost("/commentaire/create", JSON.parse(data));
      setCommentaire("");
      alert("Commentaire ajouté avec succès !");
    } catch (err) {
      setError("Une erreur est survenue lors de l'ajout du commentaire.");
      throw err;
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return <p>Chargement des détails de l&apos;offre...</p>;
  }

  if (error) {
    return <p>Erreur : {error}</p>;
  }

  if (!offre) {
    return <p>Aucune offre trouvée.</p>;
  }

  return (
    <div className="p-6">
      <Button href={"/umodja/home"} className="mb-4 w-[15%]">
        <HiArrowLeft className="mr-2" />
        <span>Retour</span>
      </Button>
  
      <Accordion className="ml-[20%] mr-[20%]" collapseAll>
        <Accordion.Panel>
          <Accordion.Title>Détails de l&apos;offre</Accordion.Title>
          <Accordion.Content>
              <h1 className="text-3xl font-bold mb-6">{offre.titleOffre}</h1>
        
              {/* Informations générales */}
              <div className="mb-6">
                <Label value="Date limite de la tournée" />
                <p>{new Date(offre.deadLine).toLocaleDateString()}</p>
                <p className="text-red-500 font-semibold">Temps restant : {timeLeft}</p>
              </div>
        
              <div className="mb-6">
                <Progress progress={calculPourcentageMontantTotalRecu()} size="lg" color="green" />
                <p className="mt-2">Avancement de la cagnotte : {calculPourcentageMontantTotalRecu()} %</p>
              </div>
        
              {/* Détails de l'offre */}
              <h2 className="text-2xl font-bold mt-8">Offre</h2>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <Label value="Description" />
                  <p>{offre.descrTournee}</p>
                </div>
                <div>
                  <Label value="Ville visée" />
                  <p>{offre.villeVisee}</p>
                </div>
                <div>
                  <Label value="Région visée" />
                  <p>{offre.regionVisee}</p>
                </div>
                <div>
                  <Label value="Nombre de places (min)" />
                  <p>{offre.placesMin}</p>
                </div>
                <div>
                  <Label value="Nombre de places (max)" />
                  <p>{offre.placesMax}</p>
                </div>
                <div>
                  <Label value="Date minimale" />
                  <p>{offre.dateMinProposee}</p>
                </div>
                <div>
                  <Label value="Date maximale" />
                  <p>{offre.dateMaxProposee}</p>
                </div>
                <div>
                  <Label value="Nombre d'artistes concernés" />
                  <p>{offre.nbArtistesConcernes}</p>
                </div>
                <div>
                  <Label value="Nombre d'invités concernés" />
                  <p>{offre.nbInvitesConcernes}</p>
                </div>
                <div>
                  <Label value="Liens promotionnels" />
                  <p>{offre.liensPromotionnels}</p>
                </div>
              </div>
        
              {/* Extras */}
              {extras && (
                <div className="mb-6">
                  <h2 className="text-2xl font-bold mt-8">Extras</h2>
                  <p>Exclusivité : {extras.exclusivite}</p>
                  <p>Clauses de confidentialité : {extras.clausesConfidentialites}</p>
                  <p>Exception : {extras.exception}</p>
                  <p>Ordre de passage : {extras.ordrePassage}</p>
                </div>
              )}
        
              {/* État de l'offre */}
              {etatOffre && (
                <div className="mb-6">
                  <Label value="État de l'offre" />
                  <p>{etatOffre.nomEtatOffre}</p>
                </div>
              )}
        
              {/* Type d'offre */}
              {offre.typeOffre && (
                <div className="mb-6">
                  <Label value="Type d'offre" />
                  <p>{offre.typeOffre.nomTypeOffre}</p>
                </div>
              )}
        
              {/* Conditions financières */}
              {conditionsFinancieres && (
                <div className="mb-6">
                  <h2 className="text-2xl font-bold mt-8">Conditions financières</h2>
                  <p>Minimum garanti : {conditionsFinancieres.minimumGaranti} €</p>
                  <p>Conditions de paiement : {conditionsFinancieres.conditionsPaiement}</p>
                  <p>Pourcentage sur recettes : {conditionsFinancieres.pourcentageRecette} %</p>
                </div>
              )}
        
              {/* Budget estimatif */}
              {budgetEstimatif && (
                <div className="mb-6">
                  <h2 className="text-2xl font-bold mt-8">Budget estimatif</h2>
                  <p>Cachet artiste : {budgetEstimatif.cachetArtiste} €</p>
                  <p>Frais de déplacement : {budgetEstimatif.fraisDeplacement} €</p>
                  <p>Frais d&apos;hébergement : {budgetEstimatif.fraisHebergement} €</p>
                  <p>Frais de restauration : {budgetEstimatif.fraisRestauration} €</p>
                </div>
              )}
        
              {/* Artistes */}
              {offre.artistes && (
                <div className="mb-6">
                  <h2 className="text-2xl font-bold mt-8">Artistes</h2>
                  <ul>
                    {offre.artistes.map((artiste, index) => (
                      <li key={index}>{artiste.nomArtiste}</li>
                    ))}
                  </ul>
                </div>
              )}
        
              {/* Réseaux */}
              {offre.reseaux && (
                <div className="mb-6">
                  <h2 className="text-2xl font-bold mt-8">Réseaux</h2>
                  <ul>
                    {offre.reseaux.map((reseau, index) => (
                      <li key={index}>{reseau.nomReseau}</li>
                    ))}
                  </ul>
                </div>
              )}

              <div className="flex justify-end mt-12 gap-4">
                <Button color="warning" onClick={handleEditToggle}>
                  <HiPencil className="mr-2" />
                  Modifier
                </Button>
                <Button color="failure" onClick={() => setShowDeleteModal(true)}>
                  <HiTrash className="mr-2" />
                  Supprimer
                </Button>
              </div>
          </Accordion.Content>
        </Accordion.Panel>
      </Accordion>

      {/* Modal de confirmation */}
      <Modal
        show={showDeleteModal}
        onClose={() => setShowDeleteModal(false)}
      >
        <Modal.Header>Confirmation</Modal.Header>
        <Modal.Body>
          <p>Êtes-vous sûr de vouloir supprimer cette offre ? Cette action est irréversible.</p>
        </Modal.Body>
        <Modal.Footer>
          {/* Boutons dans le modal */}
          <Button color="gray" onClick={() => setShowDeleteModal(false)}>
            Annuler
          </Button>
          <Button color="failure" onClick={handleDelete}>
            Confirmer
          </Button>
        </Modal.Footer>
      </Modal>
      {/* Zone de commentaires */}
      <div className="mt-10 ml-[20%] mr-[20%] mx-auto">
        <h2 className="font-semibold mb-2">Commentaires</h2>
        <form onSubmit={handleCommentSubmit}>
          <Textarea
            value={commentaire}
            onChange={(e) => setCommentaire(e.target.value)}
            placeholder="Écrivez un commentaire..."
            rows={4}
            required
            className="mb-2"
          />
          {error && <p className="error">{error}</p>}
          <Button type="submit" disabled={loading}>
            {loading ? "Envoi..." : "Poster le commentaire"}
          </Button>
        </form>
      </div>
      <CommentaireSection commentaires={commentaires} />
    </div>
  );  
}