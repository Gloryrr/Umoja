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

const OffreForm: React.FC = () => {
    const dateParDefaut = new Date().toISOString().split('T')[0];
    const [formData, setFormData] = useState({
        detailOffre: {
            titleOffre: '',
            deadLine: dateParDefaut,
            descrTournee: '',
            dateMinProposee: dateParDefaut,
            dateMaxProposee: dateParDefaut,
            villeVisee: '',
            regionVisee: '',
            placesMin: 0,
            placesMax: 0,
            nbArtistesConcernes: 0,
            nbInvitesConcernes: 0,
            liensPromotionnels: []
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
        ficheTechniqueArtiste: {
            besoinBackline: '',
            besoinEclairage: '',
            besoinEquipements: '',
            besoinScene: '',
            besoinSonorisation: ''
        },
        donneesSupplementaires: {
            reseau: ["Facebook"],
            nbReseaux: 0,
            genreMusical: ["Pop"],
            nbGenresMusicaux: 0,
            artiste: [],
            nbArtistes: 0
        },
        utilisateur: {
            username: 'steven', // utiliser localStorage après
            contact: 'utilisateur@gmail.com'
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
        return titleOffre && 
            deadLine && 
            descrTournee && 
            dateMinProposee && 
            dateMaxProposee && 
            villeVisee && 
            regionVisee && 
            placesMin > 0 && 
            placesMax > 0 &&
            nbArtistesConcernes > 0 &&
            nbInvitesConcernes > 0 &&
            liensPromotionnels.length > 0;
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
        return descrExtras && coutExtras > 0 && exclusivite && exception && ordrePassage && clausesConfidentialites;
    };

    const checkConditionsFinancieres = () => {
        const {
            minimumGaranti,
            conditionsPaiement,
            pourcentageRecette
        } = formData.conditionsFinancieres;
        return minimumGaranti > 0 && conditionsPaiement && pourcentageRecette > 0;
    };

    const checkBudgetEstimatif = () => {
        const {
            cachetArtiste,
            fraisDeplacement,
            fraisHebergement,
            fraisRestauration
        } = formData.budgetEstimatif;
        return cachetArtiste > 0 && fraisDeplacement > 0 && fraisHebergement > 0 && fraisRestauration > 0;
    };

    const checkFicheTechniqueArtiste = () => {
        const {
            besoinBackline,
            besoinEclairage,
            besoinEquipements,
            besoinScene,
            besoinSonorisation
        } = formData.ficheTechniqueArtiste;
        return besoinBackline && besoinEclairage && besoinEquipements && besoinScene && besoinSonorisation;
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
        return reseau.length > 0 && nbReseaux > 0 && genreMusical.length > 0 && nbGenresMusicaux > 0 && artiste.length > 0 && nbArtistes > 0;
    };

    const getPointColor = (isValid: boolean) => {
        return isValid ? 'bg-green-500' : 'bg-red-500';
    };

    return (
        <div className="w-full flex items-start justify-center pl-10">
            <div className="mt-10 mb-10 w-[60%] mx-auto">
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
                            <Accordion.Title>Fiche technique de l'artiste</Accordion.Title>
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
                            <Timeline.Time>Étape 5 : Fiche technique de l'artiste</Timeline.Time>
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
