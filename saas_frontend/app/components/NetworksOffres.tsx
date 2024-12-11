"use client";

import { useEffect, useState, useCallback } from "react";
import { apiPost, apiGet } from "@/app/services/internalApiClients";
import { Card, Button, Pagination, Select, TextInput, Dropdown, Checkbox } from "flowbite-react";
import { FaArrowAltCircleLeft } from "react-icons/fa";
import Image from "next/image";

interface NetworksOffresProps {
    networksName: string | null;
    resetNetwork: () => void;
}

interface Offre {
    id: number;
    titleOffre: string;
    descrTournee: string;
    deadLine: string;
    image: string;
    genresMusicaux: string[];
    villeVisee: string;
    regionVisee: string;
    budgetEstimatif: { id: number };
    etatOffre: { id: number };
    typeOffre: { nomTypeOffre: string };
    utilisateur: { username: string };
}

interface GenreMusical {
    id: number;
    nomGenreMusical: string;
}

function NetworksOffres({ networksName, resetNetwork }: NetworksOffresProps) {
    const [offres, setOffres] = useState<Offre[]>([]);
    const [genresMusicauxApi, setGenresMusicauxApi] = useState<GenreMusical[]>([]);
    const [searchQuery, setSearchQuery] = useState<string>("");
    const [sortOption, setSortOption] = useState<string>("dateCroissant");
    const [currentPage, setCurrentPage] = useState<number>(1);
    const [villeViseeFilter, setVilleViseeFilter] = useState<string>("");
    const [regionViseeFilter, setRegionViseeFilter] = useState<string>("");
    const itemsPerPage = 9;
    const [selectedGenres, setSelectedGenres] = useState<string[]>([]);

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
                setOffres(offresDetails);
            } else {
                console.warn("Aucun détail trouvé pour les offres.");
            }
        } catch (error) {
            console.error("Erreur lors de la récupération des détails des offres :", error);
        }
    };

    const getGenresMusicaux = async() => {
        try {
            const genresMusicaux = await apiGet(`/genres-musicaux`);
            if (genresMusicaux) {
                console.log(genresMusicaux);
                setGenresMusicauxApi(JSON.parse(genresMusicaux.genres_musicaux));
            }
        } catch (error) {
            console.error("Erreur lors de la récupération des genres musicaux :", error);
        }
    }

    useEffect(() => {
        if (networksName) {
            getOffresNetworks(networksName);
            getGenresMusicaux();
        }
    }, [networksName, getOffresNetworks]);

    const handlePageChange = (page: number) => setCurrentPage(page);

    const handleSearch = (event: React.ChangeEvent<HTMLInputElement>) =>
        setSearchQuery(event.target.value);

    const handleSortChange = (event: React.ChangeEvent<HTMLSelectElement>) =>
        setSortOption(event.target.value);

    const handleFilterChange = (setter: (value: string) => void) =>
        (event: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) =>
            setter(event.target.value);

    const filteredOffres = offres
        .filter((offre) =>
            offre.titleOffre.toLowerCase().includes(searchQuery.toLowerCase())
        )
        .filter((offre) =>
            selectedGenres.length > 0
                ? selectedGenres.some((genre) => offre.genresMusicaux.includes(genre))
                : true
        )
        .filter((offre) =>
            villeViseeFilter ? offre.villeVisee.toLowerCase().startsWith(villeViseeFilter.toLowerCase()) : true
        )
        .filter((offre) =>
            regionViseeFilter ? offre.regionVisee.toLowerCase().startsWith(regionViseeFilter.toLowerCase()) : true
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
                <Button onClick={resetNetwork} color="light">
                    <FaArrowAltCircleLeft className="mr-2" size={18} />
                    Retour aux réseaux
                </Button>
            </div>

            <div className="flex flex-wrap gap-4 mb-6">
                <TextInput
                    type="text"
                    placeholder="Rechercher par nom"
                    value={searchQuery}
                    onChange={handleSearch}
                />
                <Select value={sortOption} onChange={handleSortChange}>
                    <option value="dateCroissant">Date croissante</option>
                    <option value="dateDecroissant">Date décroissante</option>
                    <option value="nomCroissant">Nom croissant</option>
                    <option value="nomDecroissant">Nom décroissant</option>
                </Select>
                <Dropdown
                    label="Genres musicaux"
                    inline={true}
                    size="sm"
                    className="max-h-64 overflow-y-auto"
                    dismissOnClick={false}
                >
                    {genresMusicauxApi.map((genreMusical) => (
                        <div key={genreMusical.id} className="flex items-center px-4 py-2">
                            <Checkbox
                                id={`genre-${genreMusical.id}`}
                                value={genreMusical.nomGenreMusical}
                                checked={selectedGenres.includes(genreMusical.nomGenreMusical)}
                                onChange={(event) => {
                                    const genre = event.target.value;
                                    setSelectedGenres((prevSelected) =>
                                        prevSelected.includes(genre)
                                            ? prevSelected.filter((g) => g !== genre)
                                            : [...prevSelected, genre]
                                    );
                                }}
                            />
                            <label
                                htmlFor={`genre-${genreMusical.id}`}
                                className="ml-2 cursor-pointer"
                            >
                                {genreMusical.nomGenreMusical}
                            </label>
                        </div>
                    ))}
                </Dropdown>
                <TextInput
                    type="text"
                    placeholder="Localisation (ville)"
                    value={villeViseeFilter}
                    onChange={handleFilterChange(setVilleViseeFilter)}
                />
                <TextInput
                    type="text"
                    placeholder="Localisation (région)"
                    value={regionViseeFilter}
                    onChange={handleFilterChange(setRegionViseeFilter)}
                />
            </div>

            {totalPages > 1 && (
                <div className="flex justify-center mb-5">
                    <Pagination
                        currentPage={currentPage}
                        totalPages={totalPages}
                        onPageChange={handlePageChange}
                    />
                </div>
            )}

            {currentOffres.length > 0 ? (
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    {currentOffres.map((offre) => (
                        <Card key={offre.id}>
                            <div className="w-full h-40 relative">
                                <Image
                                    src={`data:image/jpg;base64,${offre.image}`}
                                    alt={offre.titleOffre}
                                    layout="fill"
                                    objectFit="cover"
                                />
                            </div>
                            <h5 className="text-xl font-bold">{offre.titleOffre}</h5>
                            <p>{offre.descrTournee}</p>
                            <p className="text-sm">Date limite: {offre.deadLine}</p>
                            <p className="text-sm">Localisation: {offre.villeVisee}, {offre.regionVisee}</p>
                            <p className="text-sm">Créateur: {offre.utilisateur.username}</p>
                            <Button href={`/mes-offres/detail/${offre.id}`}>
                                Voir détail
                            </Button>
                        </Card>
                    ))}
                </div>
            ) : (
                <p>Aucune offre disponible.</p>
            )}

            {totalPages > 1 && (
                <div className="flex justify-center mt-5">
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
