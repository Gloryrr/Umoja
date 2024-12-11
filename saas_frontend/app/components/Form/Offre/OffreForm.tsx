"use client";
import React, { useState, useEffect } from 'react';
import { Accordion, Button, Alert, Timeline, FileInput, Label, Card } from 'flowbite-react';
import ExtrasForm from '@/app/components/Form/Offre/ExtrasForm';
import ConditionsFinancieresForm from '@/app/components/Form/Offre/ConditionsFinancieresForm';
import BudgetEstimatifForm from '@/app/components/Form/Offre/BudgetEstimatifForm';
import DetailOffreForm from '@/app/components/Form/Offre/DetailOffreForm';
import FicheTechniqueArtisteForm from '@/app/components/Form/Offre/FicheTechniqueArtiste';
import InfoAdditionnelAlert from '@/app/components/Alerte/InfoAdditionnelAlerte';
import { apiPost } from '@/app/services/internalApiClients';
import { HiInformationCircle } from "react-icons/hi";
import { FormData } from '@/app/types/FormDataType';
import SelectCheckbox from '@/app/components/SelectCheckbox';
import { apiGet } from '@/app/services/internalApiClients';

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
            nbInvitesConcernes: null
        },
        extras: {
            descrExtras: null,
            coutExtras: null,
            exclusivite: null,
            exception: null,
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
            besoinSonorisation: null,
            ordrePassage: null,
            liensPromotionnels: [],
            artiste: [],
            nbArtistes: 0
        },
        donneesSupplementaires: {
            reseau: [],
            nbReseaux: 0,
            genreMusical: [],
            nbGenresMusicaux: 0,
        },
        utilisateur: {
            username : ""
        },
        image: {
            file: null
        }
    });

    const [offrePostee, setOffrePostee] = useState(false);
    const [messageOffrePostee, setMessageOffrePostee] = useState("");
    const [typeMessage, setTypeMessage] = useState<"success" | "error">("success");
    const [offreId, setOffreId] = useState("");
    const [description, setDescription] = useState("");
    const [genresMusicaux, setGenresMusicaux] = useState<Array<{ nomGenreMusical: string }>>([]);
    const [selectedGenres, setSelectedGenres] = useState<string[]>(formData.donneesSupplementaires.genreMusical);
    const [reseaux, setReseaux] = useState<Array<{ nomReseau: string }>>([]);
    const [selectedReseaux, setSelectedReseaux] = useState<string[]>(formData.donneesSupplementaires.reseau);

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
            throw new Error("Erreur lors du post de l'offre :", error as Error);
        }
    };

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
                await apiGet("/me").then(async (response) => {
                    formData.utilisateur.username = response.utilisateur;
                    const username = formData.utilisateur.username;
                    const data = { username };
                    const datasUser = await apiPost('/utilisateur', JSON.parse(JSON.stringify(data)));
                    const reseauxListe: Array<{ nomReseau: string }> = JSON.parse(datasUser.utilisateur)[0].reseaux;
                    console.log(reseauxListe);
                    setReseaux(reseauxListe);
                });
            } catch (error) {
                console.error("Erreur lors du chargement des données utilisateurs :", error);
            }
        };

        fetchGenresMusicaux();
        fetchReseauUtilisateur();
    }, []);

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
            nbInvitesConcernes
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
            nbInvitesConcernes != null && nbInvitesConcernes > 0);
    };

    const checkExtras = () => {
        const {
            descrExtras,
            coutExtras,
            exclusivite,
            exception,
            clausesConfidentialites 
        } = formData.extras;
        return !!(descrExtras && 
            coutExtras != null && 
            coutExtras > 0 && 
            exclusivite && 
            exception && 
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
            besoinSonorisation,
            ordrePassage,
            liensPromotionnels,
            artiste,
            nbArtistes
        } = formData.ficheTechniqueArtiste;
        return !!(
            besoinBackline && 
            besoinEclairage && 
            besoinEquipements && 
            besoinScene && 
            besoinSonorisation && 
            ordrePassage && 
            artiste.length > 0 && 
            liensPromotionnels.length > 0 && 
            nbArtistes != null && nbArtistes > 0
        );
    };

    const checkDonneesSupplementaires = () => {
        const {
            reseau,
            nbReseaux,
            genreMusical,
            nbGenresMusicaux
        } = formData.donneesSupplementaires;
        return reseau.length > 0 && 
            nbReseaux != null && nbReseaux > 0 && 
            genreMusical.length > 0 && 
            nbGenresMusicaux != null && nbGenresMusicaux > 0;
    };

    const onDonneesSupplementairesChange = (name: string, value: string[] | number) => {
        setFormData((prevData) => ({
            ...prevData,
            donneesSupplementaires: {
                ...prevData.donneesSupplementaires,
                [name]: value
            }
        }));
    };

    const updateField = (
        section: keyof FormData,
        field: string,
        value: string | null
    ) => {
        const valueAsList = Array.isArray(value) 
            ? value 
            : Object.values(value || {});
    
        setFormData((prevData) => ({
            ...prevData,
            [section]: {
                ...prevData[section],
                [field]: valueAsList
            },
        }));
    };

    const updateFieldWithBlob = async (
        section: keyof FormData,
        field: string,
        file: File | null
    ) => {
        if (!file) {
            updateField(section, field, null);
            return;
        }
    
        try {
            const arrayBuffer = await file.arrayBuffer();
            const uint8Array = new Uint8Array(arrayBuffer);
            const base64String = btoa(String.fromCharCode(...uint8Array));
            console.log(section, field, base64String); 
    
            updateField(section, field, base64String);
        } catch (error) {
            console.error("Erreur lors de la conversion du fichier en base64:", error);
        }
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
                            <Accordion.Title>Données de publications</Accordion.Title>
                            <Accordion.Content className='p-0'>
                            <Card className="w-full shadow-none border-none">
                                <div className="grid grid-cols-2 gap-3">
                                    <div>
                                        <SelectCheckbox
                                            domaineSelection="Réseaux sur lesquels poster votre évènement :"
                                            options={reseaux.map((reseau) => ({ label: reseau.nomReseau, value: reseau.nomReseau }))}
                                            selectedValues={selectedReseaux}
                                            onSelectionChange={(updatedReseaux) => {
                                                setSelectedReseaux(updatedReseaux);
                                                onDonneesSupplementairesChange("reseau", updatedReseaux);
                                                onDonneesSupplementairesChange("nbReseaux", updatedReseaux.length);
                                            }}
                                        />
                                    </div>

                                    <div>
                                        <SelectCheckbox
                                            domaineSelection="Genres musicaux en lien avec votre évènement :"
                                            options={genresMusicaux.map((genreMusical) => ({ label: genreMusical.nomGenreMusical, value: genreMusical.nomGenreMusical }))}
                                            selectedValues={selectedGenres}
                                            onSelectionChange={(updatedGenres) => {
                                                setSelectedGenres(updatedGenres);
                                                onDonneesSupplementairesChange("genreMusical", updatedGenres);
                                                onDonneesSupplementairesChange("nbGenresMusicaux", updatedGenres.length);
                                            }}
                                        />
                                    </div>
                                </div>
                            </Card>
                        </Accordion.Content>
                        </Accordion.Panel>
                    </Accordion>
                    <div>
                        <Label htmlFor="file-upload-helper-text" value="Ajouter une image de référence" />
                        <FileInput
                            id="file-upload-helper-text"
                            helperText="JPG"
                            accept=".jpg"
                            onChange={(e) => {
                                const file = e.target.files?.[0] || null;
                                updateFieldWithBlob("image", "file", file);
                            }}
                        />
                    </div>

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
