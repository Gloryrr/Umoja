"use client";
import React, { useState } from 'react';
import { Accordion, Button, Alert } from 'flowbite-react';
import ExtrasForm from '@/app/components/Form/Offre/ExtrasForm';
import ConditionsFinancieresForm from '@/app/components/Form/Offre/ConditionsFinancieresForm';
import BudgetEstimatifForm from '@/app/components/Form/Offre/BudgetEstimatifForm';
import DetailOffreForm from '@/app/components/Form/Offre/DetailOffreForm';
import DonneesSupplementairesForm from '@/app/components/Form/Offre/DonneesSupplementairesForm';
import FicheTechniqueArtisteForm from '@/app/components/Form/Offre/FicheTechniqueArtiste';
import InfoAdditionnelAlert from '@/app/components/Alerte/InfoAdditionnelAlerte';
import { apiPost } from '@/app/services/internalApiClients';
import { useRouter } from 'next/navigation';
import { HiInformationCircle } from "react-icons/hi";

const OffreForm: React.FC = () => {
    const router = useRouter();
    const dateParDefaut = new Date().toISOString().split('T')[0];
    const [formData, setFormData] = useState({
        detailOffre: {
            titleOffre: 'b',
            deadLine: dateParDefaut,
            descrTournee: 'b',
            dateMinProposee: dateParDefaut,
            dateMaxProposee: dateParDefaut,
            villeVisee: 'b',
            regionVisee: 'b',
            placesMin: 0,
            placesMax: 0,
            nbArtistesConcernes: 0,
            nbInvitesConcernes: 0,
            liensPromotionnels: []
        },
        extras: {
            descrExtras: 'b',
            coutExtras: 0,
            exclusivite: 'b',
            exception: 'b',
            ordrePassage: 'b',
            clausesConfidentialites: 'b'
        },
        etatOffre: {
            nomEtatOffre: 'INITIAL'
        },
        typeOffre: {
            nomTypeOffre: 'TYPE TOURNEE'
        },
        conditionsFinancieres: {
            minimumGaranti: 0,
            conditionsPaiement: 'b',
            pourcentageRecette: 0
        },
        budgetEstimatif: {
            cachetArtiste: 0,
            fraisDeplacement: 0,
            fraisHebergement: 0,
            fraisRestauration: 0
        },
        ficheTechniqueArtiste: {
            besoinBackline: 'b',
            besoinEclairage: 'b',
            besoinEquipements: 'b',
            besoinScene: 'b',
            besoinSonorisation: 'b'
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
            username: 'steven',
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

    return (
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
            <form onSubmit={valideFormulaire} className="w-full mx-auto shadow-md rounded-lg p-8 space-y-4 font-nunito">
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
    );
};

export default OffreForm;
