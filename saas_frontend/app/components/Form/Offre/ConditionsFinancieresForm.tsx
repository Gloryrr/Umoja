"use client";
import React from 'react';

interface ConditionsFinancieresFormProps {
    conditionsFinancieres: {
        minimumGaranti: string;
        conditionsPaiement: string;
        pourcentageRecette: string;
    };
    onConditionsFinancieresChange: (name: string, value: string) => void;
}

const ConditionsFinancieresForm: React.FC<ConditionsFinancieresFormProps> = ({
    conditionsFinancieres,
    onConditionsFinancieresChange,
}) => {
    const handleConditionsFinancieresChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        onConditionsFinancieresChange(name, value);
    };

    return (
        <div className="flex items-center justify-center">
            <div className="mx-auto w-full max-w bg-white rounded-lg shadow-md p-8">
                <h3 className="text-2xl font-semibold text-[#07074D] mb-4">Conditions financières</h3>
                
                {/* Group Minimum Garanti and Conditions de Paiement */}
                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="minimumGaranti" className="text-gray-700">Minimum Garanti:</label>
                        <input
                            type="number"
                            id="minimumGaranti"
                            name="minimumGaranti"
                            value={conditionsFinancieres.minimumGaranti}
                            onChange={handleConditionsFinancieresChange}
                            required
                            placeholder="Minimum garanti"
                            className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>

                    <div>
                        <label htmlFor="conditionsPaiement" className="text-gray-700">Conditions de Paiement:</label>
                        <input
                            type="text"
                            id="conditionsPaiement"
                            name="conditionsPaiement"
                            value={conditionsFinancieres.conditionsPaiement}
                            onChange={handleConditionsFinancieresChange}
                            required
                            placeholder="Conditions de paiement"
                            className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                </div>

                {/* Group Pourcentage de Recette */}
                <div className="mb-5">
                    <label htmlFor="pourcentageRecette" className="text-gray-700">Pourcentage de Recette:</label>
                    <input
                        type="number"
                        id="pourcentageRecette"
                        name="pourcentageRecette"
                        value={conditionsFinancieres.pourcentageRecette}
                        onChange={handleConditionsFinancieresChange}
                        required
                        placeholder="15%"
                        className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                    />
                </div>
            </div>
        </div>
    );
};

export default ConditionsFinancieresForm;
