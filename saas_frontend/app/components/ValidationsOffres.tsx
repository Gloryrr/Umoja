"use client";

import { useCallback, useEffect, useState } from "react";
import { apiGet, apiPatch, apiPost } from "../../app/services/internalApiClients";
import { Alert, Button, Card, Pagination, Checkbox, Textarea } from "flowbite-react";
import NavigationHandler from "../../app/navigation/Router";

interface EtatReponse {
    nomEtatReponse: string;
}

interface Utilisateur {
    username: string;
}

interface Offre {
    id: number;
}

interface PropositionDeContribution {
    id: number;
    dateDebut: string;
    dateFin: string;
    etatReponse: EtatReponse;
    offre: Offre;
    prixParticipation: number;
    utilisateur: Utilisateur;
}

function ValidationsOffres({ idOffre }: { idOffre: number }) {
    const [propositionsDeContributions, setPropositionsDeContributions] = useState<PropositionDeContribution[]>([]);
    const [currentPage, setCurrentPage] = useState(1);
    const [propositionsPerPage] = useState(6);
    const [successMessage, setSuccessMessage] = useState<string | null>(null);
    const [filteredPropositions, setFilteredPropositions] = useState<PropositionDeContribution[]>([]);
    const [selectedStates, setSelectedStates] = useState({
        enAttente: true,
        validee: false,
        refusee: false,
    });
    const [messageRefusMap, setMessageRefusMap] = useState<{ [key: number]: string }>({});
    const [warningMessageRefusVide, setWarningMessageRefusVide] = useState<{ [key: number]: string | null }>({});

    // Récupérer les propositions
    function getPropositionDeContributions(idOffre: number) {
        apiGet(`/reponses/offre/${idOffre}`).then((response) => {
            if (response) {
                const parsedData = JSON.parse(response.reponses) as PropositionDeContribution[];
                setPropositionsDeContributions(parsedData);
            } else {
                console.error("Erreur lors de la récupération des propositions de contributions");
            }
        });
    }

    // Gérer la validation
    function handleValidation(idProposition: number) {
        setWarningMessageRefusVide((prev) => ({
            ...prev,
            [idProposition]: null,
        }));

        const updatedProposition = {
            ...propositionsDeContributions.find((prop) => prop.id === idProposition),
            etatReponse: { nomEtatReponse: "Validée" },
        };
        const data = updatedProposition;

        apiPatch(`/reponse/update/${idProposition}`, JSON.parse(JSON.stringify(data))).then(async () => {
            setPropositionsDeContributions((prev) =>
                prev.map((prop) =>
                    prop.id === idProposition
                        ? { ...prop, etatReponse: { nomEtatReponse: "Validée" } }
                        : prop
                )
            );
            setSuccessMessage(`Proposition ${idProposition} validée avec succès.`);
            const data = {
                idProposition: idProposition
            }
            await apiPost(
                '/envoi-email-validation-proposition-contribution', 
                JSON.parse(JSON.stringify(data))
            );
        });
    }

    // Gérer le refus
    function handleRefus(idProposition: number) {
        const messageRefus = messageRefusMap[idProposition];
        if (!messageRefus || messageRefus.trim() === "") {
            setWarningMessageRefusVide((prev) => ({
                ...prev,
                [idProposition]: "Veuillez indiquer un motif de refus",
            }));
        } else {
            setWarningMessageRefusVide((prev) => ({
                ...prev,
                [idProposition]: null,
            }));

            const updatedProposition = {
                ...propositionsDeContributions.find((prop) => prop.id === idProposition),
                etatReponse: { nomEtatReponse: "Refusée" },
            };
            const data = updatedProposition;
    
            apiPatch(`/reponse/update/${idProposition}`, JSON.parse(JSON.stringify(data))).then(async () => {
                setPropositionsDeContributions((prev) =>
                    prev.map((prop) =>
                        prop.id === idProposition
                            ? { ...prop, etatReponse: { nomEtatReponse: "Refusée" } }
                            : prop
                    )
                );
                setSuccessMessage(`Proposition ${idProposition} refusée avec succès.`);
                const data = {
                    idProposition: idProposition,
                    messageRefus: messageRefus
                }
                await apiPost(
                    '/envoi-email-refus-proposition-contribution',
                    JSON.parse(JSON.stringify(data))
                );
            });
        }
    }

    // Filtrer les propositions par état
    function handleFilterChange(state: keyof typeof selectedStates) {
        setSelectedStates((prev) => {
            const newState = { ...prev, [state]: !prev[state] };
            applyFilters(newState);
            return newState;
        });
    }

    // Appliquer les filtres de l'état
    const applyFilters = useCallback(
        (selectedStates: { enAttente: boolean; validee: boolean; refusee: boolean }) => {
          const filtered = propositionsDeContributions.filter((prop) => {
            return (
              (selectedStates.enAttente && prop.etatReponse.nomEtatReponse === "En Attente") ||
              (selectedStates.validee && prop.etatReponse.nomEtatReponse === "Validée") ||
              (selectedStates.refusee && prop.etatReponse.nomEtatReponse === "Refusée")
            );
          });
          setFilteredPropositions(filtered);
    
          // Vérifier si la page actuelle est au-delà du nombre de pages disponibles après filtrage
          const totalPages = Math.ceil(filtered.length / propositionsPerPage);
          if (currentPage > totalPages && totalPages > 0) {
            setCurrentPage(totalPages); // Remettre à la dernière page
          }
        },
        [propositionsDeContributions, currentPage, propositionsPerPage] // Memoize dependencies
      );

    useEffect(() => {
        getPropositionDeContributions(idOffre);
    }, [idOffre]);

    useEffect(() => {
        applyFilters(selectedStates);
      }, [propositionsDeContributions, selectedStates, applyFilters]); // Add applyFilters to dependencies
    
    // Pagination des propositions
    const indexOfLastProposition = currentPage * propositionsPerPage;
    const indexOfFirstProposition = indexOfLastProposition - propositionsPerPage;
    const currentPropositions = filteredPropositions.slice(indexOfFirstProposition, indexOfLastProposition);
    const totalPages = Math.ceil(filteredPropositions.length / propositionsPerPage);

    return (
        <div className="p-6 min-h-screen ml-[15%] mr-[15%]">
            <h1 className="text-2xl font-bold mb-6">Propositions</h1>
            
            {/* Accès au détail de l'offre */}
            <NavigationHandler>
                {(handleNavigation) => (
                    <Button
                        onClick={() => handleNavigation(`/cardDetailsPage?id=${idOffre}`)}
                        className="mb-6"
                    >
                        Détail de l&apos;offre
                    </Button>
                )}
            </NavigationHandler>

            {successMessage && (
                <Alert color="success" className="mb-5" onDismiss={() => setSuccessMessage(null)}>
                    {successMessage}
                </Alert>
            )}

            {/* Filtrage des propositions par état */}
            <div className="mb-4">
                <h2 className="font-semibold text-lg">Filtrer par état :</h2>
                <div className="flex gap-4">
                    <label>
                        <Checkbox
                            className="mr-2"
                            checked={selectedStates.enAttente}
                            onChange={() => handleFilterChange("enAttente")}
                        />
                        En Attente
                    </label>
                    <label>
                        <Checkbox
                            className="mr-2"
                            checked={selectedStates.validee}
                            onChange={() => handleFilterChange("validee")}
                        />
                        Validée
                    </label>
                    <label>
                        <Checkbox
                            className="mr-2"
                            checked={selectedStates.refusee}
                            onChange={() => handleFilterChange("refusee")}
                        />
                        Refusée
                    </label>
                </div>
            </div>

            {/* Pagination en haut */}
            <div className="mb-5 flex justify-center">
                <Pagination
                    currentPage={currentPage}
                    totalPages={totalPages}
                    onPageChange={setCurrentPage}
                    className="mt-6"
                />
            </div>

            {/* Affichage des propositions */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {currentPropositions.map((proposition) => (
                    <Card key={proposition.id}>
                        <h2 className="text-lg font-semibold">Utilisateur : {proposition.utilisateur.username}</h2>
                        <p>
                            <strong>Date début :</strong> {new Date(proposition.dateDebut).toLocaleString()}
                        </p>
                        <p>
                            <strong>Date fin :</strong> {new Date(proposition.dateFin).toLocaleString()}
                        </p>
                        <p>
                            <strong>Prix participation :</strong> {proposition.prixParticipation} €
                        </p>
                        <p>
                            <strong>État :</strong>{" "}
                            <span
                                className={`${
                                    proposition.etatReponse.nomEtatReponse === "En Attente"
                                        ? "text-yellow-600"
                                        : proposition.etatReponse.nomEtatReponse === "Validée"
                                        ? "text-green-600"
                                        : "text-red-600"
                                } font-medium`}
                            >
                                {proposition.etatReponse.nomEtatReponse}
                            </span>
                        </p>

                        <div className="flex gap-4 mt-4">
                            <Button
                                color="success"
                                onClick={() => handleValidation(proposition.id)}
                                disabled={proposition.etatReponse.nomEtatReponse !== "En Attente"}
                            >
                                Valider
                            </Button>
                            <Button
                                color="failure"
                                onClick={() => handleRefus(proposition.id)}
                                disabled={proposition.etatReponse.nomEtatReponse !== "En Attente"}
                            >
                                Refuser
                            </Button>
                        </div>

                        <div>
                            <Textarea
                                placeholder="Votre proposition ne me convient pas car ..."
                                value={messageRefusMap[proposition.id] || ""}
                                onChange={(e) =>
                                    setMessageRefusMap((prev) => ({
                                        ...prev,
                                        [proposition.id]: e.target.value,
                                    }))
                                }
                            />
                            <p className="text-red-500">
                                {warningMessageRefusVide && warningMessageRefusVide[proposition.id] ? warningMessageRefusVide[proposition.id] : null}
                            </p>
                        </div>
                    </Card>
                ))}
            </div>

            {/* Pagination en bas */}
            <div className="mt-5 flex justify-center">
                <Pagination
                    currentPage={currentPage}
                    totalPages={totalPages}
                    onPageChange={setCurrentPage}
                    className="mt-6"
                />
            </div>
        </div>
    );
}

export default ValidationsOffres;
