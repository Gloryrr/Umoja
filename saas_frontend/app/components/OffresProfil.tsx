"use client";
import React, { useEffect, useState } from "react";
import { Card, Badge, Button, Pagination, Select } from "flowbite-react";
import { apiPost, apiGet } from "@/app/services/internalApiClients";

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

const OffresProfil: React.FC = () => {
    const [offres, setOffres] = useState<Offre[]>([]);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);
    const [currentPage, setCurrentPage] = useState(1);
    const [offersPerPage, setOffersPerPage] = useState(10);
    const [totalOffers, setTotalOffers] = useState(0);

    const fetchUserOffers = async () => {
        const username = localStorage.getItem("username");
        if (!username) {
            setError("Nom d'utilisateur introuvable dans le localStorage.");
            setIsLoading(false);
            return;
        }

        try {
            const data = { username };
            const userResponse = await apiPost("/utilisateur", JSON.parse(JSON.stringify(data)));
            if (!userResponse) {
                setError("Aucune offre trouvée pour cet utilisateur.");
                setIsLoading(false);
                return;
            }

            const offerIds: string[] = JSON.parse(userResponse.utilisateur)[0].offres;
            setTotalOffers(offerIds.length);
            fetchPaginatedOffers(JSON.parse(userResponse.utilisateur)[0].id);
        } catch (error) {
            console.error("Erreur réseau :", error);
            setError("Erreur lors de la récupération des offres.");
        } finally {
            setIsLoading(false);
        }
    };

    const fetchPaginatedOffers = async (idUtilisateur : number) => {
        const startIndex = (currentPage - 1) * offersPerPage;
        const endIndex = startIndex + offersPerPage;

        try {
            const reponses = await apiGet(`/offre/utilisateur/${idUtilisateur}`);
            const offersData: Offre[] = JSON.parse(reponses.offre).slice(startIndex, endIndex);
            setOffres(offersData);
            setIsLoading(false);
        } catch (error) {
            console.error("Erreur lors de la récupération des offres paginées :", error);
            // setError("Erreur lors de la récupération des offres paginées.");
            return; // on verra plus tard pour faire la gestion d'erreur.
        }
    };

    useEffect(() => {
        fetchUserOffers();
    }, [currentPage, offersPerPage]);

    const handlePageChange = (page: number) => {
        setCurrentPage(page);
        setIsLoading(true);
    };

    const handleOffersPerPageChange = (event: React.ChangeEvent<HTMLSelectElement>) => {
        setOffersPerPage(Number(event.target.value));
        setCurrentPage(1);
        setIsLoading(true);
    };

    if (isLoading) {
        return <div>Chargement des offres...</div>;
    }

    if (error) {
        return <div className="text-red-500">{error}</div>;
    }

    return (
        <div className="flex flex-col gap-6">
            <h2 className="text-xl font-semibold mb-4">Mes Offres</h2>

            <div className="flex justify-center items-center gap-4 w-full">
                <Pagination
                    currentPage={currentPage}
                    totalPages={Math.ceil(totalOffers / offersPerPage)}
                    showIcons
                    onPageChange={handlePageChange}
                />
                <Select
                    onChange={handleOffersPerPageChange}
                    value={offersPerPage}
                    className="w-48 p-2 rounded-lg"
                >
                    <option value="5">5 offres par page</option>
                    <option value="10">10 offres par page</option>
                    <option value="20">20 offres par page</option>
                </Select>
            </div>

            <div className="grid grid-cols-2 gap-6">
                {offres.map((offre) => (
                    <Card key={offre.id} className="mb-4">
                        <h3 className="text-lg font-bold">{offre.titleOffre}</h3>
                        <p>{offre.descrTournee}</p>
                        <Badge color="info">Deadline : {new Date(offre.deadLine).toLocaleDateString()}</Badge>
                        <p className="text-sm">
                            Dates proposées : {new Date(offre.dateMinProposee).toLocaleDateString()} -{" "}
                            {new Date(offre.dateMaxProposee).toLocaleDateString()}
                        </p>
                        <p>Lieu : {offre.villeVisee}, {offre.regionVisee}</p>
                        <Button href={`/umodja/mes-offres/detail/${offre.id}`} className="mt-4">
                            Voir les détails
                        </Button>
                    </Card>
                ))}
            </div>

            <div className="flex justify-center mt-4">
                <Pagination
                    currentPage={currentPage}
                    totalPages={Math.ceil(totalOffers / offersPerPage)}
                    showIcons
                    onPageChange={handlePageChange}
                />
            </div>
        </div>
    );
};

export default OffresProfil;
