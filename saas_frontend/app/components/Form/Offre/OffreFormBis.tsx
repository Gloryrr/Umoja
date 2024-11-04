"use client";
import React, { useState } from 'react';
import ExtrasForm from '@/app/components/Form/Offre/ExtrasForm';
import ConditionsFinancieresForm from '@/app/components/Form/Offre/ConditionFinancieresForm';
import BudgetEstimatifForm from '@/app/components/Form/Offre/BudgetEstimatifForm';
import FicheTechniqueArtisteForm from '@/app/components/Form/Offre/FicheTechniqueArtiste';

const OffreForm: React.FC = () => {
    const [currentStep, setCurrentStep] = useState(1);
    const [formData, setFormData] = useState({
        titleOffre: '',
        deadLine: '',
        descrTournee: '',
        dateMinProposee: '',
        dateMaxProposee: '',
        villeVisee: '',
        regionVisee: '',
        placesMin: '',
        placesMax: '',
        nbArtistesConcernes: '',
        nbInvitesConcernes: '',
        liensPromotionnels: '',
        extras: {
            descrExtras: '',
            coutExtras: '',
            exclusivite: '',
            exception: '',
            ordrePassage: '',
            clausesConfidentialites: ''
        },
        etatOffre: '',
        typeOffre: '',
        conditionsFinancieres: {
            minimumGaranti: '',
            conditionsPaiement: '',
            pourcentageRecette: ''
        },
        budgetEstimatif: {
            cachetArtiste: '',
            fraisDeplacement: '',
            fraisHebergement: '',
            fraisRestauration: ''
        },
        ficheTechniqueArtiste: {
            besoinBackline: '',
            besoinEclairage: '',
            besoinEquipements: '',
            besoinScene: '',
            besoinSonorisation: ''
        },
        utilisateur: '',
        reseau: '',
        genreMusical: '',
        artiste: ''
    });
    const [liensPromotionnels, setLiensPromotionnels] = useState<string[]>(['']);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: value
        });
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

    const handleExtrasChange = (e: React.ChangeEvent<HTMLInputElement> | React.ChangeEvent<HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        setFormData((prevData) => ({
            ...prevData,
            extras: {
                ...prevData.extras,
                [name]: value
            }
        }));
    };

    // const handleRemoveExtras = (index: number) => {
    //     const newExtras = { ...formData.extras };
    //     delete newExtras[index];
    //     setFormData((prevData) => ({
    //         ...prevData,
    //         extras: newExtras
    //     }));
    // };

    const handleConditionsFinancieresChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setFormData((prevData) => ({
            ...prevData,
            conditionsFinancieres: {
                ...prevData.conditionsFinancieres,
                [name]: value
            }
        }));
    };

    const handleBudgetEstimatifChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setFormData((prevData) => ({
            ...prevData,
            budgetEstimatif: {
                ...prevData.budgetEstimatif,
                [name]: value
            }
        }));
    };

    const handleFicheTechniqueArtisteChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setFormData((prevData) => ({
            ...prevData,
            ficheTechniqueArtiste: {
                ...prevData.ficheTechniqueArtiste,
                [name]: value
            }
        }));
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        console.log("Création de l'offre:", { ...formData, liensPromotionnels });
    };

    const handleNext = () => {
        if (validateStep(currentStep)) {
            setCurrentStep(prev => Math.min(prev + 1, 7));
        }
    };

    const handlePrev = () => {
        setCurrentStep(prev => Math.max(prev - 1, 1));
    };

    const validateStep = (step: number) => {
        // Logic for validation based on the current step
        return true; // Assume valid for now
    };

    const renderStep = () => {
        switch (currentStep) {
            case 1:
                return (
                    <div className="flex items-center justify-center">
                        <div className="mx-auto w-full max-w bg-white rounded-lg shadow-md p-8">
                            <form>
                                <h3 className="text-2xl font-semibold text-[#07074D] mb-6">Détails de l'Offre</h3>
                                <div className="mb-5">
                                    <label htmlFor="titleOffre" className="mb-3 block text-base font-medium text-[#07074D]">Titre de l'Offre:</label>
                                    <input
                                        type="text"
                                        id="titleOffre"
                                        name="titleOffre"
                                        value={formData.titleOffre}
                                        onChange={handleChange}
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
                                        value={formData.deadLine}
                                        onChange={handleChange}
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
                                            value={formData.dateMinProposee}
                                            onChange={handleChange}
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
                                            value={formData.dateMaxProposee}
                                            onChange={handleChange}
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
                                        value={formData.descrTournee}
                                        onChange={handleChange}
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
                                            value={formData.villeVisee}
                                            onChange={handleChange}
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
                                            value={formData.regionVisee}
                                            onChange={handleChange}
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
                                            value={formData.placesMin}
                                            onChange={handleChange}
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
                                            value={formData.placesMax}
                                            onChange={handleChange}
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
                                            value={formData.nbArtistesConcernes}
                                            onChange={handleChange}
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
                                            value={formData.nbInvitesConcernes}
                                            onChange={handleChange}
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
                            </form>
                        </div>
                    </div>
                );
            case 2:
                return (
                    <div>
                        <ExtrasForm 
                            extrasData={formData.extras} 
                            onChange={handleExtrasChange} 
                        />
                    </div>
                );
            case 3:
                return (
                    <div>
                        <ConditionsFinancieresForm
                            conditionsFinancieresData={formData.conditionsFinancieres}
                            onChange={handleConditionsFinancieresChange}
                        />
                    </div>
                );
            case 4:
                return (
                    <div>
                        <BudgetEstimatifForm
                            budgetEstimatifData={formData.budgetEstimatif}
                            onChange={handleBudgetEstimatifChange}
                        />
                    </div>
                );
            case 5:
                return (
                    <div className="mx-auto w-full max-w bg-white rounded-lg shadow-md p-8">
                        <div>
                            <FicheTechniqueArtisteForm
                                ficheTechniqeArtisteData={formData.ficheTechniqueArtiste}
                                onChange={handleFicheTechniqueArtisteChange}
                            />
                        </div>
                        <div className="flex flex-col rounded-lg mb-4">
                            <div className="mb-5">
                                <h3 className="text-2xl font-semibold text-[#07074D] mb-4">Artiste Concerné</h3>
                                <div className="flex flex-col">
                                    <label htmlFor="artiste" className="text-gray-700">Artiste:</label>
                                    <input
                                        type="text"
                                        id="artiste"
                                        name="artiste"
                                        value={formData.artiste}
                                        onChange={handleChange}
                                        required
                                        placeholder="L'artiste concerné par l'offre"
                                        className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                    />
                                </div>
                            </div>

                            <h3 className="text-2xl font-semibold text-[#07074D] mb-4">Réseau et Genre Musical</h3>
                            <div className="grid grid-cols-2 gap-4">
                                <div className="flex flex-col">
                                    <label htmlFor="reseau" className="text-gray-700">Réseau:</label>
                                    <input
                                        type="text"
                                        id="reseau"
                                        name="reseau"
                                        value={formData.reseau}
                                        onChange={handleChange}
                                        required
                                        placeholder="Les réseaux sur lesquels vous posterez votre offre"
                                        className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                    />
                                </div>

                                <div className="flex flex-col">
                                    <label htmlFor="genreMusical" className="text-gray-700">Genre Musical:</label>
                                    <input
                                        type="text"
                                        id="genreMusical"
                                        name="genreMusical"
                                        value={formData.genreMusical}
                                        onChange={handleChange}
                                        required
                                        placeholder="Le genre musical de l'offre"
                                        className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                );
            default:
                return null;
        }
    };

    return (
        <div className="mt-10 mb-10 w-[60%] mx-auto">
            <form onSubmit={handleSubmit} className="w-full mx-auto bg-white shadow-md rounded-lg p-8 space-y-4">
                <h2 className="text-3xl font-semibold text-center text-gray-800 mb-10">Formulaire d'Offre</h2>

                <div className="mb-8">
                    <div className="flex justify-between mb-2">
                        <span className={`text-xs font-bold inline-block py-2 px-4 rounded-full transition-all duration-300 ${0 < currentStep ? 'text-white bg-blue-600' : 'text-gray-500 bg-gray-300 opacity-75'}`} id="step1">
                            Informations de base
                        </span>
                        <span className={`text-xs font-bold inline-block py-2 px-4 rounded-full transition-all duration-300 ${1 < currentStep ? 'text-white bg-blue-600' : 'text-gray-500 bg-gray-300 opacity-75'}`} id="step2">
                            Extras
                        </span>
                        <span className={`text-xs font-bold inline-block py-2 px-4 rounded-full transition-all duration-300 ${2 < currentStep ? 'text-white bg-blue-600' : 'text-gray-500 bg-gray-300 opacity-75'}`} id="step3">
                            Conditions Financières
                        </span>
                        <span className={`text-xs font-bold inline-block py-2 px-4 rounded-full transition-all duration-300 ${3 < currentStep ? 'text-white bg-blue-600' : 'text-gray-500 bg-gray-300 opacity-75'}`} id="step4">
                            Budget Estimatif
                        </span>
                        <span className={`text-xs font-bold inline-block py-2 px-4 rounded-full transition-all duration-300 ${4 < currentStep ? 'text-white bg-blue-600' : 'text-gray-500 bg-gray-300 opacity-75'}`} id="step5">
                            Données optionnelles
                        </span>
                    </div>
                    <div className="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                        <div className={`shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-600 transition-all duration-300`} style={{ width: `${(currentStep / 5) * 100}%` }}></div>
                    </div>
                </div>

                {renderStep()}

                <div className="flex justify-between mt-8">
                    {currentStep > 1 && (
                        <button
                            type="button"
                            onClick={handlePrev}
                            className="px-5 py-3 bg-gray-300 text-gray-800 rounded-lg transition-colors duration-300 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50"
                        >
                            Précédent
                        </button>
                    )}
                    {currentStep < 5 && (
                        <button
                            type="button"
                            onClick={handleNext}
                            className="px-5 py-3 bg-blue-500 text-white rounded-lg transition-colors duration-300 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50"
                        >
                            Suivant
                        </button>
                    )}
                    {currentStep === 5 && (
                        <button
                            type="submit"
                            className="px-5 py-3 bg-blue-500 text-white rounded-lg transition-colors duration-300 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50"
                        >
                            Poster l'offre
                        </button>
                    )}
                </div>
            </form>
        </div>
    );
};

export default OffreForm;