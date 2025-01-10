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
    const limit = 9;
    const [selectedGenres, setSelectedGenres] = useState<string[]>([]);
    const [totalPages, setTotalPages] = useState<number>(0);

    const getOffresNetworks = useCallback(async (name: string) => {
        try {
            const data = {
                nomReseau: name,
                page: currentPage,
                limit: limit,
            };
            await apiPost(`/offres/reseau`, JSON.parse(JSON.stringify(data))).then(
                (reponse) => {
                    const offres = JSON.parse(reponse.offres);
                    if (offres) {
                        setOffres(offres);
                        setTotalPages(reponse.nb_pages);
                    } else {
                        console.warn("Aucune offre trouvée pour ce réseau.");
                    }
                }
            );
        } catch (error) {
            console.error("Erreur lors de la récupération des offres :", error);
        }
    }, [currentPage, limit]);
    
    const getGenresMusicaux = async () => {
        try {
            const genresMusicaux = await apiGet(`/genres-musicaux`);
            if (genresMusicaux) {
                setGenresMusicauxApi(JSON.parse(genresMusicaux.genres_musicaux));
            }
        } catch (error) {
            console.error("Erreur lors de la récupération des genres musicaux :", error);
        }
    };
    
    useEffect(() => {
        if (networksName) {
            getOffresNetworks(networksName);
            getGenresMusicaux();
        }
    }, [networksName, getOffresNetworks]);
    
    useEffect(() => {
        if (networksName) {
            getOffresNetworks(networksName);
        }
    }, [networksName, getOffresNetworks]);    

    const handlePageChange = async (page: number) => {
        setCurrentPage(page);
    }

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

    const sortedAndFilteredOffres = filteredOffres.sort((a, b) => {
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

    return (
        <div className="p-6 ml-[15%] mr-[15%]">
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

            {sortedAndFilteredOffres.length > 0 ? (
                <div className="grid grid-cols-3 gap-4 justify-items-stretch">
                    {sortedAndFilteredOffres.map((offre) => (
                        <Card
                            key={offre.id}
                            className="flex flex-col justify-between border border-gray-200 shadow-sm"
                        >
                            <div className="w-full h-40 relative">
                                <Image
                                    src={`data:image/jpg;base64,${offre.image}`}
                                    alt={offre.titleOffre}
                                    layout="fill"
                                    objectFit="cover"
                                    className="rounded-t-lg"
                                />
                            </div>
                            <div className="flex-1 p-4">
                                <h5 className="text-xl font-bold">{offre.titleOffre}</h5>
                                <p className="text-sm text-gray-600">{offre.descrTournee}</p>
                                <p className="text-sm text-gray-500">
                                    Date limite: {offre.deadLine}
                                </p>
                                <p className="text-sm text-gray-500">
                                    Localisation: {offre.villeVisee}, {offre.regionVisee}
                                </p>
                                <p className="text-sm text-gray-500">
                                    Créateur: {offre.utilisateur.username}
                                </p>
                            </div>
                            <div className="p-4">
                                <Button href={`/cardDetailsPage?id=${offre.id}`} fullSized>
                                    Voir détail
                                </Button>
                            </div>
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
