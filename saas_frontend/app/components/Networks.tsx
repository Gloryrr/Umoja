"use client";

import { Button, Spinner, Card, Dropdown, Checkbox, Select } from "flowbite-react";
import { useEffect, useState } from "react";
import { apiGet, apiPost } from "@/app/services/internalApiClients";
import { MdArrowLeft, MdArrowRight } from "react-icons/md";
import NetworksOffres from "@/app/components/NetworksOffres";
import { IoMdMailOpen, IoMdPeople } from "react-icons/io";
import { MdQueueMusic } from "react-icons/md";
import { FaGear } from "react-icons/fa6";

interface Reseau {
    nomReseau: string;
    nombreUtilisateurs: number;
    genres: string[];
}

interface GenreMusical {
    nomGenreMusical: string;
}

export function Networks() {
    const [genresMusicaux, setGenresMusicaux] = useState<GenreMusical[]>([]);
    const [filteredReseaux, setFilteredReseaux] = useState<Reseau[] | null>(null);
    const [currentPage, setCurrentPage] = useState(1);
    const [sortOption, setSortOption] = useState("nomCroissant");
    const [selectedGenres, setSelectedGenres] = useState<string[]>([]);
    const itemsPerPage = 10;

    const [nomReseauChoisi, setNomReseauChoisi] = useState<string | null>();

    const getNetworksAndGenresMusicaux = async () => {
        const username = sessionStorage.getItem("username");
        const responses = await apiPost(
            "/utilisateur",
            JSON.parse(JSON.stringify({ username }))
        );
        if (responses) {
            const fetchedReseaux = JSON.parse(responses.utilisateur)[0].reseaux || [];
            console.log(fetchedReseaux);
            setFilteredReseaux(fetchedReseaux);
        }
        const responsesGenres = await apiGet("/genres-musicaux");
        if (responsesGenres) {
            const genresMusicaux = JSON.parse(responsesGenres.genres_musicaux);
            console.log("Genres musicaux :", genresMusicaux);
            setGenresMusicaux(genresMusicaux);
        }
    };

    useEffect(() => {
        getNetworksAndGenresMusicaux();
    }, []);

    const handleSort = (option: string) => {
        setSortOption(option);
        let sortedReseaux;
        if (filteredReseaux) {
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
        }
    };

    const handleNetworkClick = (nomReseau: string) => {
        console.log(`Naviguer vers le réseau : ${nomReseau}`);
        setNomReseauChoisi(nomReseau);
    };

    const toggleGenre = (genre: string) => {
        setSelectedGenres((prevGenres) =>
            prevGenres.includes(genre)
                ? prevGenres.filter((g) => g !== genre)
                : [...prevGenres, genre]
        );
    };

    const startIndex = (currentPage - 1) * itemsPerPage;
    const totalPages = filteredReseaux ? Math.ceil(filteredReseaux.length / itemsPerPage) : 1;
    const currentItems = filteredReseaux ? filteredReseaux.slice(startIndex, startIndex + itemsPerPage) : [];

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

    const chooseImageRandom = () => {
        const images = [
            "/images/offre-musique.webp",
            "/images/offre-musique-2.webp",
            "/images/offre-musique-3.webp",
            "/images/offre-musique-4.webp",
        ];
        return images[Math.floor(Math.random() * images.length)];
    };

    const resetNetwork = () => {
        setNomReseauChoisi(null);
    };

    if (!nomReseauChoisi) {
        return (
            <div className="min-h-screen p-6 flex flex-col items-center">
                {/* Titre et description */}
                <header className="mb-10 text-center max-w-2xl">
                    {filteredReseaux && filteredReseaux.length > 0 && (
                        <h1 className="text-2xl font-bold mb-4">
                            {filteredReseaux != null ? filteredReseaux.length : 0} réseaux auxquels vous appartenez. Explorez les pour découvrir les évènements musicaux.
                        </h1>
                    )}
                    {filteredReseaux && filteredReseaux.length == 0 && (
                        <h1 className="text-2xl font-bold">
                            Vous n&apos;êtes dans aucun réseau. Contactez notre administrateur pour vous ajoutez à des réseaux.
                        </h1>
                    )}
                </header>
    
                {/* Barre de recherche, sélection de tri et genres */}
                {filteredReseaux && filteredReseaux.length > 0 && (
                    <div className="flex justify-between items-center w-full max-w-6xl mb-6">
                        <div className="flex">
                            <p className="mr-5">Afficher par</p>
                            
                            {/* Filtres par genres musicaux */}
                            <Dropdown
                                label="Genres musicaux"
                                inline={true}
                                size="sm"
                                className="max-h-64 overflow-y-auto"
                                dismissOnClick={false}
                            >
                                {genresMusicaux.map((genreMusical, index) => (
                                    <Dropdown.Item key={index} className="flex items-center gap-2">
                                    <Checkbox
                                        checked={selectedGenres.includes(genreMusical.nomGenreMusical)}
                                        onChange={() => toggleGenre(genreMusical.nomGenreMusical)}
                                    />
                                    <span>{genreMusical.nomGenreMusical}</span>
                                    </Dropdown.Item>
                                ))}
                            </Dropdown>
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
                                <option value="utilisateurs">Nombre d&apos;utilisateurs</option>
                            </Select>
                        </div>
                    </div>
                )} 
                {filteredReseaux && filteredReseaux.length == 0 && (
                    <div>
                        <div className="flex items-center justify-center w-full h-full">
                            <Button
                                size="lg"
                                className="mt-4"
                                href="/contact"
                            >
                                Contactez notre administrateur en cliquant ici
                                <IoMdMailOpen className="ml-2" size={24} />
                            </Button>
                        </div>
                    </div>
                )}
    
                {/* Pagination en haut */}
                {filteredReseaux && filteredReseaux.length > 0 && (
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
                    {filteredReseaux && filteredReseaux.length != 0 ? (
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
                {filteredReseaux && filteredReseaux.length > 0 && (
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
            <div className="">
                <NetworksOffres 
                    networksName={nomReseauChoisi}
                    resetNetwork={resetNetwork}
                />
            </div>
        )
    }
}

export default Networks;