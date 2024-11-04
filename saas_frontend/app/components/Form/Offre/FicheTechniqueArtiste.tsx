"use client";
import React from 'react';

const FicheTechniqueArtisteForm: React.FC<{
    ficheTechniqeArtisteData: any;
    onChange: (updatedData: any) => void;
}> = ({ ficheTechniqeArtisteData, onChange }) => {
    const handleFicheTechniqueArtisteChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        onChange({ ...ficheTechniqeArtisteData, [name]: value });
    };

    return (
        <div className="flex flex-col bg-gray-100 p-4 rounded-lg mb-4">
            <div className="col-span-full flex flex-col">
                <h3 className="text-xl font-semibold text-gray-800 mb-4">Fiche Technique Artiste</h3>
                <label htmlFor="besoinBackline" className="text-gray-700">Besoin Backline:</label>
                <input
                    type="text"
                    id="besoinBackline"
                    name="besoinBackline"
                    value={ficheTechniqeArtisteData.besoinBackline}
                    onChange={handleFicheTechniqueArtisteChange}
                    required
                    placeholder="Besoins en backline"
                    className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                />
            </div>
            <div className="flex flex-col">
                <label htmlFor="besoinEclairage" className="text-gray-700">Besoin Éclairage:</label>
                <input
                    type="text"
                    id="besoinEclairage"
                    name="besoinEclairage"
                    value={ficheTechniqeArtisteData.besoinEclairage}
                    onChange={handleFicheTechniqueArtisteChange}
                    required
                    placeholder="Besoins en éclairage"
                    className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                />
            </div>
            <div className="flex flex-col">
                <label htmlFor="besoinEquipements" className="text-gray-700">Besoin Équipements:</label>
                <input
                    type="text"
                    id="besoinEquipements"
                    name="besoinEquipements"
                    value={ficheTechniqeArtisteData.besoinEquipements}
                    onChange={handleFicheTechniqueArtisteChange}
                    required
                    placeholder="Besoins en équipements"
                    className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                />
            </div>
            <div className="flex flex-col">
                <label htmlFor="besoinScene" className="text-gray-700">Besoin Scène:</label>
                <input
                    type="text"
                    id="besoinScene"
                    name="besoinScene"
                    value={ficheTechniqeArtisteData.besoinScene}
                    onChange={handleFicheTechniqueArtisteChange}
                    required
                    placeholder="Besoins en scène"
                    className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                />
            </div>
            <div className="flex flex-col">
                <label htmlFor="besoinSonorisation" className="text-gray-700">Besoin Sonorisation:</label>
                <input
                    type="text"
                    id="besoinSonorisation"
                    name="besoinSonorisation"
                    value={ficheTechniqeArtisteData.besoinSonorisation}
                    onChange={handleFicheTechniqueArtisteChange}
                    required
                    placeholder="Besoins en sonorisation"
                    className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                />
            </div>
        </div>
    );
};

export default FicheTechniqueArtisteForm;