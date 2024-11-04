"use client";
import React from 'react';

const ExtrasForm: React.FC<{
    extrasData: any;
    onChange: (updatedData: any) => void;
    // onRemove: (index: number) => void;
}> = ({ extrasData, onChange, /* onRemove */ }) => {
    const handleConditionsFinancieresChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        onChange({ ...extrasData, [name]: value });
    };

    return (
        <div className="flex flex-col bg-gray-100 p-4 rounded-lg mb-4">
            <div className="flex flex-col space-y-2">
                <input
                    type="text"
                    name="descrExtras"
                    value={extrasData.descrExtras}
                    onChange={handleConditionsFinancieresChange}
                    placeholder="Description des Extras"
                    className="px-3 py-2 border rounded-lg"
                />
                <input
                    type="number"
                    name="coutExtras"
                    value={extrasData.coutExtras}
                    onChange={handleConditionsFinancieresChange}
                    placeholder="Coût des Extras"
                    className="px-3 py-2 border rounded-lg"
                />
                <input
                    type="text"
                    name="exclusivite"
                    value={extrasData.exclusivite}
                    onChange={handleConditionsFinancieresChange}
                    placeholder="Exclusivité"
                    className="px-3 py-2 border rounded-lg"
                />
                <input
                    type="text"
                    name="exception"
                    value={extrasData.exception}
                    onChange={handleConditionsFinancieresChange}
                    placeholder="Exceptions"
                    className="px-3 py-2 border rounded-lg"
                />
                <input
                    type="text"
                    name="ordrePassage"
                    value={extrasData.ordrePassage}
                    onChange={handleConditionsFinancieresChange}
                    placeholder="Ordre de Passage"
                    className="px-3 py-2 border rounded-lg"
                />
                <textarea
                    name="clausesConfidentialites"
                    value={extrasData.clausesConfidentialites}
                    onChange={handleConditionsFinancieresChange}
                    placeholder="Clauses de Confidentialité"
                    className="px-3 py-2 border rounded-lg"
                />
                <button
                    type="button"
                    // onClick={() => onRemove(0)} // Appelle la fonction de suppression
                    className="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600"
                >
                    Supprimer Extras
                </button>
            </div>
        </div>
    );
};

export default ExtrasForm;
