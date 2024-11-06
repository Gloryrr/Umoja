"use client";
import React from 'react';

interface BudgetEstimatifFormProps {
    budgetEstimatif: {
        cachetArtiste: number;
        fraisDeplacement: number;
        fraisHebergement: number;
        fraisRestauration: number;
    };
    onBudgetEstimatifChange: (name: string, value: number) => void;
}

const BudgetEstimatifForm: React.FC<BudgetEstimatifFormProps> = ({
    budgetEstimatif,
    onBudgetEstimatifChange,
}) => {
    const handleBudgetEstmatifChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        onBudgetEstimatifChange(name, Number(value));
    };

    return (
        <div className="flex items-center justify-center">
            <div className="mx-auto w-full max-w bg-white rounded-lg shadow-md p-8">
                <h3 className="text-2xl font-semibold text-[#07074D] mb-4">Budget Estimatif</h3>
                
                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="cachetArtiste" className="text-gray-700">Cachet Artiste:</label>
                        <input
                            type="number"
                            id="cachetArtiste"
                            name="cachetArtiste"
                            value={budgetEstimatif.cachetArtiste || 0}
                            onChange={handleBudgetEstmatifChange}
                            required
                            placeholder="Cachet de l'artiste"
                            className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                    <div>
                        <label htmlFor="fraisDeplacement" className="text-gray-700">Frais de Déplacement:</label>
                        <input
                            type="number"
                            id="fraisDeplacement"
                            name="fraisDeplacement"
                            value={budgetEstimatif.fraisDeplacement || 0}
                            onChange={handleBudgetEstmatifChange}
                            required
                            placeholder="Frais de déplacement"
                            className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                </div>

                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="fraisHebergement" className="text-gray-700">Frais d&apos;Hébergement:</label>
                        <input
                            type="number"
                            id="fraisHebergement"
                            name="fraisHebergement"
                            value={budgetEstimatif.fraisHebergement || 0}
                            onChange={handleBudgetEstmatifChange}
                            required
                            placeholder="Frais d'hébergement"
                            className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                    <div>
                        <label htmlFor="fraisRestauration" className="text-gray-700">Frais de Restauration:</label>
                        <input
                            type="number"
                            id="fraisRestauration"
                            name="fraisRestauration"
                            value={budgetEstimatif.fraisRestauration || 0}
                            onChange={handleBudgetEstmatifChange}
                            required
                            placeholder="Frais de restauration"
                            className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                </div>
            </div>
        </div>
    );
};

export default BudgetEstimatifForm;