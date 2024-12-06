import { useEffect, useState, useCallback } from "react";
import { apiPost } from "@/app/services/internalApiClients";
import { Card, Button, Pagination, Select } from "flowbite-react";
import { useRouter } from "next/navigation";
import { FaArrowAltCircleLeft } from "react-icons/fa";

interface NetworksOffresProps {
    networksName: string | null;
    resetNetwork: () => void;
}

interface Offre {
    id: number;
    titleOffre: string;
    descrTournee: string;
    deadLine: string;
    image : any;
}

function NetworksOffres({ networksName, resetNetwork }: NetworksOffresProps) {
    const [offres, setOffres] = useState<Offre[]>([]);
    const [searchQuery, setSearchQuery] = useState<string>("");
    const [sortOption, setSortOption] = useState<string>("dateCroissant");
    const [currentPage, setCurrentPage] = useState<number>(1);
    const itemsPerPage = 10;
    const router = useRouter();

    const getOffresNetworks = useCallback(async (name: string) => {
        try {
            const data = { nomReseau: name };
            const responses = await apiPost(`/reseau`, JSON.parse(JSON.stringify(data)));
            const reseau = JSON.parse(responses.reseau)?.[0];
            if (reseau) {
                const listeIds = reseau.offres.map((offre: { id: number }) => offre.id);
                await getOffresByListId(listeIds);
            } else {
                console.warn("Aucune offre trouvée pour ce réseau.");
            }
        } catch (error) {
            console.error("Erreur lors de la récupération des offres :", error);
        }
    }, []);

    const getOffresByListId = async (listeId: number[]) => {
        try {
            const data = { listeIdOffre: listeId };
            const responses = await apiPost(`/offres`, JSON.parse(JSON.stringify(data)));
            const offresDetails: Offre[] = JSON.parse(responses.offres);
            if (offresDetails) {
                (offresDetails);
                setOffres(offresDetails);
            } else {
                console.warn("Aucun détail trouvé pour les offres.");
            }
        } catch (error) {
            console.error("Erreur lors de la récupération des détails des offres :", error);
        }
    };

    useEffect(() => {
        if (networksName) {
            getOffresNetworks(networksName);
        }
    }, [networksName, getOffresNetworks]);

    const handlePageChange = (page: number) => {
        setCurrentPage(page);
    };

    const handleSearch = (event: React.ChangeEvent<HTMLInputElement>) => {
        setSearchQuery(event.target.value);
    };

    const handleSortChange = (event: React.ChangeEvent<HTMLSelectElement>) => {
        setSortOption(event.target.value);
    };

    const filteredOffres = offres.filter((offre) =>
        offre.titleOffre.toLowerCase().includes(searchQuery.toLowerCase())
    );

    const sortedOffres = filteredOffres.sort((a, b) => {
        switch (sortOption) {
            case "dateCroissant":
                return new Date(a.deadLine).getTime() - new Date(b.deadLine).getTime();
            case "dateDecroissant":
                return new Date(b.deadLine).getTime() - new Date(a.deadLine).getTime();
            case "nomCroissant":
                return a.titleOffre.localeCompare(b.titleOffre);
            case "nomDecroissant":
                return b.titleOffre.localeCompare(a.titleOffre);
            default:
                return 0;
        }
    });
    

    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentOffres = sortedOffres.slice(startIndex, endIndex);
    const totalPages = Math.ceil(sortedOffres.length / itemsPerPage);

    return (
        <div className="p-6">
            <div className="flex justify-between items-center mb-6">
                <h1 className="text-2xl font-bold">Réseau : {networksName}</h1>
                <div className="flex">
                    <Button onClick={resetNetwork} color="light">
                        <FaArrowAltCircleLeft className="mr-2" size={18} />
                        Retour aux réseaux
                    </Button>
                </div>
            </div>

            {/* Barre de recherche */}
            <div className="flex gap-4 mb-6">
                <input
                    type="text"
                    placeholder="Rechercher par nom"
                    value={searchQuery}
                    onChange={handleSearch}
                    className="w-250 p-2 ml-2 border border-gray-300 rounded-lg"
                />
                <Select value={sortOption} onChange={handleSortChange}>
                    <option value="dateCroissant">Date croissante</option>
                    <option value="dateDecroissant">Date décroissante</option>
                    <option value="nomCroissant">Nom croissant</option>
                    <option value="nomDecroissant">Nom décroissant</option>
                </Select>
            </div>

            {/* Pagination */}
            {totalPages > 1 && (
                <div className="flex justify-center mt-6 mb-6">
                    <Pagination
                        currentPage={currentPage}
                        totalPages={totalPages}
                        onPageChange={handlePageChange}
                    />
                </div>
            )}

            {/* Affichage des offres */}
            {currentOffres.length > 0 ? (
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    {currentOffres.map((offre) => (
                        <Card key={offre.id} className="shadow-md">
                            <img 
                                src={`data:image/jpg;base64,${offre.image}`} 
                                alt={offre.titleOffre} 
                                className="w-full h-48 object-cover" 
                            />
                            <h5 className="text-xl font-bold">{offre.titleOffre}</h5>
                            <p className="text-gray-700">{offre.descrTournee}</p>
                            <p className="text-sm text-gray-500">Date limite : {offre.deadLine}</p>
                            
                            <Button
                                onClick={() => router.push(`/mes-offres/detail/${offre.id}`)}
                                className="mt-4"
                            >
                                Voir détail
                            </Button>
                        </Card>                                                          
                    ))}
                </div>
            ) : (
                <p className="text-gray-500">Aucune offre disponible.</p>
            )}

            {/* Pagination */}
            {totalPages > 1 && (
                <div className="flex justify-center mt-6">
                    <Pagination
                        currentPage={currentPage}
                        totalPages={totalPages}
                        onPageChange={handlePageChange}
                    />
                </div>
            )}
        </div>
    );
}

export default NetworksOffres;
