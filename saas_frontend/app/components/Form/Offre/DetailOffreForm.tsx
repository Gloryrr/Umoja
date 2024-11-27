"use client";
import React, { useState } from 'react';
import { apiGet } from '@/app/services/externalApiClients';
import { Card, Label, TextInput, Textarea, Button } from 'flowbite-react';
import { FiRefreshCw } from "react-icons/fi";

interface DetailOffreFormProps {
    detailOffre : {
        titleOffre: string | null;
        deadLine: string | Date | null;
        descrTournee: string | null;
        dateMinProposee: string | Date | null;
        dateMaxProposee: string | Date | null;
        villeVisee: string | null;
        regionVisee: string | null;
        placesMin: number | null;
        placesMax: number | null;
        nbArtistesConcernes: number | null;
        nbInvitesConcernes: number | null;
        liensPromotionnels: string[];
    };
    onDetailOffreChange: (name: string, value: string | number | string[]) => void;
}

const DetailOffreForm: React.FC<DetailOffreFormProps> = ({
    detailOffre,
    onDetailOffreChange,
}) => {
    const [liensPromotionnels, setLiensPromotionnels] = useState<string[]>(detailOffre.liensPromotionnels || ['']);
    const [placesMin, setPlacesMin] = useState(detailOffre.placesMin);
    const [placesMax, setPlacesMax] = useState(detailOffre.placesMax);

    const handleDetailOffreChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        onDetailOffreChange(name, value);

        if (name === 'deadLine') {
            onDetailOffreChange('deadLine', value);
            if (!detailOffre.dateMinProposee || new Date(detailOffre.dateMinProposee) < new Date(value)) {
                onDetailOffreChange('dateMinProposee', value);
                if (!detailOffre.dateMaxProposee || new Date(detailOffre.dateMaxProposee) < new Date(value)) {
                    onDetailOffreChange('dateMaxProposee', value);
                }
            }
        }
        
        if (name === 'dateMinProposee') {
            onDetailOffreChange('dateMinProposee', value);
            if (!detailOffre.dateMaxProposee || new Date(detailOffre.dateMaxProposee) < new Date(value)) {
                onDetailOffreChange('dateMaxProposee', value);
            }
        }

        if (name === 'placesMin') {
            setPlacesMin(Number(value));
            if (Number(value) > Number(placesMax)) {
                setPlacesMax(Number(value));
                onDetailOffreChange('placesMax', value);
            }
        } else if (name === 'placesMax') {
            setPlacesMax(Number(value));
        }
    };

    const handleUpdateLien = (newLiens: string[]) => {
        setLiensPromotionnels(newLiens);
        onDetailOffreChange('liensPromotionnels', newLiens);
    };
    
    const handleLienChange = (index: number, value: string) => {
        const newLiens = [...liensPromotionnels];
        newLiens[index] = value;
        handleUpdateLien(newLiens);
    };
    
    const handleAddLien = () => {
        handleUpdateLien([...liensPromotionnels, '']);
    };
    
    const handleRemoveLien = (index: number) => {
        const newLiens = liensPromotionnels.filter((_, i) => i !== index);
        handleUpdateLien(newLiens);
    };
    

    const handleCityInputChange = async (e: React.ChangeEvent<HTMLInputElement>) => {
        const { value } = e.target;
        onDetailOffreChange("villeVisee", value);
    
        if (value.length > 2) {
            const correspondancesTrouvees = await apiGet(`https://api-adresse.data.gouv.fr/search/?q=${value}&type=municipality`);
            const region = correspondancesTrouvees.features[0].properties.context.split(", ").pop();
            onDetailOffreChange("regionVisee", region);
        }
    };

    const handleReset = () => {
        onDetailOffreChange("titleOffre", "");
        onDetailOffreChange("deadLine", "");
        onDetailOffreChange("descrTournee", "");
        onDetailOffreChange("dateMinProposee", "");
        onDetailOffreChange("dateMaxProposee", "");
        onDetailOffreChange("villeVisee", "");
        onDetailOffreChange("regionVisee", "");
        onDetailOffreChange("placesMin", "");
        onDetailOffreChange("placesMax", "");
        onDetailOffreChange("nbArtistesConcernes", "");
        onDetailOffreChange("nbInvitesConcernes", "");
        onDetailOffreChange("liensPromotionnels", []);
    };

    // const handleCitySelect = async (city: string) => {
    //     // setSelectedCity(city);
    //     onDetailOffreChange("villeVisee", city);

    //     const correspondancesTrouvees = await apiGet(`https://api-adresse.data.gouv.fr/search/?q=${city}&type=municipality`);
    //     const region = correspondancesTrouvees.features[0].properties.context.split(", ").pop();
    //     onDetailOffreChange("regionVisee", region);
    //     setCitySuggestions([]);
    // };

    return (
        <Card className="shadow-none border-none mx-auto w-full">
            <div className="flex justify-between items-center mb-4">
                <h3 className="text-2xl font-semibold mb-6">Détails de l&apos;Offre</h3>
                <Button
                    color="gray"
                    onClick={handleReset}
                    pill
                    aria-label="Reset"
                    className="flex items-center"
                >
                    <FiRefreshCw className="w-4 h-4" />
                </Button>
            </div>

            <div className="mb-5">
                <Label htmlFor="titleOffre" value="Titre de l'Offre:" />
                <TextInput
                    type="text"
                    id="titleOffre"
                    name="titleOffre"
                    value={detailOffre.titleOffre ?? ""}
                    onChange={handleDetailOffreChange}
                    required
                    placeholder="Indiquer le titre de l'Offre"
                    className="mt-1"
                />
            </div>

            <div className="mb-5">
                <Label htmlFor="deadLine" value="Date de réponse maximale:" />
                <TextInput
                    type="date"
                    id="deadLine"
                    name="deadLine"
                    value={detailOffre.deadLine ? new Date(detailOffre.deadLine).toISOString().split('T')[0] : ""}
                    onChange={handleDetailOffreChange}
                    required
                    className="mt-1"
                />
            </div>

            <div className="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <Label htmlFor="dateMinProposee" value="Date Min Proposée:" />
                    <TextInput
                        type="date"
                        id="dateMinProposee"
                        name="dateMinProposee"
                        value={detailOffre.dateMinProposee ? new Date(detailOffre.dateMinProposee).toISOString().split('T')[0] : ""}
                        onChange={handleDetailOffreChange}
                        required
                        min={detailOffre.dateMinProposee ? new Date(detailOffre.dateMinProposee).toISOString().split('T')[0] : ""}
                        className="mt-1"
                    />
                </div>

                <div>
                    <Label htmlFor="dateMaxProposee" value="Date Max Proposée:" />
                    <TextInput
                        type="date"
                        id="dateMaxProposee"
                        name="dateMaxProposee"
                        value={detailOffre.dateMaxProposee ? new Date(detailOffre.dateMaxProposee).toISOString().split('T')[0] : ""}
                        onChange={handleDetailOffreChange}
                        required
                        min={detailOffre.dateMinProposee ? new Date(detailOffre.dateMinProposee).toISOString().split('T')[0] : ""}
                        className="mt-1"
                    />
                </div>
            </div>

            <div className="mb-5">
                <Label htmlFor="descrTournee" value="Description de la Tournée:" />
                <Textarea
                    id="descrTournee"
                    name="descrTournee"
                    value={detailOffre.descrTournee ?? ""}
                    onChange={handleDetailOffreChange}
                    required
                    placeholder="La description de la tournée"
                    className="mt-1"
                />
            </div>

            <div className="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <Label htmlFor="villeVisee" value="Ville Visée:" />
                    <TextInput
                        type="text"
                        id="villeVisee"
                        name="villeVisee"
                        value={detailOffre.villeVisee ?? ""}
                        onChange={handleCityInputChange}
                        required
                        placeholder="Dans quelle ville se déroulera l'offre"
                        className="mt-1"
                    />
                </div>

                <div>
                    <Label htmlFor="regionVisee" value="Région Visée:" />
                    <TextInput
                        type="text"
                        id="regionVisee"
                        name="regionVisee"
                        value={detailOffre.regionVisee ?? ""}
                        readOnly
                        className="mt-1"
                    />
                </div>
            </div>

            <div className="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <Label htmlFor="placesMin" value="Places Minimum:" />
                    <TextInput
                        type="number"
                        id="placesMin"
                        name="placesMin"
                        value={placesMin ?? ""}
                        onChange={handleDetailOffreChange}
                        required
                        placeholder="Nombre de places minimum"
                        className="mt-1"
                    />
                </div>

                <div>
                    <Label htmlFor="placesMax" value="Places Maximum:" />
                    <TextInput
                        type="number"
                        id="placesMax"
                        name="placesMax"
                        value={placesMax ?? ""}
                        onChange={handleDetailOffreChange}
                        required
                        min={placesMin ?? ""}
                        placeholder="Nombre de places maximum"
                        className="mt-1"
                    />
                </div>
            </div>

            <div className="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <Label htmlFor="nbArtistesConcernes" value="Nombre d'Artistes Concernés:" />
                    <TextInput
                        type="number"
                        id="nbArtistesConcernes"
                        name="nbArtistesConcernes"
                        value={detailOffre.nbArtistesConcernes ?? ""}
                        onChange={handleDetailOffreChange}
                        required
                        placeholder="Nombre d'artistes concernés"
                        className="mt-1"
                    />
                </div>

                <div>
                    <Label htmlFor="nbInvitesConcernes" value="Nombre d'Invités Concernés:" />
                    <TextInput
                        type="number"
                        id="nbInvitesConcernes"
                        name="nbInvitesConcernes"
                        value={detailOffre.nbInvitesConcernes ?? ""}
                        onChange={handleDetailOffreChange}
                        required
                        placeholder="Nombre d'invités concernés"
                        className="mt-1"
                    />
                </div>
            </div>

            <div className="mb-5">
                <h3 className="text-2xl font-semibold mb-4">Liens Promotionnels:</h3>
                {liensPromotionnels.map((lien, index) => (
                    <div key={index} className="flex items-center mb-2">
                        <TextInput
                            type="url"
                            value={lien}
                            onChange={(e) => handleLienChange(index, e.target.value)}
                            required
                            placeholder="Lien promotionnel de l'artiste"
                            className="w-full"
                        />
                        <Button
                            color="failure"
                            onClick={() => handleRemoveLien(index)}
                            className="ml-2"
                        >
                            Supprimer
                        </Button>
                    </div>
                ))}
                <Button
                    onClick={handleAddLien}
                    className="mt-2 w-full"
                >
                    Ajouter un lien
                </Button>
            </div>
        </Card>
    );    
};

export default DetailOffreForm;