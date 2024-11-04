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
        <div className="flex flex-col bg-gray-100 p-4 rounded-lg mb-4">
            <div className="col-span-full flex flex-col">
                <h3 className="text-xl font-semibold text-gray-800 mb-4">Budget Estimatif</h3>
                <label htmlFor="cachetArtiste" className="text-gray-700">Cachet Artiste:</label>
                <input
                    type="number"
                    id="cachetArtiste"
                    name="cachetArtiste"
                    value={budgetEstimatifData.cachetArtiste}
                    onChange={handleBudgetEstimatifChange}
                    required
                    placeholder="Cachet de l'artiste"
                    className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                />
            </div>
            <div className="flex flex-col">
                <label htmlFor="fraisDeplacement" className="text-gray-700">Frais de Déplacement:</label>
                <input
                    type="number"
                    id="fraisDeplacement"
                    name="fraisDeplacement"
                    value={budgetEstimatifData.fraisDeplacement}
                    onChange={handleBudgetEstimatifChange}
                    required
                    placeholder="Frais de déplacement"
                    className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                />
            </div>
            <div className="flex flex-col">
                <label htmlFor="fraisHebergement" className="text-gray-700">Frais d'Hébergement:</label>
                <input
                    type="number"
                    id="fraisHebergement"
                    name="fraisHebergement"
                    value={budgetEstimatifData.fraisHebergement}
                    onChange={handleBudgetEstimatifChange}
                    required
                    placeholder="Frais d'hébergement"
                    className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                />
            </div>
            <div className="flex flex-col">
                <label htmlFor="fraisRestauration" className="text-gray-700">Frais de Restauration:</label>
                <input
                    type="number"
                    id="fraisRestauration"
                    name="fraisRestauration"
                    value={budgetEstimatifData.fraisRestauration}
                    onChange={handleBudgetEstimatifChange}
                    required
                    placeholder="Frais de restauration"
                    className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                />
            </div>
        </div>
    );
};

export default BudgetEstimatifForm;