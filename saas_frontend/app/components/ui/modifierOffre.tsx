"use client";
import React, { useState, useEffect, useRef } from 'react';
import { Accordion, /*Alert,*/ Timeline, FileInput, Label, Card, Button } from 'flowbite-react';
import ExtrasForm from '@/app/components/Form/Offre/ExtrasForm';
import ConditionsFinancieresForm from '@/app/components/Form/Offre/ConditionsFinancieresForm';
import BudgetEstimatifForm from '@/app/components/Form/Offre/BudgetEstimatifForm';
import DetailOffreForm from '@/app/components/Form/Offre/DetailOffreForm';
import FicheTechniqueArtisteForm from '@/app/components/Form/Offre/FicheTechniqueArtiste';
// import InfoAdditionnelAlert from '@/app/components/Alerte/InfoAdditionnelAlerte';
import { apiPost,apiGet, /*apiPatch*/ } from '@/app/services/internalApiClients';
// import { HiInformationCircle } from "react-icons/hi";
import { FormData, GenreMusical, Reseau } from '@/app/types/FormDataType';
import SelectCheckbox from '@/app/components/SelectCheckbox';

const ModifierOffreForm: React.FC<{ 
    project: FormData, 
    onProjectInformationsChange : (formData : FormData) => void,
    onDonneesSauvegardees: (donneesSauvegardees: boolean) => void,
}> = ({ project, 
        onProjectInformationsChange,
        onDonneesSauvegardees
    }) => {
    const [formData, setFormData] = useState<FormData>(project);
    // const [offreModifiee, setOffreModifiee] = useState(false);
    // const [messageOffreModifiee, setMessageOffreModifiee] = useState("");
    // const [typeMessage, setTypeMessage] = useState<"success" | "error">("success");
    // const [offreId, setOffreId] = useState<number | null>(null);
    // const [description, setDescription] = useState("");
    const [genresMusicaux, setGenresMusicaux] = useState<Array<{ nomGenreMusical: string }>>([]);
    const [selectedGenres, setSelectedGenres] = useState<GenreMusical[]>(project.donneesSupplementaires.genreMusical);
    const [reseaux, setReseaux] = useState<Array<{ nomReseau: string }>>([]);
    const [selectedReseaux, setSelectedReseaux] = useState<Reseau[]>(formData.donneesSupplementaires.reseau);

    const [donneesSauvegardees, setDonneesSauvegardees] = useState(false);

    const imageInputRef = useRef<HTMLInputElement | null>(null);

    const arrayBufferToFile = (arrayBuffer: ArrayBuffer) => {
        const mimeString = "image/jpg"; // on accepte que les jpg par défaut
        const blob = new Blob([arrayBuffer], { type: mimeString });
        return new File([blob], `image_projet.jpg`, { type: mimeString });
    };

    useEffect(() => {
        const SetPropsImageFieldWithBlob = async (
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
        
                updateField(section, field, base64String);
            } catch (error) {
                console.error("Erreur lors de la conversion du fichier en base64:", error);
            }
        };
        if (imageInputRef.current && project.image?.file) {
            const file = arrayBufferToFile(project.image.file);
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            imageInputRef.current.files = dataTransfer.files;
            SetPropsImageFieldWithBlob("image", "file", file);
        }
    }, [project.image]);

    // const valideFormulaire = async (e: React.FormEvent) => {
    //     e.preventDefault();
    //     try {
    //         const offreModifiee = await apiPatch(`/offre/update/${formData.detailOffre.id}`, JSON.parse(JSON.stringify(formData)));
    //         setOffreId(JSON.parse(offreModifiee.offre).id);
    //         setTypeMessage("success");
    //         setDescription("Cliquez sur 'Voir plus' pour accéder aux détails de l'offre.");
    //         setMessageOffreModifiee("Votre offre a bien été modifiée !");
    //         setOffreModifiee(true);
    //         const data = {
    //             'projectName' : formData.detailOffre.titleOffre,
    //             'projectDescription' : formData.detailOffre.descrTournee,
    //             'username' : formData.utilisateur.username,
    //             'offreId' : JSON.parse(offreModifiee.offre).id
    //         };
    //         await apiPost('/envoi-email-update-projet', JSON.parse(JSON.stringify(data)));
    //     } catch (error) {
    //         setTypeMessage("error");
    //         setMessageOffreModifiee("Une erreur s'est produite durant la modification de votre offre.");
    //         setOffreModifiee(true);
    //         throw new Error("Erreur lors de la modification de l'offre :", error as Error);
    //     }
    // };

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
                    setReseaux(reseauxListe);
                });
            } catch (error) {
                console.error("Erreur lors du chargement des données utilisateurs :", error);
            }
        };
    
        fetchGenresMusicaux();
        fetchReseauUtilisateur();
    }, [setGenresMusicaux, setReseaux, formData.utilisateur]);
    
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
            minimunGaranti,
            conditionsPaiement,
            pourcentageRecette
        } = formData.conditionsFinancieres;
        return !!(minimunGaranti != null && minimunGaranti > 0 && conditionsPaiement && pourcentageRecette != null && pourcentageRecette > 0);
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

    const onDonneesSupplementairesChange = (name: string, value: string[] | Reseau[] | GenreMusical[] | number) => {
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
            : Object.values(value ?? {});
    
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
    
            updateField(section, field, base64String);
        } catch (error) {
            console.error("Erreur lors de la conversion du fichier en base64:", error);
        }
    };
          

    const getPointColor = (isValid: boolean) => {
        return isValid ? 'bg-green-500' : 'bg-red-500';
    };

    useEffect(() => {
        onProjectInformationsChange(formData);
        onDonneesSauvegardees(donneesSauvegardees);
    }, [formData, onProjectInformationsChange, donneesSauvegardees, onDonneesSauvegardees]);

    // useEffect( () => {
    //     const fetchFichiersProjet = async () => {
    //         const data = {
    //             idProjet: project.detailOffre.id,
    //         };
    //         await apiPost('/get-sftp-fichiers', JSON.parse(JSON.stringify(data))).then(
    //             (response) => {
    //                 if (response.message_none_files) {
    //                     setMessageAucunFichier(response.message_none_files);
    //                 } else {
    //                     if (response.files.budget_estimatif != null) {
    //                         setContenuBudgetEstimatifParPDF(response.files.budget_estimatif.content);
    //                     } else {
    //                         setContenuBudgetEstimatifParPDF(null);
    //                     }
    //                     if (response.files.extras != null) {
    //                         setContenuExtrasParPDF(response.files.extras.content);
    //                     } else {
    //                         setContenuExtrasParPDF(null);
    //                     }
    //                     if (response.files.conditions_financieres != null) {
    //                         setContenuConditionsFinancieresParPDF(response.files.conditions_financieres.content);
    //                     } else {
    //                         setContenuConditionsFinancieresParPDF(null);
    //                     }
    //                     if (response.files.fiche_technique_artiste != null) {
    //                         setContenuFicheTechniqueArtisteParPDF(response.files.fiche_technique_artiste.content);
    //                     } else {
    //                         setContenuFicheTechniqueArtisteParPDF(null);
    //                     }
    //                 }
    //             }
    //         );
    //     };

    //     if (project) {
    //         fetchFichiersProjet();
    //     }
    // }, [project]);
    
    return (
        <div className="w-full flex items-start justify-center">
            <div className="w-full">
                {/* {offreModifiee && (
                    <Alert
                        color={typeMessage === "success" ? "green" : "failure"}
                        onDismiss={() => setOffreModifiee(false)}
                        icon={HiInformationCircle}
                        className="mb-5"
                        additionalContent={
                            <InfoAdditionnelAlert
                                isSuccess={typeMessage === "success"}
                                description={description}
                                offreId={offreId}
                                onDismiss={() => setOffreModifiee(false)}
                            />
                        }
                    >
                        <span className='font-medium'>Info alerte ! </span>
                        {messageOffreModifiee}
                    </Alert>
                )} */}
                <form className="w-full mx-auto rounded-lg space-y-4 font-nunito">
                    <h2 className="text-2xl font-semibold text-center mb-10">Modifier votre offre</h2>
                    <p>Une fois vos informations modifiées, merci de cliquer sur le bouton de sauvegarde en bas du formulaire</p>
                    <Accordion collapseAll>
                        <Accordion.Panel>
                            <Accordion.Title>Informations de base</Accordion.Title>
                            <Accordion.Content className='p-0'>
                                <DetailOffreForm
                                    detailOffre={formData.detailOffre}
                                    onDetailOffreChange={(name, value) => {
                                        setFormData((prevData) => ({
                                            ...prevData,
                                            detailOffre: {
                                                ...prevData.detailOffre,
                                                [name]: value
                                            }
                                        }))
                                        //onProjectDetailChange(formData);
                                    }}
                                />
                            </Accordion.Content>
                        </Accordion.Panel>

                        <Accordion.Panel>
                            <Accordion.Title>Extras</Accordion.Title>
                            <Accordion.Content className='p-0'>
                                <ExtrasForm
                                    extras={formData.extras}
                                    onExtrasChange={(name, value) => {
                                        setFormData((prevData) => ({
                                            ...prevData,
                                            extras: {
                                                ...prevData.extras,
                                                [name]: value
                                            }
                                        }));
                                        //onProjectExtrasChange(formData);
                                    }}
                                    idProjet={formData.detailOffre.id ?? null}
                                />
                            </Accordion.Content>
                        </Accordion.Panel>

                        <Accordion.Panel>
                            <Accordion.Title>Conditions Financières</Accordion.Title>
                            <Accordion.Content className='p-0'>
                                <ConditionsFinancieresForm
                                    conditionsFinancieres={formData.conditionsFinancieres}
                                    onConditionsFinancieresChange={(name, value) => {
                                        setFormData((prevData) => ({
                                            ...prevData,
                                            conditionsFinancieres: {
                                                ...prevData.conditionsFinancieres,
                                                [name]: value
                                            }
                                        }));
                                        //onProjectConditionsFinancieresChange(formData);
                                    }}
                                    idProjet={formData.detailOffre.id ?? null}
                                />
                            </Accordion.Content>
                        </Accordion.Panel>

                        <Accordion.Panel>
                            <Accordion.Title>Budget Estimatif</Accordion.Title>
                            <Accordion.Content className='p-0'>
                                <BudgetEstimatifForm
                                    budgetEstimatif={formData.budgetEstimatif}
                                    onBudgetEstimatifChange={(name, value) => {
                                        setFormData((prevData) => ({
                                            ...prevData,
                                            budgetEstimatif: {
                                                ...prevData.budgetEstimatif,
                                                [name]: value
                                            }
                                        }));
                                        //onProjectBudgetEstimatifChange(formData);
                                    }}
                                    idProjet={formData.detailOffre.id ?? null}
                                />
                            </Accordion.Content>
                        </Accordion.Panel>

                        <Accordion.Panel>
                            <Accordion.Title>Fiche technique de l&apos;artiste</Accordion.Title>
                            <Accordion.Content className='p-0'>
                                <FicheTechniqueArtisteForm
                                    ficheTechniqueArtiste={formData.ficheTechniqueArtiste}
                                    onFicheTechniqueChange={(name, value) => {
                                        setFormData((prevData) => ({
                                            ...prevData,
                                            ficheTechniqueArtiste: {
                                                ...prevData.ficheTechniqueArtiste,
                                                [name]: value
                                            }
                                        }));
                                        //onProjectFicheTechniqueArtisteChange(formData);
                                    }}
                                    idProjet={formData.detailOffre.id ?? null}
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
                                            selectedValues={selectedReseaux.map((reseau) => reseau.nomReseau)}
                                            onSelectionChange={(updatedReseaux) => {
                                                const newSelectedReseaux = [];
                                                for (let index = 0; index < updatedReseaux.length; index++) {
                                                    const element = updatedReseaux[index];
                                                    newSelectedReseaux.push({
                                                        nomReseau: element
                                                    })
                                                }
                                                setSelectedReseaux(newSelectedReseaux);
                                                onDonneesSupplementairesChange("reseau", newSelectedReseaux);
                                                onDonneesSupplementairesChange("nbReseaux", newSelectedReseaux.length);
                                                //onProjectDonneesSupplementaireChange(formData);
                                            }}
                                        />
                                    </div>

                                    <div>
                                        <SelectCheckbox
                                            domaineSelection="Genres musicaux en lien avec votre évènement :"
                                            options={genresMusicaux.map((genreMusical) => ({ label: genreMusical.nomGenreMusical, value: genreMusical.nomGenreMusical }))}
                                            selectedValues={selectedGenres.map((genre) => genre.nomGenreMusical)}
                                            onSelectionChange={(updatedGenres) => {
                                                const newSelectedGenres = [];
                                                for (let index = 0; index < updatedGenres.length; index++) {
                                                    const element = updatedGenres[index];
                                                    newSelectedGenres.push({
                                                        nomGenreMusical: element
                                                    })
                                                }
                                                setSelectedGenres(newSelectedGenres);
                                                onDonneesSupplementairesChange("genreMusical", newSelectedGenres);
                                                onDonneesSupplementairesChange("nbGenresMusicaux", newSelectedGenres.length);
                                                //onProjectDonneesSupplementaireChange(formData);
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
                            ref={imageInputRef}
                        />
                    </div>

                    <div className="flex justify-center">
                        <Button
                            onClick={() => setDonneesSauvegardees(true)}
                        >
                            Sauvegarder
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

export default ModifierOffreForm;
