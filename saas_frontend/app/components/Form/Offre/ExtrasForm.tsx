"use client";
import React from 'react';

interface ExtrasFormProps {
    extras: {
        descrExtras: string;
        coutExtras: string;
        exclusivite: string;
        exception: string;
        ordrePassage: string;
        clausesConfidentialites: string;
    };
    onExtrasChange: (name: string, value: string) => void;
}

const ExtrasForm: React.FC<ExtrasFormProps> = ({
    extras,
    onExtrasChange,
}) => {
    const handleExtrasChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        onExtrasChange(name, value);
    };

    return (
        <div className="flex items-center justify-center">
            <div className="mx-auto w-full max-w bg-white rounded-lg shadow-md p-8">
                <h3 className="text-2xl font-semibold text-[#07074D] mb-4">Extras de l'offre</h3>
                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="descrExtras" className="text-gray-700">Description de l'extras:</label>
                        <input
                            type="text"
                            id='descrExtras'
                            name="descrExtras"
                            value={extras.descrExtras}
                            onChange={handleExtrasChange}
                            placeholder="Description des Extras"
                            className="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                    <div>
                        <label htmlFor="coutExtras" className="text-gray-700">Coût des extras:</label>
                        <input
                            type="number"
                            name="coutExtras"
                            id='coutExtras'
                            value={extras.coutExtras}
                            onChange={handleExtrasChange}
                            placeholder="Coût des Extras"
                            className="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                </div>

                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="exclusivite" className="text-gray-700">Exclusivité proposée:</label>
                        <input
                            type="text"
                            id='exclusivite'
                            name="exclusivite"
                            value={extras.exclusivite}
                            onChange={handleExtrasChange}
                            placeholder="Exclusivité"
                            className="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>

                    <div>
                        <label htmlFor="exception" className="text-gray-700">Exception de l'extras:</label>
                        <input
                            type="text"
                            id='exception'
                            name="exception"
                            value={extras.exception}
                            onChange={handleExtrasChange}
                            placeholder="Exceptions"
                            className="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                </div>

                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="ordrePassage" className="text-gray-700">Ordre de passage:</label>
                        <input
                            type="text"
                            id='ordrePassage'
                            name="ordrePassage"
                            value={extras.ordrePassage}
                            onChange={handleExtrasChange}
                            placeholder="Ordre de Passage"
                            className="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>

                    <div>
                        <label htmlFor="clausesConfidentialites" className="text-gray-700">Clauses de confidentialité:</label>
                        <textarea
                            name="clausesConfidentialites"
                            id='clausesConfidentialites'
                            value={extras.clausesConfidentialites}
                            onChange={handleExtrasChange}
                            placeholder="Clauses de Confidentialité"
                            className="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                </div>

                {/* <button
                    type="button"
                    onClick={() => onRemove(0)} // Appelle la fonction de suppression
                    className="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 mt-2"
                >
                    Supprimer Extras
                </button> */}
            </div>
        </div>
    );
};

export default ExtrasForm;
