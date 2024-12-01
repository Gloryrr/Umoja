"use client";

import { Button, Spinner, Card, TextInput, Select } from "flowbite-react";
import { useEffect, useState } from "react";
import { apiGet, apiPost } from "@/app/services/internalApiClients";
import { MdArrowLeft, MdArrowRight } from "react-icons/md";
import NetworksOffres from "@/app/components/NetworksOffres";

interface Reseau {
    nomReseau: string;
    nombreUtilisateurs: number;
    genres: string[];
}

interface GenreMusical {
    nomGenreMusical: string;
}

export function Networks() {
    const [reseaux, setReseaux] = useState<Reseau[]>([]);
    const [genresMusicaux, setGenresMusicaux] = useState<GenreMusical[]>([]);
    const [filteredReseaux, setFilteredReseaux] = useState<Reseau[]>([]);
    const [currentPage, setCurrentPage] = useState(1);
    const [searchQuery, setSearchQuery] = useState("");
    const [sortOption, setSortOption] = useState("nomCroissant");
    const [selectedGenres, setSelectedGenres] = useState<string[]>([]);
    const itemsPerPage = 10;

    const [nomReseauChoisi, setNomReseauChoisi] = useState<string>();

    const getNetworksAndGenresMusicaux = async () => {
        const username = localStorage.getItem("username");
        let responses = await apiPost(
            "/utilisateur",
            JSON.parse(JSON.stringify({ username }))
        );
        if (responses) {
            const fetchedReseaux = JSON.parse(responses.utilisateur)[0].reseaux || [];
            setReseaux(fetchedReseaux);
            setFilteredReseaux(fetchedReseaux);
        }
        let responsesGenres = await apiGet("/genres-musicaux");
        if (responsesGenres) {
            const genresMusicaux = JSON.parse(responsesGenres.genres_musicaux);
            console.log("Genres musicaux :", genresMusicaux);
            setGenresMusicaux(genresMusicaux);
        }
    };

    useEffect(() => {
        getNetworksAndGenresMusicaux();
    }, []);

    const handleSearch = (event: React.ChangeEvent<HTMLInputElement>) => {
        const query = event.target.value;
        setSearchQuery(query);
        filterNetworks(query);
    };

    const handleSort = (option: string) => {
        setSortOption(option);
        let sortedReseaux;
        if (option === "nomCroissant") {
            sortedReseaux = [...filteredReseaux].sort((a, b) =>
                a.nomReseau.localeCompare(b.nomReseau)
            );
        } else if (option === "nomDecroissant") {
            sortedReseaux = [...filteredReseaux].sort((a, b) =>
                b.nomReseau.localeCompare(a.nomReseau)
            );
        } else if (option === "utilisateurs") {
            sortedReseaux = [...filteredReseaux].sort((a, b) =>
                b.nombreUtilisateurs - a.nombreUtilisateurs
            );
        } else {
            sortedReseaux = filteredReseaux;
        }
        setFilteredReseaux(sortedReseaux);
    };

    const filterNetworks = (query: string) => {
        let filtered = reseaux.filter((reseau) =>
            reseau.nomReseau.toLowerCase().includes(query.toLowerCase())
        );
        setFilteredReseaux(filtered);
    };

    const handleNetworkClick = (nomReseau: string) => {
        console.log(`Naviguer vers le réseau : ${nomReseau}`);
        setNomReseauChoisi(nomReseau);
    };

    const totalPages = Math.ceil(filteredReseaux.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const currentItems = filteredReseaux.slice(startIndex, startIndex + itemsPerPage);

    const goToNextPage = () => {
        if (currentPage < totalPages) {
            setCurrentPage((prev) => prev + 1);
        }
    };

    const goToPreviousPage = () => {
        if (currentPage > 1) {
            setCurrentPage((prev) => prev - 1);
        }
    };

    const goToPage = (page: number) => {
        setCurrentPage(page);
    };

    const chooseImageRandom = () => {
        const images = [
            "/images/offre-musique.webp",
            "/images/offre-musique-2.webp",
            "/images/offre-musique-3.webp",
            "/images/offre-musique-4.webp",
        ];
        return images[Math.floor(Math.random() * images.length)];
    };

    if (!nomReseauChoisi) {
        return (
            <div className="min-h-screen p-6 flex flex-col items-center">
                {/* Titre et description */}
                <header className="mb-10 text-center max-w-2xl">
                    <h1 className="text-2xl font-bold mb-4">
                        {filteredReseaux.length} réseaux auxquels vous appartenez. Explorez les pour découvrir les évènements musicaux.
                    </h1>
                </header>
    
                {/* Barre de recherche, sélection de tri et genres */}
                <div className="flex justify-between items-center w-full max-w-6xl mb-6">
                    {/* Afficher et barre de recherche */}
                    <div className="flex items-center">
                        <span className="mr-2">Afficher</span>
                        <TextInput
                            type="text"
                            placeholder="Rechercher un réseau..."
                            value={searchQuery}
                            onChange={handleSearch}
                            className="w-full mr-2"
                        />
                        <Select
                            value={selectedGenres}
                            onChange={(updatedGenres) => {console.log(updatedGenres)}}
                        >
                            <option value="">Genres musicaux</option>
                            {genresMusicaux.map((genreMusical, index) => (
                                <option key={index} value={genreMusical.nomGenreMusical}>
                                    {genreMusical.nomGenreMusical}
                                </option>
                            ))}
                        </Select>
                    </div>
    
                    {/* Trier par */}
                    <div className="flex items-center">
                        <span className="mr-2">Trier par</span>
                        <Select
                            value={sortOption}
                            onChange={(e) => handleSort(e.target.value)}
                            className="w-40"
                        >
                            <option value="nomCroissant">Nom (A-Z)</option>
                            <option value="nomDecroissant">Nom (Z-A)</option>
                            <option value="utilisateurs">Nombre d'utilisateurs</option>
                        </Select>
                    </div>
                </div>
    
                {/* Pagination en haut */}
                {filteredReseaux.length > 0 && (
                    <div className="flex justify-center items-center w-full max-w-6xl mb-6">
                        <Button
                            size="sm"
                            disabled={currentPage === 1}
                            onClick={goToPreviousPage}
                            className="mr-2"
                        >
                            <MdArrowLeft size={20} />
                        </Button>
                        <Button
                            color="light"
                            size="sm"
                            className="pointer-events-none"
                        >
                            Page {currentPage} sur {totalPages}
                        </Button>
                        <Button
                            size="sm"
                            disabled={currentPage === totalPages}
                            onClick={goToNextPage}
                            className="ml-2"
                        >
                            <MdArrowRight size={20} />
                        </Button>
                    </div>
                )}
    
                {/* Liste des réseaux */}
                <div className="w-full max-w-6xl">
                    {filteredReseaux.length > 0 ? (
                        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            {currentItems.map((reseau, index) => (
                                <Card
                                    key={index}
                                    className="max-w-sm"
                                    imgAlt="Image"
                                    imgSrc={chooseImageRandom()}
                                >
                                    <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        {reseau.nomReseau}
                                    </h5>
                                    <p className="font-normal text-gray-700 dark:text-gray-400">
                                        Explorez <strong>{reseau.nomReseau}</strong> et découvrez ses fonctionnalités uniques.
                                    </p>
                                    <Button
                                        size="sm"
                                        color="dark"
                                        className="mt-4"
                                        onClick={() => handleNetworkClick(reseau.nomReseau)}
                                    >
                                        Explorer {reseau.nomReseau}
                                    </Button>
                                </Card>
                            ))}
                        </div>
                    ) : (
                        <div className="flex items-center justify-center w-full h-full">
                            <p className="text-center">Chargement de vos réseaux...</p>
                            <Spinner size="lg" className="ml-2" />
                        </div>
                    )}
                </div>
    
                {/* Pagination en bas */}
                {filteredReseaux.length > 0 && (
                    <div className="flex justify-center items-center w-full max-w-6xl mt-6">
                        <Button
                            size="sm"
                            disabled={currentPage === 1}
                            onClick={goToPreviousPage}
                            className="mr-2"
                        >
                            <MdArrowLeft size={20} />
                        </Button>
                        <Button
                            color="light"
                            size="sm"
                            className="pointer-events-none"
                        >
                            Page {currentPage} sur {totalPages}
                        </Button>
                        <Button
                            size="sm"
                            disabled={currentPage === totalPages}
                            onClick={goToNextPage}
                            className="ml-2"
                        >
                            <MdArrowRight size={20} />
                        </Button>
                    </div>
                )}
            </div>
        );
    } else {
        return (
            <div>
                <NetworksOffres 
                    networksName={nomReseauChoisi}
                />
            </div>
        )
    }
}

export default Networks;