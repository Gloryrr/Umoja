"use client";
import React from 'react';

const BudgetEstimatifForm: React.FC<{
    budgetEstimatifData: any;
    onChange: (updatedData: any) => void;
}> = ({ budgetEstimatifData, onChange }) => {
    const handleBudgetEstimatifChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        onChange({ ...budgetEstimatifData, [name]: value });
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
                            value={budgetEstimatifData.cachetArtiste}
                            onChange={handleBudgetEstimatifChange}
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
                            value={budgetEstimatifData.fraisDeplacement}
                            onChange={handleBudgetEstimatifChange}
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
                            value={budgetEstimatifData.fraisHebergement}
                            onChange={handleBudgetEstimatifChange}
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
                            value={budgetEstimatifData.fraisRestauration}
                            onChange={handleBudgetEstimatifChange}
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