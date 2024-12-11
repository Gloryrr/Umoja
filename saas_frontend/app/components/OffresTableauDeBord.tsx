"use client";

import { useEffect, useState, useCallback } from "react";
import { Table, Spinner, Pagination } from "flowbite-react";
import { apiGet, apiPost } from "@/app/services/internalApiClients";

interface Offre {
    id: number;
    titleOffre: string | null;
    descrTournee: string | null;
    deadLine: string | Date | null;
    dateMinProposee: string | Date | null;
    dateMaxProposee: string | Date | null;
    villeVisee: string | null;
    regionVisee: string | null;
    placesMin: number | null;
    placesMax: number | null;
    nbArtistesConcernes: number | null;
    nbInvitesConcernes: number | null;
    liensPromotionnels: string;
    etatOffre: {
        id: number;
        nomEtat: string;
    } | null;
}

const TableDesOffres = () => {
    const [username, setUsername] = useState("");
    const [offres, setOffres] = useState<Offre[]>([]);
    const [offresTaille, setOffresTaille] = useState<number>(0);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);
    const [currentPage, setCurrentPage] = useState(1);
    const offersPerPage = 10;

    const fetchPaginatedOffers = useCallback(
        async (idUtilisateur: number) => {
            const startIndex = (currentPage - 1) * offersPerPage;
            try {
                const response = await apiGet(`/offre/utilisateur/${idUtilisateur}`);
                const allOffers: Offre[] = JSON.parse(response.offres);

                const offersWithStates = await Promise.all(
                    allOffers.map(async (offre) => {
                        try {
                            if (offre) {
                                const etatResponse = await apiGet(`/etat-offre/${offre.etatOffre?.id}`);
                                offre.etatOffre = JSON.parse(etatResponse.etat_offre)[0].nomEtat;
                            }
                        } catch (error) {
                            console.error(`Erreur pour l'offre ${offre.id}`, error);
                            if (offre.etatOffre) {
                                offre.etatOffre.nomEtat = "État inconnu";
                            }
                        }
                        return offre;
                    })
                );

                setOffresTaille(allOffers.length);
                setOffres(offersWithStates.slice(startIndex, startIndex + offersPerPage));
            } catch (error) {
                console.error("Erreur lors de la récupération des offres paginées :", error);
                setError("Erreur lors de la récupération des offres paginées.");
            } finally {
                setIsLoading(false);
            }
        },
        [currentPage, offersPerPage]
    );

    const fetchUserOffers = useCallback(async () => {
        await apiGet("/me").then(async (response) => {
            setUsername(response.utilisateur);
            console.log(response.utilisateur);
    
            try {
                const data = { "username" : response.utilisateur };
                const userResponse = await apiPost("/utilisateur", JSON.parse(JSON.stringify(data)));
                if (!userResponse) {
                    setError("Aucune offre trouvée pour cet utilisateur.");
                    setIsLoading(false);
                    return;
                }
                console.log(userResponse);
    
                const userId = JSON.parse(userResponse.utilisateur)[0].id;
                fetchPaginatedOffers(userId);
            } catch (error) {
                console.error("Erreur réseau :", error);
                setError("Erreur lors de la récupération des offres.");
                setIsLoading(false);
            }
        });
    }, [fetchPaginatedOffers]);

    useEffect(() => {
        fetchUserOffers();
    }, [fetchUserOffers]);

    const isDateDepassee = (deadLine: string | Date): boolean => {
        const deadlineDate = new Date(deadLine).getTime();
        const today = new Date().getTime();
        return deadlineDate < today;
    };

    if (isLoading) {
        return  <div className="flex items-center">
                    <p className="mr-2">Chargement des offres...</p>
                    <Spinner size="xl" className="mt-2"></Spinner>
                </div> 
    }

    if (error) {
        return <div className="text-red-500">{error}</div>;
    }

    return (
        <section>
            <div className="flex justify-center">
                <Pagination
                    className="mb-4"
                    currentPage={currentPage}
                    totalPages={Math.ceil(offresTaille / offersPerPage)}
                    onPageChange={(page) => setCurrentPage(page)}
                />
            </div>
            <div className="mx-auto overflow-x-auto">
                <Table striped hoverable>
                    <Table.Head>
                        <Table.HeadCell className="font-bold mx-auto">Titre</Table.HeadCell>
                        <Table.HeadCell className="font-bold mx-auto">Date Limite de réponse</Table.HeadCell>
                        <Table.HeadCell className="font-bold mx-auto">Localisation</Table.HeadCell>
                        <Table.HeadCell className="font-bold mx-auto">Statut</Table.HeadCell>
                        <Table.HeadCell><span className="sr-only">Edit</span></Table.HeadCell>
                    </Table.Head>
                    <Table.Body>
                        {offres.map((offre) => (
                            <Table.Row key={offre.id} className="bg-white dark:border-gray-700">
                                <Table.Cell>{offre.titleOffre}</Table.Cell>
                                <Table.Cell
                                    className={`${
                                        isDateDepassee(offre.deadLine || "") ? "text-red-500" : "text-green-500"
                                    }`}
                                >
                                    {offre.deadLine ? new Date(offre.deadLine).toLocaleDateString() : "N/A"}
                                </Table.Cell>
                                <Table.Cell>
                                    {offre.villeVisee || "N/A"}, {offre.regionVisee || "N/A"}
                                </Table.Cell>
                                <Table.Cell
                                    className={`${
                                        offre.etatOffre?.nomEtat === "En Cours" ? "text-green-500" : "text-red-500"
                                    }`}
                                >
                                    {offre.etatOffre?.nomEtat}
                                </Table.Cell>
                                <Table.Cell>
                                    <a href={`mes-offres/detail/${Number(offre.id)}`} className="font-medium text-cyan-600 hover:underline dark:text-cyan-500">
                                        Détail
                                    </a>
                                </Table.Cell>
                            </Table.Row>
                        ))}
                    </Table.Body>
                </Table>
            </div>
            <div className="flex justify-center">
                <Pagination
                    className="mt-4"
                    currentPage={currentPage}
                    totalPages={Math.ceil(offresTaille / offersPerPage)}
                    onPageChange={(page) => setCurrentPage(page)}
                />
            </div>
        </section>
    );
};

export default TableDesOffres;
