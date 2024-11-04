"use client";
import React from 'react';

const ConditionsFinancieresForm: React.FC<{
    conditionsFinancieresData: any;
    onChange: (updatedData: any) => void;
}> = ({ conditionsFinancieresData, onChange }) => {
    const handleConditionsFinancieresChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        onChange({ ...conditionsFinancieresData, [name]: value });
    };

    return (
        <div className="flex flex-col bg-gray-100 p-4 rounded-lg mb-4">
            <div className="col-span-full flex flex-col">
                <h3 className="text-xl font-semibold text-gray-800 mb-4">Conditions financières</h3>
                <label htmlFor="minimumGaranti" className="text-gray-700">Minimum Garanti:</label>
                <input
                    type="number"
                    id="minimumGaranti"
                    name="minimumGaranti"
                    value={conditionsFinancieresData.minimumGaranti}
                    onChange={handleConditionsFinancieresChange}
                    required
                    placeholder="Minimum garanti"
                    className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                />
            </div>
            <div className="flex flex-col">
                <label htmlFor="conditionsPaiement" className="text-gray-700">Conditions de Paiement:</label>
                <input
                    type="text"
                    id="conditionsPaiement"
                    name="conditionsPaiement"
                    value={conditionsFinancieresData.conditionsPaiement}
                    onChange={handleConditionsFinancieresChange}
                    required
                    placeholder="Conditions de paiement"
                    className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                />
            </div>
            <div className="flex flex-col">
                <label htmlFor="pourcentageRecette" className="text-gray-700">Pourcentage de Recette:</label>
                <input
                    type="number"
                    id="pourcentageRecette"
                    name="pourcentageRecette"
                    value={conditionsFinancieresData.pourcentageRecette}
                    onChange={handleConditionsFinancieresChange}
                    required
                    placeholder="15%"
                    className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                />
            </div>
        </div>
    );
};

export default ConditionsFinancieresForm;