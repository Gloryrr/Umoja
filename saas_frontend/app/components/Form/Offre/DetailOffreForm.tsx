"use client";
import React, { useState } from 'react';

interface DetailOffreFormProps {
    detailOffre : {
        titleOffre: string;
        deadLine: string;
        descrTournee: string;
        dateMinProposee: string;
        dateMaxProposee: string;
        villeVisee: string;
        regionVisee: string;
        placesMin: string;
        placesMax: string;
        nbArtistesConcernes: string;
        nbInvitesConcernes: string;
        liensPromotionnels: string;
    };
    onDetailOffreChange: (name: string, value: string) => void;
}

const DetailOffreForm: React.FC<DetailOffreFormProps> = ({
    detailOffre,
    onDetailOffreChange,
}) => {
    const handleDetailOffreChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        onDetailOffreChange(name, value);
    };

    const [liensPromotionnels, setLiensPromotionnels] = useState<string[]>(['']);

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

    return (
        <div className="flex items-center justify-center">
            <div className="mx-auto w-full max-w bg-white rounded-lg shadow-md p-8">
                    <h3 className="text-2xl font-semibold text-[#07074D] mb-6">Détails de l'Offre</h3>
                    <div className="mb-5">
                        <label htmlFor="titleOffre" className="mb-3 block text-base font-medium text-[#07074D]">Titre de l'Offre:</label>
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
                            value={detailOffre.deadLine}
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
                                value={detailOffre.dateMinProposee}
                                onChange={handleDetailOffreChange}
                                required
                                className="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                            />
                        </div>

                        <div>
                            <label htmlFor="dateMaxProposee" className="mb-3 block text-base font-medium text-[#07074D]">Date Max Proposée:</label>
                            <input
                                type="date"
                                id="dateMaxProposee"
                                name="dateMaxProposee"
                                value={detailOffre.dateMaxProposee}
                                onChange={handleDetailOffreChange}
                                required
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

                    {/* Grouped Ville and Région */}
                    <div className="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <label htmlFor="villeVisee" className="mb-3 block text-base font-medium text-[#07074D]">Ville Visée:</label>
                            <input
                                type="text"
                                id="villeVisee"
                                name="villeVisee"
                                value={detailOffre.villeVisee}
                                onChange={handleDetailOffreChange}
                                required
                                placeholder="Dans quelle ville se déroulera l'offre"
                                className="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                            />
                        </div>

                        <div>
                            <label htmlFor="regionVisee" className="mb-3 block text-base font-medium text-[#07074D]">Région Visée:</label>
                            <input
                                type="text"
                                id="regionVisee"
                                name="regionVisee"
                                value={detailOffre.regionVisee}
                                onChange={handleDetailOffreChange}
                                required
                                placeholder="Dans quelle région se déroulera l'offre"
                                className="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                            />
                        </div>
                    </div>

                    {/* Grouped Places Min and Max */}
                    <div className="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <label htmlFor="placesMin" className="mb-3 block text-base font-medium text-[#07074D]">Places Minimum:</label>
                            <input
                                type="number"
                                id="placesMin"
                                name="placesMin"
                                value={detailOffre.placesMin}
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
                                value={detailOffre.placesMax}
                                onChange={handleDetailOffreChange}
                                required
                                placeholder="Nombre de places maximum"
                                className="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                            />
                        </div>
                    </div>

                    {/* Grouped Nombre Artistes et Invités */}
                    <div className="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <label htmlFor="nbArtistesConcernes" className="mb-3 block text-base font-medium text-[#07074D]">Nombre d'Artistes Concernés:</label>
                            <input
                                type="number"
                                id="nbArtistesConcernes"
                                name="nbArtistesConcernes"
                                value={detailOffre.nbArtistesConcernes}
                                onChange={handleDetailOffreChange}
                                required
                                placeholder="Nombre d'artistes concernés"
                                className="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                            />
                        </div>

                        <div>
                            <label htmlFor="nbInvitesConcernes" className="mb-3 block text-base font-medium text-[#07074D]">Nombre d'Invités Concernés:</label>
                            <input
                                type="number"
                                id="nbInvitesConcernes"
                                name="nbInvitesConcernes"
                                value={detailOffre.nbInvitesConcernes}
                                onChange={handleDetailOffreChange}
                                required
                                placeholder="Nombre d'invités concernés"
                                className="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                            />
                        </div>
                    </div>

                    <div className="mb-5">
                        <label htmlFor="liensPromotionnels" className="mb-3 block text-base font-semibold text-[#07074D]">Liens Promotionnels:</label>
                        {liensPromotionnels.map((lien, index) => (
                            <div key={index} className="flex items-center mb-3">
                                <input
                                    type="url"
                                    id={`liensPromotionnels${index}`}
                                    name="liensPromotionnels"
                                    value={lien}
                                    onChange={(e) => handleLienChange(index, e.target.value)}
                                    required
                                    className="flex-grow rounded-md border border-[#e0e0e0] bg-white py-3 px-4 text-base font-medium text-gray-800 outline-none focus:border-[#6A64F1] focus:shadow-md transition duration-200 ease-in-out"
                                    placeholder="Lien promotionnel de l'artiste"
                                />
                                <button
                                    type="button"
                                    onClick={() => handleRemoveLien(index)}
                                    className="ml-3 bg-red-600 text-white px-4 rounded-md py-2 hover:bg-red-700 transition-colors duration-200 ease-in-out"
                                >
                                    Supprimer
                                </button>
                            </div>
                        ))}
                        <div className="flex justify-center mt-2">
                            <button
                                type="button"
                                onClick={handleAddLien}
                                className="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200 ease-in-out"
                            >
                                Ajouter lien
                            </button>
                        </div>
                    </div>
            </div>
        </div>
    );
};

export default DetailOffreForm;