"use client";
import React, { useState } from 'react';
import ExtrasForm from '@/app/components/Form/Offre/ExtrasForm';
import ConditionsFinancieresForm from '@/app/components/Form/Offre/ConditionsFinancieresForm';
import BudgetEstimatifForm from '@/app/components/Form/Offre/BudgetEstimatifForm';
import DetailOffreForm from '@/app/components/Form/Offre/DetailOffreForm';
import DonneesSupplementairesForm from '@/app/components/Form/Offre/DonneesSupplementairesForm';
import { apiPost } from '@/app/services/internalApiClients';

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
            placesMin: 0,
            placesMax: 0,
            nbArtistesConcernes: 0,
            nbInvitesConcernes: 0,
            liensPromotionnels: ''
        },
        extras: {
            descrExtras: '',
            coutExtras: 0,
            exclusivite: '',
            exception: '',
            ordrePassage: '',
            clausesConfidentialites: ''
        },
        etatOffre: {
            nomEtatOffre: 'INITIAL'
        },
        typeOffre: {
            nomTypeOffre: 'TYPE TOURNEE'
        },
        conditionsFinancieres: {
            minimumGaranti: 0,
            conditionsPaiement: '',
            pourcentageRecette: 0
        },
        budgetEstimatif: {
            cachetArtiste: 0,
            fraisDeplacement: 0,
            fraisHebergement: 0,
            fraisRestauration: 0
        },
        donneesSupplementaires : {
            ficheTechniqueArtiste: {
                besoinBackline: '',
                besoinEclairage: '',
                besoinEquipements: '',
                besoinScene: '',
                besoinSonorisation: ''
            },
            reseau: [],
            nbReseaux: 0,
            genreMusical: [],
            nbGenresMusicaux: 0,
            artiste: [],
            nbArtistes: 0
        },
        utilisateur: {
            username: 'username n° 1', // on utilisera la localStorage après
            contact: 'utilisateur@gmail.com'
        },
    });
    const [offrePostee, setOffrePostee] = useState(false);
    const [messageOffrePostee, setMessageOffrePostee] = useState("");

    const valideFormulaire = async (e: React.FormEvent) => {
        e.preventDefault();
        console.log(formData);
        const dataReponsePostOffre = await apiPost('/offre/create', JSON.parse(JSON.stringify(formData)));
        console.log(dataReponsePostOffre);
        if (JSON.parse(dataReponsePostOffre.offre) != 'null') {
            setOffrePostee(true);
            setMessageOffrePostee("Votre offre a bien été postée !")
        } else {
            setMessageOffrePostee("Une erreur s'est produite durant le post de votre offre, merci de vérifier les erreurs décrites ci-dessus")
        }
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
        console.log(step);
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
            {!offrePostee ? (
                <form onSubmit={valideFormulaire} className="w-full mx-auto shadow-md rounded-lg p-8 space-y-4 font-nunito">
                    <h2 className="text-3xl font-semibold text-center  mb-10">Formulaire d&apos;Offre</h2>
    
                    <div className="mb-8">
                        <div className="flex justify-between mb-2">
                            <span
                                className={`text-sm font-bold inline-block py-2 px-4 rounded-full transition-all duration-300`}
                                id="step1"
                            >
                                Informations de base
                            </span>
                            <span
                                className={`text-sm font-bold inline-block py-2 px-4 rounded-full transition-all duration-300`}
                                id="step2"
                            >
                                Extras
                            </span>
                            <span
                                className={`text-sm font-bold inline-block py-2 px-4 rounded-full transition-all duration-300`}
                                id="step3"
                            >
                                Conditions Financières
                            </span>
                            <span
                                className={`text-sm font-bold inline-block py-2 px-4 rounded-full transition-all duration-300`}
                                id="step4"
                            >
                                Budget Estimatif
                            </span>
                            <span
                                className={`text-sm font-bold inline-block py-2 px-4 rounded-full transition-all duration-300`}
                                id="step5"
                            >
                                Données supplémentaires
                            </span>
                        </div>
                        <div className="overflow-hidden h-2 mb-4 flex text-sm rounded white">
                            <div
                                className="shadow-none flex flex-col text-center whitespace-nowrap justify-center transition-all duration-300"
                                style={{ width: `${(etapeCourante / 5) * 100}%` }}
                            ></div>
                        </div>
                    </div>
    
                    {renderEtapeFormulaire()}
    
                    <div className="flex justify-between mt-8">
                        {etapeCourante > 1 && (
                            <button
                                type="button"
                                onClick={revientEtapePrecedente}
                                className="px-5 py-3 gray-700 rounded-full transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50"
                            >
                                Précédent
                            </button>
                        )}
                        {etapeCourante < 5 && (
                            <button
                                type="button"
                                onClick={accedeEtapeSuivante}
                                className="px-5 py-3 rounded-full transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-opacity-50"
                            >
                                Suivant
                            </button>
                        )}
                        {etapeCourante === 5 && (
                            <button
                                type="submit"
                                className="px-5 py-3  rounded-full transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-opacity-50"
                            >
                                Poster l&apos;offre
                            </button>
                        )}
                    </div>
                </form>
            ) : (
                <p className="text-center text-lg ">{messageOffrePostee}</p>
            )}
        </div>
    );        
};

export default OffreForm;