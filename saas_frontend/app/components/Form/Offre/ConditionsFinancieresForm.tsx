"use client";
import React, { useEffect, useState } from "react";
import { apiGet } from "@/app/services/externalApiClients";
import { Card, Label, TextInput, Select, Button } from "flowbite-react";
import { FiRefreshCw } from "react-icons/fi";

interface ConditionsFinancieresFormProps {
    conditionsFinancieres: {
        minimumGaranti: number | null;
        conditionsPaiement: string | null;
        pourcentageRecette: number | null;
    };
    onConditionsFinancieresChange: (name: string, value: string) => void;
}

const ConditionsFinancieresForm: React.FC<ConditionsFinancieresFormProps> = ({
    conditionsFinancieres,
    onConditionsFinancieresChange,
}) => {
    const handleConditionsFinancieresChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        onConditionsFinancieresChange(name, value);
    };

    const handleReset = () => {
        onConditionsFinancieresChange("minimumGaranti", "");
        onConditionsFinancieresChange("conditionsPaiement", "");
        onConditionsFinancieresChange("pourcentageRecette", "");
    };

    const [conditionsPaiement, setConditionsPaiement] = useState<string[]>([]);

    useEffect(() => {
        const fetchMonnaieExistantes = async () => {
            try {
                const data: { currencies: Record<string, unknown> }[] = await apiGet("https://restcountries.com/v3.1/all");
                const monnaieList = Array.from(
                    new Set(data.flatMap((country) => Object.keys(country.currencies || {})))
                );
                setConditionsPaiement(monnaieList);
            } catch (error) {
                console.error("Erreur lors de la récupération des monnaies existantes :", error);
            }
        };

        fetchMonnaieExistantes();
    }, []);

    return (
        <Card className="shadow-none border-none mx-auto w-full">
            <div className="flex justify-between items-center mb-4">
                <h3 className="text-2xl font-semibold">Conditions financières</h3>
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
                    <Label htmlFor="minimumGaranti" value="Minimum garanti récolté à la fin de l'évènement:" />
                    <TextInput
                        type="number"
                        id="minimumGaranti"
                        name="minimumGaranti"
                        value={conditionsFinancieres.minimumGaranti ?? ""}
                        onChange={handleConditionsFinancieresChange}
                        required
                        placeholder="1500... (en €)"
                        className="mt-1"
                    />
                </div>

                <div>
                    <Label htmlFor="conditionsPaiement" value="Conditions de paiement des participants:" />
                    <Select
                        id="conditionsPaiement"
                        name="conditionsPaiement"
                        value={conditionsFinancieres.conditionsPaiement ?? ""}
                        onChange={handleConditionsFinancieresChange}
                        required
                        className="mt-1"
                    >
                        <option value="">Sélectionnez une monnaie</option>
                        {conditionsPaiement.map((monnaie, index) => (
                            <option key={index} value={monnaie}>
                                {monnaie}
                            </option>
                        ))}
                    </Select>
                </div>
            </div>

            <div className="mb-5">
                <Label htmlFor="pourcentageRecette" value="Pourcentage sur les recette de billetterie:" />
                <TextInput
                    type="number"
                    step={0.01}
                    id="pourcentageRecette"
                    name="pourcentageRecette"
                    value={conditionsFinancieres.pourcentageRecette ?? ""}
                    onChange={handleConditionsFinancieresChange}
                    required
                    placeholder="10.0... (en %)"
                    className="mt-1"
                />
            </div>
        </Card>
    );
};

export default ConditionsFinancieresForm;
