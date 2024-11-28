"use client";
import React, { useState } from 'react';
import { Accordion, Button, Alert, Timeline } from 'flowbite-react';
import ExtrasForm from '@/app/components/Form/Offre/ExtrasForm';
import ConditionsFinancieresForm from '@/app/components/Form/Offre/ConditionsFinancieresForm';
import BudgetEstimatifForm from '@/app/components/Form/Offre/BudgetEstimatifForm';
import DetailOffreForm from '@/app/components/Form/Offre/DetailOffreForm';
import DonneesSupplementairesForm from '@/app/components/Form/Offre/DonneesSupplementairesForm';
import FicheTechniqueArtisteForm from '@/app/components/Form/Offre/FicheTechniqueArtiste';
import InfoAdditionnelAlert from '@/app/components/Alerte/InfoAdditionnelAlerte';
import { apiPost } from '@/app/services/internalApiClients';
import { HiInformationCircle } from "react-icons/hi";
import { FormData } from '@/app/types/FormDataType';

const OffreForm: React.FC = () => {
    const dateParDefaut = new Date().toISOString().split('T')[0] as string;
    const [formData, setFormData] = useState<FormData>({
        detailOffre: {
            titleOffre: null,
            deadLine: dateParDefaut,
            descrTournee: null,
            dateMinProposee: dateParDefaut,
            dateMaxProposee: dateParDefaut,
            villeVisee: null,
            regionVisee: null,
            placesMin: null,
            placesMax: null,
            nbArtistesConcernes: null,
            nbInvitesConcernes: null,
            liensPromotionnels: []
        },
        extras: {
            descrExtras: null,
            coutExtras: null,
            exclusivite: null,
            exception: null,
            ordrePassage: null,
            clausesConfidentialites: null
        },
        etatOffre: {
            nomEtatOffre: ""
        },
        typeOffre: {
            nomTypeOffre: ""
        },
        conditionsFinancieres: {
            minimumGaranti: null,
            conditionsPaiement: null,
            pourcentageRecette: null
        },
        budgetEstimatif: {
            cachetArtiste: null,
            fraisDeplacement: null,
            fraisHebergement: null,
            fraisRestauration: null
        },
        ficheTechniqueArtiste: {
            besoinBackline: null,
            besoinEclairage: null,
            besoinEquipements: null,
            besoinScene: null,
            besoinSonorisation: null
        },
        donneesSupplementaires: {
            reseau: [],
            nbReseaux: null,
            genreMusical: [],
            nbGenresMusicaux: null,
            artiste: [],
            nbArtistes: null
        },
        utilisateur: {
            username : typeof window !== 'undefined' ? localStorage.getItem('username') : ""
        }
    });

    const [offrePostee, setOffrePostee] = useState(false);
    const [messageOffrePostee, setMessageOffrePostee] = useState("");
    const [typeMessage, setTypeMessage] = useState<"success" | "error">("success");
    const [offreId, setOffreId] = useState("");
    const [description, setDescription] = useState("");

    const valideFormulaire = async (e: React.FormEvent) => {
        e.preventDefault();
        try {
            console.log(JSON.parse(JSON.stringify(formData)));
            const offrePostee = await apiPost('/offre/create', JSON.parse(JSON.stringify(formData)));
            setOffreId(JSON.parse(offrePostee.offre).id);
            setTypeMessage("success");
            setDescription("Cliquez sur 'Voir plus' pour accéder aux détails de l'offre.");
            setMessageOffrePostee("Votre offre a bien été postée !");
            setOffrePostee(true);   
        } catch (error) {
            setTypeMessage("error");
            setMessageOffrePostee("Une erreur s'est produite durant le post de votre offre.");
            setOffrePostee(true);
            throw new Error("Erreur lors du post de l'offre :", error as Error);
        }
    };

    const checkInformationsDeBase = () => {
        const {
            titleOffre,
            deadLine,
            descrTournee,
            dateMinProposee,
            dateMaxProposee,
            villeVisee,
            regionVisee,
            placesMin,
            placesMax,
            nbArtistesConcernes,
            nbInvitesConcernes,
            liensPromotionnels
        } = formData.detailOffre;
        return !!(titleOffre && 
            deadLine && 
            descrTournee && 
            dateMinProposee && 
            dateMaxProposee && 
            villeVisee && 
            regionVisee && 
            placesMin != null && placesMin > 0 && 
            placesMax != null && placesMax > 0 &&
            nbArtistesConcernes != null && nbArtistesConcernes > 0 &&
            nbInvitesConcernes != null && nbInvitesConcernes > 0 &&
            liensPromotionnels.length > 0);
    };

    const checkExtras = () => {
        const {
            descrExtras,
            coutExtras,
            exclusivite,
            exception,
            ordrePassage,
            clausesConfidentialites 
        } = formData.extras;
        return !!(descrExtras && 
            coutExtras != null && 
            coutExtras > 0 && 
            exclusivite && 
            exception && 
            ordrePassage && 
            clausesConfidentialites);
    };

    const checkConditionsFinancieres = () => {
        const {
            minimumGaranti,
            conditionsPaiement,
            pourcentageRecette
        } = formData.conditionsFinancieres;
        return !!(minimumGaranti != null && minimumGaranti > 0 && conditionsPaiement && pourcentageRecette != null && pourcentageRecette > 0);
    };

    const checkBudgetEstimatif = () => {
        const {
            cachetArtiste,
            fraisDeplacement,
            fraisHebergement,
            fraisRestauration
        } = formData.budgetEstimatif;
        return !!(cachetArtiste != null && cachetArtiste > 0 && 
            fraisDeplacement != null && fraisDeplacement > 0 && 
            fraisHebergement != null && fraisHebergement > 0 && 
            fraisRestauration != null && fraisRestauration > 0);
    };

    const checkFicheTechniqueArtiste = () => {
        const {
            besoinBackline,
            besoinEclairage,
            besoinEquipements,
            besoinScene,
            besoinSonorisation
        } = formData.ficheTechniqueArtiste;
        return !!(besoinBackline && besoinEclairage && besoinEquipements && besoinScene && besoinSonorisation);
    };

    const checkDonneesSupplementaires = () => {
        const {
            reseau,
            nbReseaux,
            genreMusical,
            nbGenresMusicaux,
            artiste,
            nbArtistes
        } = formData.donneesSupplementaires;
        return reseau.length > 0 && 
            nbReseaux != null && nbReseaux > 0 && 
            genreMusical.length > 0 && 
            nbGenresMusicaux != null && nbGenresMusicaux > 0 && 
            artiste.length > 0 && 
            nbArtistes != null && nbArtistes > 0;
    };

    const getPointColor = (isValid: boolean) => {
        return isValid ? 'bg-green-500' : 'bg-red-500';
    };

    return (
        <div className="w-full flex items-start justify-center">
            <div className="m-20 w-[55%]">
                {offrePostee && (
                    <Alert
                        color={typeMessage === "success" ? "green" : "failure"}
                        onDismiss={() => setOffrePostee(false)}
                        icon={HiInformationCircle}
                        className="mb-5"
                        additionalContent={
                            <InfoAdditionnelAlert
                                isSuccess={typeMessage === "success"}
                                description={description}
                                offreId={offreId}
                                onDismiss={() => setOffrePostee(false)}
                            />
                        }
                    >
                        <span className='font-medium'>Info alerte ! </span>{messageOffrePostee}
                    </Alert>
                )}
                <form onSubmit={valideFormulaire} className="w-full mx-auto rounded-lg space-y-4 font-nunito">
                    <h2 className="text-3xl font-semibold text-center mb-10">Formulaire d&apos;Offre</h2>
                    <Accordion collapseAll>
                        <Accordion.Panel>
                            <Accordion.Title>Informations de base</Accordion.Title>
                            <Accordion.Content className='p-0'>
                                <DetailOffreForm
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
                                />
                            </Accordion.Content>
                        </Accordion.Panel>

                        <Accordion.Panel>
                            <Accordion.Title>Extras</Accordion.Title>
                            <Accordion.Content className='p-0'>
                                <ExtrasForm
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
                                />
                            </Accordion.Content>
                        </Accordion.Panel>

                        <Accordion.Panel>
                            <Accordion.Title>Conditions Financières</Accordion.Title>
                            <Accordion.Content className='p-0'>
                                <ConditionsFinancieresForm
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
                                />
                            </Accordion.Content>
                        </Accordion.Panel>

                        <Accordion.Panel>
                            <Accordion.Title>Budget Estimatif</Accordion.Title>
                            <Accordion.Content className='p-0'>
                                <BudgetEstimatifForm
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
                                />
                            </Accordion.Content>
                        </Accordion.Panel>

                        <Accordion.Panel>
                            <Accordion.Title>Fiche technique de l&apos;artiste</Accordion.Title>
                            <Accordion.Content className='p-0'>
                                <FicheTechniqueArtisteForm
                                    ficheTechniqueArtiste={formData.ficheTechniqueArtiste}
                                    onFicheTechniqueChange={(name, value) =>
                                        setFormData((prevData) => ({
                                            ...prevData,
                                            ficheTechniqueArtiste: {
                                                ...prevData.ficheTechniqueArtiste,
                                                [name]: value
                                            }
                                        }))
                                    }
                                />
                            </Accordion.Content>
                        </Accordion.Panel>

                        <Accordion.Panel>
                            <Accordion.Title>Données Supplémentaires</Accordion.Title>
                            <Accordion.Content className='p-0'>
                                <DonneesSupplementairesForm
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
                                />
                            </Accordion.Content>
                        </Accordion.Panel>
                    </Accordion>

                    <div className="flex justify-end mt-8">
                        <Button type="submit">
                            Poster l&apos;offre
                        </Button>
                    </div>
                </form>
            </div>

            <div className="w-1/5 mt-10 mr-5 sticky top-10">
                <h3 className="text-xl font-semibold mb-5">Etat du formulaire</h3>
                <Timeline>
                    {/* Informations de base */}
                    <Timeline.Item>
                        <Timeline.Point className={`h-2 w-2 rounded-full ${getPointColor(checkInformationsDeBase())}`} />
                        <Timeline.Content>
                            <Timeline.Time>Étape 1 : Informations de base</Timeline.Time>
                            <Timeline.Body>
                                {checkInformationsDeBase() ? 'Tous les champs sont remplis.' : 'Certains champs sont manquants.'}
                            </Timeline.Body>
                        </Timeline.Content>
                    </Timeline.Item>

                    {/* Extras */}
                    <Timeline.Item>
                        <Timeline.Point className={`h-2 w-2 rounded-full ${getPointColor(checkExtras())}`} />
                        <Timeline.Content>
                            <Timeline.Time>Étape 2 : Extras</Timeline.Time>
                            <Timeline.Body>
                                {checkExtras() ? 'Tous les champs sont remplis.' : 'Certains champs sont manquants.'}
                            </Timeline.Body>
                        </Timeline.Content>
                    </Timeline.Item>

                    {/* Conditions financières */}
                    <Timeline.Item>
                        <Timeline.Point className={`h-2 w-2 rounded-full ${getPointColor(checkConditionsFinancieres())}`} />
                        <Timeline.Content>
                            <Timeline.Time>Étape 3 : Conditions financières</Timeline.Time>
                            <Timeline.Body>
                                {checkConditionsFinancieres() ? 'Tous les champs sont remplis.' : 'Certains champs sont manquants.'}
                            </Timeline.Body>
                        </Timeline.Content>
                    </Timeline.Item>

                    {/* Budget estimatif */}
                    <Timeline.Item>
                        <Timeline.Point className={`h-2 w-2 rounded-full ${getPointColor(checkBudgetEstimatif())}`} />
                        <Timeline.Content>
                            <Timeline.Time>Étape 4 : Budget estimatif</Timeline.Time>
                            <Timeline.Body>
                                {checkBudgetEstimatif() ? 'Tous les champs sont remplis.' : 'Certains champs sont manquants.'}
                            </Timeline.Body>
                        </Timeline.Content>
                    </Timeline.Item>

                    {/* Fiche technique de l'artiste */}
                    <Timeline.Item>
                        <Timeline.Point className={`h-2 w-2 rounded-full ${getPointColor(checkFicheTechniqueArtiste())}`} />
                        <Timeline.Content>
                            <Timeline.Time>Étape 5 : Fiche technique de l&apos;artiste</Timeline.Time>
                            <Timeline.Body>
                                {checkFicheTechniqueArtiste() ? 'Tous les champs sont remplis.' : 'Certains champs sont manquants.'}
                            </Timeline.Body>
                        </Timeline.Content>
                    </Timeline.Item>

                    {/* Données supplémentaires */}
                    <Timeline.Item>
                        <Timeline.Point className={`h-2 w-2 rounded-full ${getPointColor(checkDonneesSupplementaires())}`} />
                        <Timeline.Content>
                            <Timeline.Time>Étape 6 : Données supplémentaires</Timeline.Time>
                            <Timeline.Body>
                                {checkDonneesSupplementaires() ? 'Tous les champs sont remplis.' : 'Certains champs sont manquants.'}
                            </Timeline.Body>
                        </Timeline.Content>
                    </Timeline.Item>

                </Timeline>
            </div>
        </div>
    );
};

export default OffreForm;
