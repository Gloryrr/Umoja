"use client";
import React, {useEffect, useState, useRef } from 'react';
import { TextInput, Label, Card, Button, Checkbox, FileInput } from 'flowbite-react';
import { FiRefreshCw } from "react-icons/fi";
import { Artiste } from '../../../../app/types/FormDataType';
import { apiPostSFTP, apiPost } from '../../../../app/services/internalApiClients';

interface FicheTechniqueArtisteFormProps {
    ficheTechniqueArtiste: {
        ficheTechniqueArtisteParPDF: boolean | null;
        besoinBackline: string | null;
        besoinEclairage: string | null;
        besoinEquipements: string | null;
        besoinScene: string | null;
        besoinSonorisation: string | null;
        ordrePassage: string | null;
        liensPromotionnels: string[];
        artiste: Artiste[];
        nbArtistes: number | null;
    };
    idProjet: number | null;
    onFicheTechniqueChange: (name: string, value: string | string[] | number | Artiste[] | boolean) => void;
}

const FicheTechniqueArtisteForm: React.FC<FicheTechniqueArtisteFormProps> = ({
    ficheTechniqueArtiste,
    onFicheTechniqueChange,
    idProjet,
}) => {
    const [offreId, setOffreId] = useState<number | null>(idProjet);
    const [file, setFile] = useState<File | null>(null);
    const [message, setMessage] = useState('');
    const [colorMessage, setColorMessage] = useState('success');
    const [isTextInputActive, setIsTextInputActive] = useState<boolean>(!ficheTechniqueArtiste.ficheTechniqueArtisteParPDF);

    const [contenuFicheTechniqueArtisteParPDF, setContenuFicheTechniqueArtisteParPDF] = useState<string | null>(null);

    const [messageAucunFichier, setMessageAucunFichier] = useState<string | null>(null);

    const fileInputRef = useRef<HTMLInputElement | null>(null);

    const [liensPromotionnels, setLiensPromotionnels] = useState<string[]>(ficheTechniqueArtiste.liensPromotionnels || ['']);
    const [artistes, setArtistes] = useState<Artiste[]>(ficheTechniqueArtiste.artiste);
    const handleFicheTechniqueArtisteChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value, type } = e.target as HTMLInputElement;
        const newValue = type === "checkbox" ? !ficheTechniqueArtiste.ficheTechniqueArtisteParPDF : value;
        
        onFicheTechniqueChange(name, newValue);
        if (name === 'ficheTechniqueArtisteParPDF') {
            setIsTextInputActive(!isTextInputActive);
        }
    };

    const handleReset = () => {
        onFicheTechniqueChange("besoinBackline", "");
        onFicheTechniqueChange("besoinEclairage", "");
        onFicheTechniqueChange("besoinEquipements", "");
        onFicheTechniqueChange("besoinScene", "");
        onFicheTechniqueChange("besoinSonorisation", "");
        onFicheTechniqueChange("ordrePassage", "");
        onFicheTechniqueChange("liensPromotionnels", []);
        onFicheTechniqueChange("artiste", []);
        onFicheTechniqueChange("nbArtistes", 0);
    };

    const handleUpdateLien = (newLiens: string[]) => {
        setLiensPromotionnels(newLiens);
        onFicheTechniqueChange('liensPromotionnels', newLiens);
    };

    const handleLienChange = (index: number, value: string) => {
        const newLiens = [...liensPromotionnels];
        newLiens[index] = value;
        handleUpdateLien(newLiens);
    };
    
    const handleAddLien = () => {
        handleUpdateLien([...liensPromotionnels, '']);
    };
    
    const handleRemoveLien = (index: number) => {
        const newLiens = liensPromotionnels.filter((_, i) => i !== index);
        handleUpdateLien(newLiens);
    };

    const handleArtisteChange = (index: number, value: string) => {
        const updatedArtistes = [...artistes];
        updatedArtistes[index].nomArtiste = value;
        setArtistes(updatedArtistes);
        onFicheTechniqueChange('artiste', updatedArtistes);
        onFicheTechniqueChange('nbArtistes', updatedArtistes.length);
    };

    const addArtisteField = () => {
        setArtistes([...artistes, {nomArtiste: ""}]);
    };

    const removeArtisteField = (index: number) => {
        const updatedArtistes = artistes.filter((_, i) => i !== index);
        setArtistes(updatedArtistes);
        onFicheTechniqueChange('artiste', updatedArtistes);
        onFicheTechniqueChange('nbArtistes', updatedArtistes.length);
    };

    const handleFileChange = async (e: React.ChangeEvent<HTMLInputElement>) => {
        setFile(e.target.files?.[0] || null);
    };

    useEffect(() => {
        setOffreId(idProjet);
    }, [idProjet]);

    useEffect(() => {
        if (offreId && file) {
            const handleSubmit = async () => {
    
                const formData = new FormData();
                formData.append('file', file);
                formData.append('idProjet', offreId.toString());
                formData.append('typeFichier', "fiche_technique_artiste");
    
                try {
                    await apiPostSFTP('/upload-sftp-fichier', formData);
                    setColorMessage('text-green-500');
                    setMessage('Le fichier a été transféré avec succès');
                } catch (error) {
                    console.error('Erreur lors du transfert du fichier :', error);
                    setColorMessage('text-red-500');
                    setMessage('Erreur lors du transfert du fichier, veuillez réessayer');
                }
            };
    
            handleSubmit();
        }
    }, [offreId, file]);

    useEffect( () => {
        const fetchFichiersProjet = async () => {
            const data = {
                idProjet: offreId,
            };
            await apiPost('/get-sftp-fichiers', JSON.parse(JSON.stringify(data))).then(
                (response) => {
                    if (response.message_none_files) {
                        setMessageAucunFichier(response.message_none_files);
                    } else {
                        if (response.files.fiche_technique_artiste != null) {
                            setContenuFicheTechniqueArtisteParPDF(response.files.fiche_technique_artiste.content);
                        } else {
                            setContenuFicheTechniqueArtisteParPDF(null);
                        }
                    }
                }
            );
        };

        if (ficheTechniqueArtiste && offreId) {
            fetchFichiersProjet();
        }
    }, [ficheTechniqueArtiste, offreId]);

    // Charger automatiquement le fichier dans l'input file
    useEffect(() => {
        // Convertir base64 en Blob et en fichier
        const base64ToFile = (base64 : string) => {
            const byteString = atob(base64); // Décoder le contenu base64
            const mimeString = "pdf" // on accepte que les pdf par défaut
            const arrayBuffer = new ArrayBuffer(byteString.length);
            const intArray = new Uint8Array(arrayBuffer);

            for (let i = 0; i < byteString.length; i++) {
                intArray[i] = byteString.charCodeAt(i);
            }

            const blob = new Blob([arrayBuffer], { type: mimeString });
            return new File([blob], `fiche_technique_artiste_pdf_${offreId}.pdf`, { type: mimeString });
        };

        if (contenuFicheTechniqueArtisteParPDF && fileInputRef.current) {
            const file = base64ToFile(contenuFicheTechniqueArtisteParPDF);
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInputRef.current.files = dataTransfer.files;
        }
    }, [contenuFicheTechniqueArtisteParPDF, offreId]);

    return (
        <Card className="w-full shadow-none border-none">
            <div className="flex justify-between items-center mb-4">
                <h3 className="text-2xl font-semibold mb-4">Fiche Technique Artiste</h3>
                <Button
                    color="gray"
                    onClick={handleReset}
                    pill
                    aria-label="Reset"
                    className="flex items-center"
                >
                    <FiRefreshCw className="w-4 h-4" />
                </Button>
            </div>

            <div className="mb-4">
                <Checkbox
                    id="ficheTechniqueArtisteParPDF"
                    checked={isTextInputActive}
                    onChange={handleFicheTechniqueArtisteChange}
                    name="ficheTechniqueArtisteParPDF"
                />
                <Label htmlFor="ficheTechniqueArtisteParPDF" className="ml-2">
                    Ne pas importer de PDF
                </Label>
            </div>

            {/* Section Backline et Éclairage */}
            <div className="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <Label htmlFor="besoinBackline" value="Besoin en backline:" />
                    <TextInput
                        disabled={!isTextInputActive}
                        id="besoinBackline"
                        name="besoinBackline"
                        value={ficheTechniqueArtiste.besoinBackline ?? ""}
                        onChange={handleFicheTechniqueArtisteChange}
                        placeholder="Nombre d'amplis, enceinte, etc..."
                        required
                    />
                </div>
                <div>
                    <Label htmlFor="besoinEclairage" value="Besoin en éclairage:" />
                    <TextInput
                        disabled={!isTextInputActive}
                        id="besoinEclairage"
                        name="besoinEclairage"
                        value={ficheTechniqueArtiste.besoinEclairage ?? ""}
                        onChange={handleFicheTechniqueArtisteChange}
                        placeholder="Nombre de projecteurs, etc..."
                        required
                    />
                </div>
            </div>

            {/* Section Équipements et Scène */}
            <div className="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <Label htmlFor="besoinEquipements" value="Besoin en équipements:" />
                    <TextInput
                        disabled={!isTextInputActive}
                        id="besoinEquipements"
                        name="besoinEquipements"
                        value={ficheTechniqueArtiste.besoinEquipements ?? ""}
                        onChange={handleFicheTechniqueArtisteChange}
                        placeholder="Nombre de micros, etc..."
                        required
                    />
                </div>
                <div>
                    <Label htmlFor="besoinScene" value="Besoin pour la scène:" />
                    <TextInput
                        disabled={!isTextInputActive}
                        id="besoinScene"
                        name="besoinScene"
                        value={ficheTechniqueArtiste.besoinScene ?? ""}
                        onChange={handleFicheTechniqueArtisteChange}
                        placeholder="Scène de 30m² minimum, etc..."
                        required
                    />
                </div>
            </div>

            {/* Section Sonorisation */}
            <div className="mb-5">
                <Label htmlFor="besoinSonorisation" value="Besoin en sonorisation:" />
                <TextInput
                    disabled={!isTextInputActive}
                    id="besoinSonorisation"
                    name="besoinSonorisation"
                    value={ficheTechniqueArtiste.besoinSonorisation ?? ""}
                    onChange={handleFicheTechniqueArtisteChange}
                    placeholder="Console de mixage, etc..."
                    required
                />
            </div>
            <div className="flex flex-col rounded-lg mb-4">
                <div className="items-center">
                    <h3 className="text-2xl font-semibold mb-4">Artistes Concernés</h3>
                </div>

                {artistes ? artistes.map((artiste, index) => (
                    <div key={index} className="flex items-center mb-2">
                        <TextInput
                            disabled={!isTextInputActive}
                            type="text"
                            value={artiste.nomArtiste}
                            onChange={(e) => handleArtisteChange(index, e.target.value)}
                            placeholder="Nom de l'artiste..."
                            className="w-full"
                        />
                        <Button color="failure" onClick={() => removeArtisteField(index)} size="sm" className="ml-2" disabled={!isTextInputActive}>
                            Supprimer
                        </Button>
                    </div>
                )) : "Aucun artiste lié au projet"}
                <Button onClick={addArtisteField} className="mt-2 w-full" disabled={!isTextInputActive}>
                    Ajouter un artiste
                </Button>
            </div>
            {/* Section ordre de passage et clauses de confidentialité */}
            <div className="grid gap-4 mb-5">
                <div>
                    <Label htmlFor="ordrePassage" value="Ordre de passage des artistes durant l'évènement:" />
                    <TextInput
                        disabled={!isTextInputActive}
                        id="ordrePassage"
                        name="ordrePassage"
                        type="text"
                        value={ficheTechniqueArtiste.ordrePassage ?? ""}
                        onChange={handleFicheTechniqueArtisteChange}
                        placeholder="Artiste 1 - Artiste 2 - Artiste 3..."
                        className='w-full'
                    />
                </div>
            </div>
            <div className="mb-5">
                <h3 className="text-2xl font-semibold mb-4">Liens Promotionnels:</h3>
                {liensPromotionnels.map((lien, index) => (
                    <div key={index} className="flex items-center mb-2">
                        <TextInput
                            disabled={!isTextInputActive}
                            type="url"
                            value={lien}
                            onChange={(e) => handleLienChange(index, e.target.value)}
                            required
                            placeholder="https://www.spotify.com..."
                            className="w-full"
                        />
                        <Button
                            disabled={!isTextInputActive}
                            color="failure"
                            onClick={() => handleRemoveLien(index)}
                            className="ml-2"
                        >
                            Supprimer
                        </Button>
                    </div>
                ))}
                <Button
                    onClick={handleAddLien}
                    className="mt-2 w-full"
                    disabled={!isTextInputActive}
                >
                    Ajouter un lien
                </Button>
            </div>

            <div className="flex">
                <FileInput
                    disabled={isTextInputActive}
                    className="w-full mr-5"
                    accept="application/pdf"
                    onChange={handleFileChange}
                    ref={fileInputRef}
                />
                {messageAucunFichier && <p className="text-red-500">{messageAucunFichier}</p>}
            </div>

            {message && <p className={colorMessage}>{message}</p>}

        </Card>
    );
};

export default FicheTechniqueArtisteForm;