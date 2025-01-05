"use client";
import React, { useState } from 'react';
import { Card, Label, TextInput, Button, Checkbox, Spinner, FileInput } from 'flowbite-react';
import { FiRefreshCw } from "react-icons/fi";
import { apiPostSFTP } from '@/app/services/internalApiClients';

interface BudgetEstimatifFormProps {
    budgetEstimatif: {
        budgetEstimatifParPDF: boolean | null;
        cachetArtiste: number | null;
        fraisDeplacement: number | null;
        fraisHebergement: number | null;
        fraisRestauration: number | null;
    };
    onBudgetEstimatifChange: (name: string, value: number | boolean) => void;
}

const BudgetEstimatifForm: React.FC<BudgetEstimatifFormProps> = ({
    budgetEstimatif,
    onBudgetEstimatifChange,
}) => {
    const [file, setFile] = useState<File | null>(null);
    const [message, setMessage] = useState('');
    const [loading, setLoading] = useState(false);
    const [colorMessage, setColorMessage] = useState('success');
    const [isTextInputActive, setIsTextInputActive] = useState(true);

    const handleBudgetEstimatifChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value, type } = e.target as HTMLInputElement;
        const newValue = type === "checkbox" ? !budgetEstimatif.budgetEstimatifParPDF : parseFloat(value);

        console.log(name, newValue);
        
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

    const handleSubmit = async (e: React.FormEvent) => {
        setLoading(true);
        e.preventDefault();

        if (!file) {
            setMessage('Veuillez sélectionner un fichier PDF');
            setLoading(false);
            return;
        }

        const formData = new FormData();
        formData.append('file', file);
        formData.append('idProjet', "120");
        formData.append('typeFichier', "budget-estimatif");

        await apiPostSFTP('/upload-sftp-fichier', formData).then(
            () => {
                setColorMessage('text-green-500');
                setMessage('Le fichier a été transféré avec succès');
                setLoading(false);
            }
        ).catch(() => {
            setColorMessage('text-red-500');
            setMessage('Erreur lors du transfert du fichier, veuillez réessayer');
            setLoading(false);
        });
    };

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
                />
                <Button
                    className="ml-auto"
                    color="light"
                    type="submit"
                    onClick={handleSubmit}
                    disabled={isTextInputActive}
                >
                    {loading ? <Spinner size="sm" /> : "Transférer"}
                </Button>
            </div>

            {message && <p className={colorMessage}>{message}</p>}

        </Card>
    );
};

export default BudgetEstimatifForm;
