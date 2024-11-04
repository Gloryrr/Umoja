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
            <div className="col-span-full flex flex-col">
            <h3 className="text-xl font-semibold text-gray-800 mb-4">Extras de l'offre</h3>
                <label htmlFor="descrExtras" className="text-gray-700">Description de l'extras:</label>
                <input
                    type="text"
                    id='descrExtras'
                    name="descrExtras"
                    value={extrasData.descrExtras}
                    onChange={handleConditionsFinancieresChange}
                    placeholder="Description des Extras"
                    className="px-3 py-2 border rounded-lg"
                />
                <label htmlFor="coutExtras" className="text-gray-700">Coût des extras:</label>
                <input
                    type="number"
                    name="coutExtras"
                    id='coutExtras'
                    value={extrasData.coutExtras}
                    onChange={handleConditionsFinancieresChange}
                    placeholder="Coût des Extras"
                    className="px-3 py-2 border rounded-lg"
                />
                <label htmlFor="besoinBackline" className="text-gray-700">Exclusivité proposée:</label>
                <input
                    type="text"
                    id='exclusivite'
                    name="exclusivite"
                    value={extrasData.exclusivite}
                    onChange={handleConditionsFinancieresChange}
                    placeholder="Exclusivité"
                    className="px-3 py-2 border rounded-lg"
                />
                <label htmlFor="besoinBackline" className="text-gray-700">Exception de l'extras:</label>
                <input
                    type="text"
                    id='exception'
                    name="exception"
                    value={extrasData.exception}
                    onChange={handleConditionsFinancieresChange}
                    placeholder="Exceptions"
                    className="px-3 py-2 border rounded-lg"
                />
                <label htmlFor="besoinBackline" className="text-gray-700">Ordre de passage:</label>
                <input
                    type="text"
                    id='ordrePassage'
                    name="ordrePassage"
                    value={extrasData.ordrePassage}
                    onChange={handleConditionsFinancieresChange}
                    placeholder="Ordre de Passage"
                    className="px-3 py-2 border rounded-lg"
                />
                <label htmlFor="besoinBackline" className="text-gray-700">Les clauses de confidentialités:</label>
                <textarea
                    name="clausesConfidentialites"
                    id='clausesConfidentialites'
                    value={extrasData.clausesConfidentialites}
                    onChange={handleConditionsFinancieresChange}
                    placeholder="Clauses de Confidentialité"
                    className="px-3 py-2 border rounded-lg"
                />
                <button
                    type="button"
                    // onClick={() => onRemove(0)} // Appelle la fonction de suppression
                    className="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 mt-2"
                >
                    Supprimer Extras
                </button>
            </div>
        </div>
    );
};

export default ExtrasForm;
