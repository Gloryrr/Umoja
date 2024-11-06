"use client";
import React, { useState } from 'react';
import { apiGet } from '@/app/services/externalApiClients';

interface Feature {
    properties: {
        city: string;
    };
}

interface DetailOffreFormProps {
    detailOffre : {
        titleOffre: string;
        deadLine: string;
        descrTournee: string;
        dateMinProposee: string;
        dateMaxProposee: string;
        villeVisee: string;
        regionVisee: string;
        placesMin: number;
        placesMax: number;
        nbArtistesConcernes: number;
        nbInvitesConcernes: number;
        liensPromotionnels: string;
    };
    onDetailOffreChange: (name: string, value: string | number) => void;
}

const DetailOffreForm: React.FC<DetailOffreFormProps> = ({
    detailOffre,
    onDetailOffreChange,
}) => {
    const [liensPromotionnels, setLiensPromotionnels] = useState<string[]>(['']);
    const [citySuggestions, setCitySuggestions] = useState<string[]>([]);
    const [placesMin, setPlacesMin] = useState(detailOffre.placesMin);
    const [placesMax, setPlacesMax] = useState(detailOffre.placesMax);

    const dateParDefaut = new Date().toISOString().split('T')[0];

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

    const handleLienChange = (index: number, value: string) => {
        const newLiens = [...liensPromotionnels];
        newLiens[index] = value;
        setLiensPromotionnels(newLiens);
    };

    const handleAddLien = () => {
        setLiensPromotionnels([...liensPromotionnels, '']);
    };

    const handleRemoveLien = (index: number) => {
        const newLiens = liensPromotionnels.filter((_, i) => i !== index);
        setLiensPromotionnels(newLiens);
    };

    const handleCityInputChange = async (e: React.ChangeEvent<HTMLInputElement>) => {
        const { value } = e.target;
        onDetailOffreChange("villeVisee", value);
    
        if (value.length > 2) {
            const correspondancesTrouvees = await apiGet(`https://api-adresse.data.gouv.fr/search/?q=${value}&type=municipality`);
            setCitySuggestions(
                correspondancesTrouvees.features.map((feature: Feature) => feature.properties.city)
            );
        } else {
            setCitySuggestions([]);
        }
    };

    const handleCitySelect = async (city: string) => {
        // setSelectedCity(city);
        onDetailOffreChange("villeVisee", city);

        const correspondancesTrouvees = await apiGet(`https://api-adresse.data.gouv.fr/search/?q=${city}&type=municipality`);
        const region = correspondancesTrouvees.features[0].properties.context.split(", ").pop();
        onDetailOffreChange("regionVisee", region);
        setCitySuggestions([]);
    };

    return (
        <div className="flex items-center justify-center">
            <div className="mx-auto w-full max-w bg-white rounded-lg shadow-md p-8">
                <h3 className="text-2xl font-semibold text-[#07074D] mb-6">Détails de l&apos;Offre</h3>
                <div className="mb-5">
                    <label htmlFor="titleOffre" className="mb-3 block text-base font-medium text-[#07074D]">Titre de l&apos;Offre:</label>
                    <input
                        type="text"
                        id="titleOffre"
                        name="titleOffre"
                        value={detailOffre.titleOffre}
                        onChange={handleDetailOffreChange}
                        required
                        placeholder="Indiquer le titre de l'Offre"
                        className="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                    />
                </div>

                <div className="mb-5">
                    <label htmlFor="deadLine" className="mb-3 block text-base font-medium text-[#07074D]">Date de réponse maximale:</label>
                    <input
                        type="date"
                        id="deadLine"
                        name="deadLine"
                        value={detailOffre.deadLine || dateParDefaut}
                        onChange={handleDetailOffreChange}
                        required
                        className="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                    />
                </div>

                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="dateMinProposee" className="mb-3 block text-base font-medium text-[#07074D]">Date Min Proposée:</label>
                        <input
                            type="date"
                            id="dateMinProposee"
                            name="dateMinProposee"
                            value={detailOffre.dateMinProposee || dateParDefaut}
                            onChange={handleDetailOffreChange}
                            required
                            min={detailOffre.deadLine}
                            className="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>

                    <div>
                        <label htmlFor="dateMaxProposee" className="mb-3 block text-base font-medium text-[#07074D]">Date Max Proposée:</label>
                        <input
                            type="date"
                            id="dateMaxProposee"
                            name="dateMaxProposee"
                            value={detailOffre.dateMaxProposee || dateParDefaut}
                            onChange={handleDetailOffreChange}
                            required
                            min={detailOffre.dateMinProposee}
                            className="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                </div>

                <div className="mb-5">
                    <label htmlFor="descrTournee" className="mb-3 block text-base font-medium text-[#07074D]">Description de la Tournée:</label>
                    <textarea
                        id="descrTournee"
                        name="descrTournee"
                        value={detailOffre.descrTournee}
                        onChange={handleDetailOffreChange}
                        required
                        placeholder='La description de la tournée'
                        className="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                    />
                </div>

                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="villeVisee" className="mb-3 block text-base font-medium text-[#07074D]">Ville Visée:</label>
                        <input
                            type="text"
                            id="villeVisee"
                            name="villeVisee"
                            value={detailOffre.villeVisee}
                            onChange={handleCityInputChange}
                            required
                            placeholder="Dans quelle ville se déroulera l'offre"
                            className="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                        {citySuggestions.length > 0 && (
                            <ul className="border border-gray-300 mt-1 rounded-md">
                                {citySuggestions.map((city, index) => (
                                    <li
                                        key={index}
                                        onClick={() => handleCitySelect(city)}
                                        className="px-4 py-2 cursor-pointer hover:bg-gray-100"
                                    >
                                        {city}
                                    </li>
                                ))}
                            </ul>
                        )}
                    </div>

                    <div>
                        <label htmlFor="regionVisee" className="mb-3 block text-base font-medium text-[#07074D]">Région Visée:</label>
                        <input
                            type="text"
                            id="regionVisee"
                            name="regionVisee"
                            value={detailOffre.regionVisee}
                            readOnly
                            className="w-full rounded-md border border-[#e0e0e0] bg-gray-100 py-3 px-6 text-base font-medium text-[#6B7280] outline-none"
                        />
                    </div>
                </div>

                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="placesMin" className="mb-3 block text-base font-medium text-[#07074D]">Places Minimum:</label>
                        <input
                            type="number"
                            id="placesMin"
                            name="placesMin"
                            value={placesMin || 0}
                            onChange={handleDetailOffreChange}
                            required
                            placeholder="Nombre de places minimum"
                            className="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>

                    <div>
                        <label htmlFor="placesMax" className="mb-3 block text-base font-medium text-[#07074D]">Places Maximum:</label>
                        <input
                            type="number"
                            id="placesMax"
                            name="placesMax"
                            value={placesMax || 0}
                            onChange={handleDetailOffreChange}
                            required
                            min={placesMin}
                            placeholder="Nombre de places maximum"
                            className="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                </div>

                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="nbArtistesConcernes" className="mb-3 block text-base font-medium text-[#07074D]">Nombre d&apos;Artistes Concernés:</label>
                        <input
                            type="number"
                            id="nbArtistesConcernes"
                            name="nbArtistesConcernes"
                            value={detailOffre.nbArtistesConcernes || 0}
                            onChange={handleDetailOffreChange}
                            required
                            placeholder="Nombre d'artistes concernés"
                            className="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>

                    <div>
                        <label htmlFor="nbInvitesConcernes" className="mb-3 block text-base font-medium text-[#07074D]">Nombre d&apos;Invités Concernés:</label>
                        <input
                            type="number"
                            id="nbInvitesConcernes"
                            name="nbInvitesConcernes"
                            value={detailOffre.nbInvitesConcernes || 0}
                            onChange={handleDetailOffreChange}
                            required
                            placeholder="Nombre d'invités concernés"
                            className="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                </div>

                <div className="flex flex-col rounded-lg">
                    <div>
                        <h3 className="text-2xl font-semibold text-[#07074D] mb-4">Liens Promotionnels:</h3>
                        {liensPromotionnels.map((lien, index) => (
                            <div key={index} className="flex items-center mb-2">
                                <input
                                    type="url"
                                    value={lien}
                                    onChange={(e) => handleLienChange(index, e.target.value)}
                                    required
                                    placeholder="Lien promotionnel de l'artiste"
                                    className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                />
                                <button
                                    type="button"
                                    onClick={() => handleRemoveLien(index)}
                                    className="ml-2 text-red-600 hover:text-red-800"
                                >
                                    Supprimer
                                </button>
                            </div>
                        ))}
                        <button
                            type="button"
                            onClick={handleAddLien}
                            className="mt-2 w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600"
                        >
                            Ajouter un lien
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default DetailOffreForm;