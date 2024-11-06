"use client";
import React from 'react';

interface FicheTechniqueArtisteFormProps {
    ficheTechniqueArtiste: {
        besoinBackline: string;
        besoinEclairage: string;
        besoinEquipements: string;
        besoinScene: string;
        besoinSonorisation: string;
    };
    onFicheTechniqueChange: (name: string, value: string) => void;
}

const FicheTechniqueArtisteForm: React.FC<FicheTechniqueArtisteFormProps> = ({
    ficheTechniqueArtiste,
    onFicheTechniqueChange,
}) => {
    const handleFicheTechniqueArtisteChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        onFicheTechniqueChange(name, value);
    };

    return (
        <div className="flex items-center justify-center">
            <div className="mx-auto w-full max-w bg-gray-800">
                <h3 className="text-2xl font-semibold text-white mb-4">Fiche Technique Artiste</h3>
                
                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="besoinBackline" className="text-white">Besoin Backline:</label>
                        <input
                            type="text"
                            id="besoinBackline"
                            name="besoinBackline"
                            value={ficheTechniqueArtiste.besoinBackline}
                            onChange={handleFicheTechniqueArtisteChange}
                            required
                            placeholder="Besoins en backline"
                            className="w-full mt-1 rounded-md border border-grey-700 bg-gray-900 py-2 px-3 text-base font-medium text-white outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>

                    <div>
                        <label htmlFor="besoinEclairage" className="text-white">Besoin Éclairage:</label>
                        <input
                            type="text"
                            id="besoinEclairage"
                            name="besoinEclairage"
                            value={ficheTechniqueArtiste.besoinEclairage}
                            onChange={handleFicheTechniqueArtisteChange}
                            required
                            placeholder="Besoins en éclairage"
                            className="w-full mt-1 rounded-md border border-grey-700 bg-gray-900 py-2 px-3 text-base font-medium text-white outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                </div>

                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="besoinEquipements" className="text-white">Besoin Équipements:</label>
                        <input
                            type="text"
                            id="besoinEquipements"
                            name="besoinEquipements"
                            value={ficheTechniqueArtiste.besoinEquipements}
                            onChange={handleFicheTechniqueArtisteChange}
                            required
                            placeholder="Besoins en équipements"
                            className="w-full mt-1 rounded-md border border-grey-700 bg-gray-900 py-2 px-3 text-base font-medium text-white outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>

                    <div>
                        <label htmlFor="besoinScene" className="text-white">Besoin Scène:</label>
                        <input
                            type="text"
                            id="besoinScene"
                            name="besoinScene"
                            value={ficheTechniqueArtiste.besoinScene}
                            onChange={handleFicheTechniqueArtisteChange}
                            required
                            placeholder="Besoins en scène"
                            className="w-full mt-1 rounded-md border border-grey-700 bg-gray-900 py-2 px-3 text-base font-medium text-white outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                </div>

                <div className="mb-5">
                    <label htmlFor="besoinSonorisation" className="text-white">Besoin Sonorisation:</label>
                    <input
                        type="text"
                        id="besoinSonorisation"
                        name="besoinSonorisation"
                        value={ficheTechniqueArtiste.besoinSonorisation}
                        onChange={handleFicheTechniqueArtisteChange}
                        required
                        placeholder="Besoins en sonorisation"
                        className="w-full mt-1 rounded-md border border-grey-700 bg-gray-900 py-2 px-3 text-base font-medium text-white outline-none focus:border-[#6A64F1] focus:shadow-md"
                    />
                </div>
            </div>
        </div>
    );
};

export default FicheTechniqueArtisteForm;