"use client";
import React from 'react';

interface BudgetEstimatifFormProps {
    budgetEstimatif: {
        cachetArtiste: string;
        fraisDeplacement: string;
        fraisHebergement: string;
        fraisRestauration: string;
    };
    onBudgetEstimatifChange: (name: string, value: string) => void;
}

const BudgetEstimatifForm: React.FC<BudgetEstimatifFormProps> = ({
    budgetEstimatif,
    onBudgetEstimatifChange,
}) => {
    const handleBudgetEstmatifChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        onBudgetEstimatifChange(name, value);
    };

    return (
        <div className="flex items-center justify-center">
            <div className="mx-auto w-full max-w bg-white rounded-lg shadow-md p-8">
                <h3 className="text-2xl font-semibold text-[#07074D] mb-4">Budget Estimatif</h3>
                
                {/* Grouped Cachet Artiste and Frais de Déplacement */}
                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="cachetArtiste" className="text-gray-700">Cachet Artiste:</label>
                        <input
                            type="number"
                            id="cachetArtiste"
                            name="cachetArtiste"
                            value={budgetEstimatif.cachetArtiste}
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
                            value={budgetEstimatif.fraisDeplacement}
                            onChange={handleBudgetEstmatifChange}
                            required
                            placeholder="Frais de déplacement"
                            className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                </div>

                {/* Grouped Frais d'Hébergement and Frais de Restauration */}
                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="fraisHebergement" className="text-gray-700">Frais d'Hébergement:</label>
                        <input
                            type="number"
                            id="fraisHebergement"
                            name="fraisHebergement"
                            value={budgetEstimatif.fraisHebergement}
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
                            value={budgetEstimatif.fraisRestauration}
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