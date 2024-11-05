"use client";
import React, { useEffect, useState } from 'react';
import FicheTechniqueArtisteForm from '@/app/components/Form/Offre/FicheTechniqueArtiste';
import { apiGet, apiPost } from '@/app/services/internalApiClients';

interface DonneesSupplementairesFormProps {
    donneesSupplementaires: {
        ficheTechniqueArtiste: {
            besoinBackline: string;
            besoinEclairage: string;
            besoinEquipements: string;
            besoinScene: string;
            besoinSonorisation: string
        },
        reseau: string[];
        nbReseaux: number;
        genreMusical: string[];
        nbGenresMusicaux: number;
        artiste: string[];
        nbArtistes: number;
    };
    onDonneesSupplementairesChange: (name: string, value: any) => void;
    onFicheTechniqueChange: (name: string, value: string) => void;
}

const DonneesSupplementairesForm: React.FC<DonneesSupplementairesFormProps> = ({
    donneesSupplementaires,
    onDonneesSupplementairesChange,
    onFicheTechniqueChange
}) => {
    const handleDonneesSupplementairesChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        onDonneesSupplementairesChange(name, value);
    };

    const [genresMusicaux, setGenresMusicaux] = useState<Array<{ nomGenreMusical: string }>>([]);
    const [selectedGenres, setSelectedGenres] = useState<string[]>(donneesSupplementaires.genreMusical);

    const [reseaux, setReseaux] = useState<Array<any>>([]);
    const [selectedReseaux, setSelectedReseaux] = useState<string[]>(donneesSupplementaires.reseau);

    const [artistes, setArtistes] = useState<string[]>(donneesSupplementaires.artiste);

    useEffect(() => {
        const fetchGenresMusicaux = async () => {
            try {
                const genres = await apiGet('/genres-musicaux');
                const genresList = JSON.parse(genres.genres_musicaux);
                setGenresMusicaux(genresList);
            } catch (error) {
                console.error("Erreur lors du chargement des genres musicaux :", error);
            }
        };
        
        const fetchReseauUtilisateur = async () => {
            try {
                const data = {
                    username: 'username n° 1' // utiliser localStorage plus tard
                };
                const datasUser = await apiPost('/utilisateur', JSON.parse(JSON.stringify(data)));
                const reseauxListe: Array<any> = JSON.parse(datasUser.utilisateur)[0].membreDesReseaux;
                setReseaux(reseauxListe);
                console.log(reseauxListe);
            } catch (error) {
                console.error("Erreur lors du chargement des données utilisateurs :", error);
            }
        };
        
        fetchGenresMusicaux();
        fetchReseauUtilisateur();
    }, []);

    const handleGenreSelectionChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        const selectedOptions = Array.from(e.target.selectedOptions, option => option.value);

        if (selectedOptions.length <= genresMusicaux.length) {
            setSelectedGenres(selectedOptions);
            onDonneesSupplementairesChange('genreMusical', selectedOptions);
            onDonneesSupplementairesChange('nbGenresMusicaux', selectedOptions.length);
        } else {
            alert(`Vous pouvez sélectionner un maximum de ${genresMusicaux.length} genres.`);
        }
    };

    const handleReseauxSelectionChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        const selectedOptions = Array.from(e.target.selectedOptions, option => option.value);

        if (selectedOptions.length <= reseaux.length) {
            setSelectedReseaux(selectedOptions);
            onDonneesSupplementairesChange('reseau', selectedOptions);
            onDonneesSupplementairesChange('nbReseaux', selectedOptions.length);
        } else {
            alert(`Vous pouvez sélectionner un maximum de ${reseaux.length} réseaux.`);
        }
    };

    const handleArtisteChange = (index: number, value: string) => {
        const updatedArtistes = [...artistes];
        updatedArtistes[index] = value;
        setArtistes(updatedArtistes);
        onDonneesSupplementairesChange('artiste', updatedArtistes);
        onDonneesSupplementairesChange('nbArtistes', updatedArtistes.length);
    };

    const addArtisteField = () => {
        setArtistes([...artistes, ""]);
    };

    const removeArtisteField = (index: number) => {
        const updatedArtistes = artistes.filter((_, i) => i !== index);
        setArtistes(updatedArtistes);
        onDonneesSupplementairesChange('artiste', updatedArtistes);
        onDonneesSupplementairesChange('nbArtistes', updatedArtistes.length);
    };

    return (
        <div className="mx-auto w-full max-w bg-white rounded-lg shadow-md p-8">
            <div>
                <FicheTechniqueArtisteForm
                    ficheTechniqueArtiste={donneesSupplementaires.ficheTechniqueArtiste}
                    onFicheTechniqueChange={onFicheTechniqueChange}
                />
            </div>
            <div className="flex flex-col rounded-lg mb-4">
                <div className="mb-5">
                    <h3 className="text-2xl font-semibold text-[#07074D] mb-4">Artistes Concernés</h3>
                    {artistes.map((artiste, index) => (
                        <div key={index} className="flex items-center mb-2">
                            <input
                                type="text"
                                value={artiste}
                                onChange={(e) => handleArtisteChange(index, e.target.value)}
                                placeholder="Nom de l'artiste"
                                className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                            />
                            <button
                                type="button"
                                onClick={() => removeArtisteField(index)}
                                className="ml-2 text-red-600 hover:text-red-800"
                            >
                                Supprimer
                            </button>
                        </div>
                    ))}
                    <button
                        type="button"
                        onClick={addArtisteField}
                        className="mt-2 w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600"
                    >
                        Ajouter un artiste
                    </button>
                </div>

                <h3 className="text-2xl font-semibold text-[#07074D] mb-4">Réseau et Genre Musical</h3>
                <div className="grid grid-cols-2 gap-4">
                    <div className="flex flex-col">
                        <label htmlFor="reseau" className="text-gray-700">Réseau:</label>
                        <select
                            id="reseau"
                            name="reseau"
                            value={selectedReseaux}
                            onChange={handleReseauxSelectionChange}
                            required
                            multiple
                            className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        >
                            {reseaux.map((reseau, index) => (
                                <option key={index} value={reseau.idReseau.nomReseau}>
                                    {reseau.idReseau.nomReseau}
                                </option>
                            ))}
                        </select>
                        <p className="text-sm text-gray-500 mt-1">
                            Vous pouvez sélectionner jusqu'à {reseaux.length} réseaux.
                        </p>
                    </div>

                    <div className="flex flex-col">
                        <label htmlFor="genreMusical" className="text-gray-700">Genre Musical:</label>
                        <select
                            id="genreMusical"
                            name="genreMusical"
                            value={selectedGenres}
                            onChange={handleGenreSelectionChange}
                            multiple
                            className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        >
                            {genresMusicaux.map((genre, index) => (
                                <option key={index} value={genre.nomGenreMusical}>
                                    {genre.nomGenreMusical}
                                </option>
                            ))}
                        </select>
                        <p className="text-sm text-gray-500 mt-1">
                            Vous pouvez sélectionner jusqu'à {genresMusicaux.length} genres.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default DonneesSupplementairesForm;
