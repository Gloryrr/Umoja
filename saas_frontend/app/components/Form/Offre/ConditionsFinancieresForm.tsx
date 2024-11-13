"use client";
import React, { useEffect, useState } from 'react';
import { apiGet } from '@/app/services/externalApiClients';
import { Card, Label, TextInput, Select } from 'flowbite-react';

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

    const [conditionsPaiement, setConditionsPaiement] = useState<string[]>([]);

    useEffect(() => {
        const fetchMonnaieExistantes = async () => {
            try {
                const data: { currencies: Record<string, unknown> }[] = await apiGet('https://restcountries.com/v3.1/all');
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
            <h3 className="text-2xl font-semibold mb-4">Conditions financières</h3>

            <div className="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <Label htmlFor="minimumGaranti" value="Minimum Garanti:" />
                    <TextInput
                        type="number"
                        id="minimumGaranti"
                        name="minimumGaranti"
                        value={conditionsFinancieres.minimumGaranti || undefined}
                        onChange={handleConditionsFinancieresChange}
                        required
                        placeholder="Minimum garanti"
                        className="mt-1"
                    />
                </div>

                <div>
                    <Label htmlFor="conditionsPaiement" value="Conditions de Paiement:" />
                    <Select
                        id="conditionsPaiement"
                        name="conditionsPaiement"
                        value={conditionsFinancieres.conditionsPaiement || undefined}
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
                <Label htmlFor="pourcentageRecette" value="Pourcentage de Recette:" />
                <TextInput
                    type="number"
                    id="pourcentageRecette"
                    name="pourcentageRecette"
                    value={conditionsFinancieres.pourcentageRecette || undefined}
                    onChange={handleConditionsFinancieresChange}
                    required
                    placeholder="15.5%"
                    className="mt-1"
                />
            </div>
        </Card>
    );
};

export default ConditionsFinancieresForm;
