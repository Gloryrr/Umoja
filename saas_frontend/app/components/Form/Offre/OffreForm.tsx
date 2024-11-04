"use client";
import React, { useState } from 'react';
import ExtrasForm from '@/app/components/Form/Offre/ExtrasForm';
import ConditionsFinancieresForm from '@/app/components/Form/Offre/ConditionsFinancieresForm';
import BudgetEstimatifForm from '@/app/components/Form/Offre/BudgetEstimatifForm';
import DetailOffreForm from '@/app/components/Form/Offre/DetailOffreForm';
import DonneesSupplementairesForm from '@/app/components/Form/Offre/DonneesSupplementairesForm';

const OffreForm: React.FC = () => {
    const [etapeCourante, setEtapeCourante] = useState(1);
    const [formData, setFormData] = useState({
        detailOffre: {
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
            liensPromotionnels: ''
        },
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
        donneesSupplementaires : {
            ficheTechniqueArtiste: {
                besoinBackline: '',
                besoinEclairage: '',
                besoinEquipements: '',
                besoinScene: '',
                besoinSonorisation: ''
            },
            reseau: '',
            genreMusical: '',
            artiste: ''
        },
        utilisateur: '',
    });

    const handleSectionChange = (section: string, updatedData: any) => {
        setFormData((prevData) => ({
            ...prevData,
            [section]: updatedData
        }));
    };    

    const valideFormulaire = (e: React.FormEvent) => {
        e.preventDefault();
        console.log(formData);
        // ajouter l'appel à l'API REST pour la création    
    };

    const accedeEtapeSuivante = () => {
        if (valideEtape(etapeCourante)) {
            setEtapeCourante(prev => Math.min(prev + 1, 5));
        }
    };

    const revientEtapePrecedente = () => {
        setEtapeCourante(prev => Math.max(prev - 1, 1));
    };

    const valideEtape = (step: number) => {
        return true;
    };

    const renderEtapeFormulaire = () => {
        switch (etapeCourante) {
            case 1:
                return <DetailOffreForm 
                            detailOffre={formData.detailOffre} 
                            onDetailOffreChange={(name, value) =>
                                setFormData((prevData) => ({
                                    ...prevData,
                                    detailOffre: {
                                        ...prevData.detailOffre,
                                        [name]: value
                                    }
                                }))
                            } 
                        />;
            case 2:
                return <ExtrasForm 
                            extras={formData.extras} 
                            onExtrasChange={(name, value) =>
                                setFormData((prevData) => ({
                                    ...prevData,
                                    extras: {
                                        ...prevData.extras,
                                        [name]: value
                                    }
                                }))
                            }
                        />;
            case 3:
                return <ConditionsFinancieresForm 
                            conditionsFinancieres={formData.conditionsFinancieres} 
                            onConditionsFinancieresChange={(name, value) =>
                                setFormData((prevData) => ({
                                    ...prevData,
                                    conditionsFinancieres: {
                                        ...prevData.conditionsFinancieres,
                                        [name]: value
                                    }
                                }))
                            }
                        />;
            case 4:
                return <BudgetEstimatifForm 
                            budgetEstimatif={formData.budgetEstimatif} 
                            onBudgetEstimatifChange={(name, value) =>
                                setFormData((prevData) => ({
                                    ...prevData,
                                    budgetEstimatif: {
                                        ...prevData.budgetEstimatif,
                                        [name]: value
                                    }
                                }))
                            }
                        />;
            case 5:
                return <DonneesSupplementairesForm 
                            donneesSupplementaires={formData.donneesSupplementaires} 
                            onDonneesSupplementairesChange={(name, value) =>
                                setFormData((prevData) => ({
                                    ...prevData,
                                    donneesSupplementaires: {
                                        ...prevData.donneesSupplementaires,
                                        [name]: value
                                    }
                                }))
                            }
                            onFicheTechniqueChange={(name, value) =>
                                setFormData((prevData) => ({
                                    ...prevData,
                                    donneesSupplementaires: {
                                        ...prevData.donneesSupplementaires,
                                        ficheTechniqueArtiste: {
                                            ...prevData.donneesSupplementaires.ficheTechniqueArtiste,
                                            [name]: value
                                        }
                                    }
                                }))
                            }
                        />;
            default:
                return null;
        }
    };
    

    return (
        <div className="mt-10 mb-10 w-[60%] mx-auto">
            <form onSubmit={valideFormulaire} className="w-full mx-auto bg-white shadow-md rounded-lg p-8 space-y-4">
                <h2 className="text-3xl font-semibold text-center text-gray-800 mb-10">Formulaire d'Offre</h2>

                <div className="mb-8">
                    <div className="flex justify-between mb-2">
                        <span className={`text-xs font-bold inline-block py-2 px-4 rounded-full transition-all duration-300 ${0 < etapeCourante ? 'text-white bg-blue-600' : 'text-gray-500 bg-gray-300 opacity-75'}`} id="step1">
                            Informations de base
                        </span>
                        <span className={`text-xs font-bold inline-block py-2 px-4 rounded-full transition-all duration-300 ${1 < etapeCourante ? 'text-white bg-blue-600' : 'text-gray-500 bg-gray-300 opacity-75'}`} id="step2">
                            Extras
                        </span>
                        <span className={`text-xs font-bold inline-block py-2 px-4 rounded-full transition-all duration-300 ${2 < etapeCourante ? 'text-white bg-blue-600' : 'text-gray-500 bg-gray-300 opacity-75'}`} id="step3">
                            Conditions Financières
                        </span>
                        <span className={`text-xs font-bold inline-block py-2 px-4 rounded-full transition-all duration-300 ${3 < etapeCourante ? 'text-white bg-blue-600' : 'text-gray-500 bg-gray-300 opacity-75'}`} id="step4">
                            Budget Estimatif
                        </span>
                        <span className={`text-xs font-bold inline-block py-2 px-4 rounded-full transition-all duration-300 ${4 < etapeCourante ? 'text-white bg-blue-600' : 'text-gray-500 bg-gray-300 opacity-75'}`} id="step5">
                            Données supplémentaires
                        </span>
                    </div>
                    <div className="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                        <div className={`shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-600 transition-all duration-300`} style={{ width: `${(etapeCourante / 5) * 100}%` }}></div>
                    </div>
                </div>

                {renderEtapeFormulaire()}

                <div className="flex justify-between mt-8">
                    {etapeCourante > 1 && (
                        <button
                            type="button"
                            onClick={revientEtapePrecedente}
                            className="px-5 py-3 bg-gray-300 text-gray-800 rounded-lg transition-colors duration-300 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50"
                        >
                            Précédent
                        </button>
                    )}
                    {etapeCourante < 5 && (
                        <button
                            type="button"
                            onClick={accedeEtapeSuivante}
                            className="px-5 py-3 bg-blue-500 text-white rounded-lg transition-colors duration-300 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50"
                        >
                            Suivant
                        </button>
                    )}
                    {etapeCourante === 5 && (
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