"use client";
import React, { useEffect, useState } from 'react';
import FicheTechniqueArtisteForm from '@/app/components/Form/Offre/FicheTechniqueArtiste';
import { apiGet, apiPost } from '@/app/services/internalApiClients';
import {TextInput, Label, Select, Button, Card} from 'flowbite-react';

interface DonneesSupplementairesFormProps {
    donneesSupplementaires: {
        ficheTechniqueArtiste: {
            besoinBackline: string;
            besoinEclairage: string;
            besoinEquipements: string;
            besoinScene: string;
            besoinSonorisation: string;
        };
        reseau: string[];
        nbReseaux: number;
        genreMusical: string[];
        nbGenresMusicaux: number;
        artiste: string[];
        nbArtistes: number;
    };
    onDonneesSupplementairesChange: (name: string, value: string|string[]|number) => void;
    onFicheTechniqueChange: (name: string, value: string) => void;
}

const DonneesSupplementairesForm: React.FC<DonneesSupplementairesFormProps> = ({
    donneesSupplementaires,
    onDonneesSupplementairesChange,
    onFicheTechniqueChange
}) => {
    const [genresMusicaux, setGenresMusicaux] = useState<Array<{ nomGenreMusical: string }>>([]);
    const [selectedGenres, setSelectedGenres] = useState<string[]>(donneesSupplementaires.genreMusical);

    const [reseaux, setReseaux] = useState<Array<{ idReseau: { nomReseau: string } }>>([]);
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
                const reseauxListe: Array<{ idReseau: { nomReseau: string } }> = JSON.parse(datasUser.utilisateur)[0].membreDesReseaux;
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
        <Card className="mx-auto w-full p-8 rounded-lg">
            {/* Formulaire de la fiche technique */}
            <div>
                <FicheTechniqueArtisteForm
                    ficheTechniqueArtiste={donneesSupplementaires.ficheTechniqueArtiste}
                    onFicheTechniqueChange={handleArtisteChange}
                />
            </div>

            {/* Section des artistes concernés */}
            <div className="flex flex-col rounded-lg mb-4">
                <h3 className="text-2xl font-semibold mb-4">Artistes Concernés</h3>
                {artistes.map((artiste, index) => (
                    <div key={index} className="flex items-center mb-2">
                        <TextInput
                            type="text"
                            value={artiste}
                            onChange={(e) => handleArtisteChange(index, e.target.value)}
                            placeholder="Nom de l'artiste"
                        />
                        <Button color="failure" onClick={() => removeArtisteField(index)} size="sm" className="ml-2">
                            Supprimer
                        </Button>
                    </div>
                ))}
                <Button color="info" onClick={addArtisteField} className="mt-2 w-full">
                    Ajouter un artiste
                </Button>
            </div>

            {/* Section Réseau et Genre Musical */}
            <div className="flex flex-col rounded-lg mb-4">
                <h3 className="text-2xl font-semibold mb-4">Réseau et Genre Musical</h3>
                <div className="grid grid-cols-2 gap-4">
                    {/* Sélection des réseaux */}
                    <div className="flex flex-col">
                        <Label htmlFor="reseau" value="Réseau" />
                        <Select
                            id="reseau"
                            name="reseau"
                            value={selectedReseaux}
                            onChange={handleReseauxSelectionChange}
                            multiple
                        >
                            {reseaux.map((reseau, index) => (
                                <option key={index} value={reseau.idReseau.nomReseau}>
                                    {reseau.idReseau.nomReseau}
                                </option>
                            ))}
                        </Select>
                        <p className="text-sm mt-1">
                            Vous pouvez sélectionner jusqu'à {reseaux.length} réseaux.
                        </p>
                    </div>

                    {/* Sélection des genres musicaux */}
                    <div className="flex flex-col">
                        <Label htmlFor="genreMusical" value="Genre Musical" />
                        <Select
                            id="genreMusical"
                            name="genreMusical"
                            value={selectedGenres}
                            onChange={handleGenreSelectionChange}
                            multiple
                        >
                            {genresMusicaux.map((genre, index) => (
                                <option key={index} value={genre.nomGenreMusical}>
                                    {genre.nomGenreMusical}
                                </option>
                            ))}
                        </Select>
                        <p className="text-sm mt-1">
                            Vous pouvez sélectionner jusqu'à {genresMusicaux.length} genres musicaux.
                        </p>
                    </div>
                </div>
            </div>
        </Card>
    );
};

export default DonneesSupplementairesForm;
