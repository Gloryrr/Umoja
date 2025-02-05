"use client";
import React, { useState, useEffect, useRef } from 'react';
import { Card, Label, TextInput, Button, Checkbox, FileInput } from 'flowbite-react';
import { FiRefreshCw } from "react-icons/fi";
import { apiPostSFTP, apiPost } from '../../../../app/services/internalApiClients';

interface BudgetEstimatifFormProps {
    budgetEstimatif: {
        budgetEstimatifParPDF: boolean | null;
        cachetArtiste: number | null;
        fraisDeplacement: number | null;
        fraisHebergement: number | null;
        fraisRestauration: number | null;
    };
    idProjet: number | null;
    onBudgetEstimatifChange: (name: string, value: number | boolean) => void;
}

const BudgetEstimatifForm: React.FC<BudgetEstimatifFormProps> = ({
    budgetEstimatif,
    onBudgetEstimatifChange,
    idProjet,
}) => {
    const [offreId, setOffreId] = useState<number | null>(idProjet);
    const [file, setFile] = useState<File | null>(null);
    const [message, setMessage] = useState('');
    const [colorMessage, setColorMessage] = useState('success');
    const [isTextInputActive, setIsTextInputActive] = useState<boolean>(!budgetEstimatif.budgetEstimatifParPDF);
    
    const [contenuBudgetEstimatifParPDF, setContenuBudgetEstimatifParPDF] = useState<string | null>(null);

    const [messageAucunFichier, setMessageAucunFichier] = useState<string | null>(null);

    const fileInputRef = useRef<HTMLInputElement | null>(null);

    const handleBudgetEstimatifChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value, type } = e.target as HTMLInputElement;
        const newValue = type === "checkbox" ? !budgetEstimatif.budgetEstimatifParPDF : parseFloat(value);
        
        onBudgetEstimatifChange(name, newValue);
        if (name === 'budgetEstimatifParPDF') {
            setIsTextInputActive(!isTextInputActive);
        }
    };

    const handleReset = () => {
        onBudgetEstimatifChange("cachetArtiste", 0);
        onBudgetEstimatifChange("fraisDeplacement", 0);
        onBudgetEstimatifChange("fraisHebergement", 0);
        onBudgetEstimatifChange("fraisRestauration", 0);
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
                formData.append('typeFichier', "budget_estimatif");
    
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
                        if (response.files.budget_estimatif != null) {
                            setContenuBudgetEstimatifParPDF(response.files.budget_estimatif.content);
                        } else {
                            setContenuBudgetEstimatifParPDF(null);
                        }
                    }
                }
            );
        };

        if (budgetEstimatif && offreId) {
            fetchFichiersProjet();
        }
    }, [budgetEstimatif, offreId]);

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
            return new File([blob], `budget_estimatif_pdf_${offreId}.pdf`, { type: mimeString });
        };

        if (contenuBudgetEstimatifParPDF && fileInputRef.current) {
            const file = base64ToFile(contenuBudgetEstimatifParPDF);
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInputRef.current.files = dataTransfer.files;
        }
    }, [contenuBudgetEstimatifParPDF, offreId]);

    return (
        <Card className="shadow-none border-none mx-auto w-full">
            <div className="flex justify-between items-center mb-4">
                <h3 className="text-2xl font-semibold mb-4">Budget Estimatif</h3>
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
                    id="budgetEstimatifParPDF"
                    checked={isTextInputActive}
                    onChange={handleBudgetEstimatifChange}
                    name="budgetEstimatifParPDF"
                />
                <Label htmlFor="budgetEstimatifParPDF" className="ml-2">
                    Ne pas importer de PDF
                </Label>
            </div>

            <div className="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <Label htmlFor="cachetArtiste" value="Cachet de l'artiste:" />
                    <TextInput
                        disabled={!isTextInputActive}
                        type="number"
                        id="cachetArtiste"
                        name="cachetArtiste"
                        value={budgetEstimatif.cachetArtiste ?? ""}
                        onChange={handleBudgetEstimatifChange}
                        placeholder="150... (en €)"
                        required
                        className="mt-1"
                    />
                </div>
                <div>
                    <Label htmlFor="fraisDeplacement" value="Frais de déplacement total:" />
                    <TextInput
                        disabled={!isTextInputActive}
                        type="number"
                        id="fraisDeplacement"
                        name="fraisDeplacement"
                        value={budgetEstimatif.fraisDeplacement ?? ""}
                        onChange={handleBudgetEstimatifChange}
                        placeholder="500... (en €)"
                        required
                        className="mt-1"
                    />
                </div>
            </div>

            <div className="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <Label htmlFor="fraisHebergement" value="Frais d'hébergement total:" />
                    <TextInput
                        disabled={!isTextInputActive}
                        type="number"
                        id="fraisHebergement"
                        name="fraisHebergement"
                        value={budgetEstimatif.fraisHebergement ?? ""}
                        onChange={handleBudgetEstimatifChange}
                        placeholder="200... (en €)"
                        required
                        className="mt-1"
                    />
                </div>
                <div>
                    <Label htmlFor="fraisRestauration" value="Frais de restauration total:" />
                    <TextInput
                        disabled={!isTextInputActive}
                        type="number"
                        id="fraisRestauration"
                        name="fraisRestauration"
                        value={budgetEstimatif.fraisRestauration ?? ""}
                        onChange={handleBudgetEstimatifChange}
                        placeholder="75... (en €)"
                        required
                        className="mt-1"
                    />
                </div>
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

export default BudgetEstimatifForm;
