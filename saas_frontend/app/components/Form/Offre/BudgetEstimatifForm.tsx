"use client";
import React from 'react';
import { Card, Label, TextInput, Button } from 'flowbite-react';
import { FiRefreshCw } from "react-icons/fi";

interface BudgetEstimatifFormProps {
    budgetEstimatif: {
        cachetArtiste: number | null;
        fraisDeplacement: number | null;
        fraisHebergement: number | null;
        fraisRestauration: number | null;
    };
    onBudgetEstimatifChange: (name: string, value: number) => void;
}

const BudgetEstimatifForm: React.FC<BudgetEstimatifFormProps> = ({
    budgetEstimatif,
    onBudgetEstimatifChange,
}) => {
    const handleBudgetEstimatifChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        onBudgetEstimatifChange(name, Number(value));
    };

    const handleReset = () => {
        onBudgetEstimatifChange("cachetArtiste", 0);
        onBudgetEstimatifChange("fraisDeplacement", 0);
        onBudgetEstimatifChange("fraisHebergement", 0);
        onBudgetEstimatifChange("fraisRestauration", 0);
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

            <div className="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <Label htmlFor="cachetArtiste" value="Cachet Artiste:" />
                    <TextInput
                        type="number"
                        id="cachetArtiste"
                        name="cachetArtiste"
                        value={budgetEstimatif.cachetArtiste ?? ""}
                        onChange={handleBudgetEstimatifChange}
                        placeholder="Cachet de l'artiste"
                        required
                        className="mt-1"
                    />
                </div>
                <div>
                    <Label htmlFor="fraisDeplacement" value="Frais de Déplacement:" />
                    <TextInput
                        type="number"
                        id="fraisDeplacement"
                        name="fraisDeplacement"
                        value={budgetEstimatif.fraisDeplacement ?? ""}
                        onChange={handleBudgetEstimatifChange}
                        placeholder="Frais de déplacement"
                        required
                        className="mt-1"
                    />
                </div>
            </div>

            <div className="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <Label htmlFor="fraisHebergement" value="Frais d'Hébergement:" />
                    <TextInput
                        type="number"
                        id="fraisHebergement"
                        name="fraisHebergement"
                        value={budgetEstimatif.fraisHebergement ?? ""}
                        onChange={handleBudgetEstimatifChange}
                        placeholder="Frais d'hébergement"
                        required
                        className="mt-1"
                    />
                </div>
                <div>
                    <Label htmlFor="fraisRestauration" value="Frais de Restauration:" />
                    <TextInput
                        type="number"
                        id="fraisRestauration"
                        name="fraisRestauration"
                        value={budgetEstimatif.fraisRestauration ?? ""}
                        onChange={handleBudgetEstimatifChange}
                        placeholder="Frais de restauration"
                        required
                        className="mt-1"
                    />
                </div>
            </div>
        </Card>
    );
};

export default BudgetEstimatifForm;
