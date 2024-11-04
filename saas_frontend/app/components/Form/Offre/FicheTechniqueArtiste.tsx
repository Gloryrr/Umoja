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
        <div className="flex items-center justify-center">
            <div className="mx-auto w-full max-w bg-white">
                <h3 className="text-2xl font-semibold text-[#07074D] mb-4">Fiche Technique Artiste</h3>
                
                {/* Grouped Besoin Backline and Besoin Éclairage */}
                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="besoinBackline" className="text-gray-700">Besoin Backline:</label>
                        <input
                            type="text"
                            id="besoinBackline"
                            name="besoinBackline"
                            value={ficheTechniqeArtisteData.besoinBackline}
                            onChange={handleFicheTechniqueArtisteChange}
                            required
                            placeholder="Besoins en backline"
                            className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>

                    <div>
                        <label htmlFor="besoinEclairage" className="text-gray-700">Besoin Éclairage:</label>
                        <input
                            type="text"
                            id="besoinEclairage"
                            name="besoinEclairage"
                            value={ficheTechniqeArtisteData.besoinEclairage}
                            onChange={handleFicheTechniqueArtisteChange}
                            required
                            placeholder="Besoins en éclairage"
                            className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                </div>

                {/* Grouped Besoin Équipements and Besoin Scène */}
                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="besoinEquipements" className="text-gray-700">Besoin Équipements:</label>
                        <input
                            type="text"
                            id="besoinEquipements"
                            name="besoinEquipements"
                            value={ficheTechniqeArtisteData.besoinEquipements}
                            onChange={handleFicheTechniqueArtisteChange}
                            required
                            placeholder="Besoins en équipements"
                            className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>

                    <div>
                        <label htmlFor="besoinScene" className="text-gray-700">Besoin Scène:</label>
                        <input
                            type="text"
                            id="besoinScene"
                            name="besoinScene"
                            value={ficheTechniqeArtisteData.besoinScene}
                            onChange={handleFicheTechniqueArtisteChange}
                            required
                            placeholder="Besoins en scène"
                            className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                </div>

                {/* Besoin Sonorisation without group */}
                <div className="mb-5">
                    <label htmlFor="besoinSonorisation" className="text-gray-700">Besoin Sonorisation:</label>
                    <input
                        type="text"
                        id="besoinSonorisation"
                        name="besoinSonorisation"
                        value={ficheTechniqeArtisteData.besoinSonorisation}
                        onChange={handleFicheTechniqueArtisteChange}
                        required
                        placeholder="Besoins en sonorisation"
                        className="w-full mt-1 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                    />
                </div>
            </div>
        </div>
    );
};

export default FicheTechniqueArtisteForm;