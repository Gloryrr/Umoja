"use client";

import { useEffect, useState } from "react";
import { Table, Spinner, Pagination, Button } from "flowbite-react";
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
}

const TableDesOffres = () => {
    const [offres, setOffres] = useState<Offre[]>([]);
    const [offresTaille, setOffresTaille] = useState<number>(0);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);
    const [currentPage, setCurrentPage] = useState(1);
    const offersPerPage = 10;

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

            const userId = JSON.parse(userResponse.utilisateur)[0].id;
            fetchPaginatedOffers(userId);
        } catch (error) {
            console.error("Erreur réseau :", error);
            setError("Erreur lors de la récupération des offres.");
            setIsLoading(false);
        }
    };

    const fetchPaginatedOffers = async (idUtilisateur: number) => {
        const startIndex = (currentPage - 1) * offersPerPage;
        try {
            const response = await apiGet(`/offre/utilisateur/${idUtilisateur}`);
            const allOffers: Offre[] = JSON.parse(response.offre);
            console.log(allOffers);
            setOffresTaille(allOffers.length);
            setOffres(allOffers.slice(startIndex, startIndex + offersPerPage));
        } catch (error) {
            console.error("Erreur lors de la récupération des offres paginées :", error);
            setError("Erreur lors de la récupération des offres paginées.");
        } finally {
            setIsLoading(false);
        }
    };

    useEffect(() => {
        fetchUserOffers();
    }, [currentPage]);

    const isDateDepassee = (deadLine: string | Date): boolean => {
        const deadlineDate = new Date(deadLine).getTime();
        const today = new Date().getTime();
        return deadlineDate < today;
    };    

    if (isLoading) {
        return <Spinner size="xl" className="mt-2">Chargement des offres...</Spinner>;
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
                <Table>
                    <Table.Head>
                        <Table.HeadCell className="font-bold mx-auto">Titre</Table.HeadCell>
                        <Table.HeadCell className="font-bold mx-auto">Date Limite de réponse</Table.HeadCell>
                        <Table.HeadCell className="font-bold mx-auto">Localisation</Table.HeadCell>
                        <Table.HeadCell className="font-bold mx-auto">Statut</Table.HeadCell>
                        <Table.HeadCell className="font-bold mx-auto">Détail</Table.HeadCell>
                    </Table.Head>
                    <Table.Body>
                        {offres.map((offre) => (
                            <Table.Row key={offre.id} className="bg-white dark:border-gray-700">
                                <Table.Cell>{offre.titleOffre}</Table.Cell>
                                <Table.Cell
                                    className={` ${
                                        isDateDepassee(offre.deadLine || "") ? "text-red-500" : "text-green-500"
                                    }`}
                                >
                                    {offre.deadLine ? new Date(offre.deadLine).toLocaleDateString() : "N/A"}
                                </Table.Cell>
                                <Table.Cell>
                                    {offre.villeVisee || "N/A"}, {offre.regionVisee || "N/A"}
                                </Table.Cell>
                                <Table.Cell                                     className={` ${
                                        isDateDepassee(offre.deadLine || "") ? "text-red-500" : "text-green-500"
                                    }`}>
                                    {isDateDepassee(offre.deadLine || "") ? "Date dépassée" : "Active"}
                                </Table.Cell>
                                <Table.Cell>
                                    <Button size="sm" href={`mes-offres/detail/${offre.id}`}>
                                        Voir Détails
                                    </Button>
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
