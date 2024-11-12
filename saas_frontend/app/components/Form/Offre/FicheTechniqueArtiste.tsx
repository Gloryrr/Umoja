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
            <div className="mx-auto w-full max-w rounded-lg p-8">
                <h3 className="text-2xl font-semibold mb-4">Fiche Technique Artiste</h3>

                {/* Section Backline et Éclairage */}
                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="besoinBackline"> Besoin Backline:</label>
                        <input
                            type="text"
                            id="besoinBackline"
                            name="besoinBackline"
                            value={ficheTechniqueArtiste.besoinBackline}
                            onChange={handleFicheTechniqueArtisteChange}
                            required
                            placeholder="Besoins en backline"
                            className="w-full mt-1 rounded-md border border-grey-700 py-2 px-3 text-base font-medium outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                    <div>
                        <label htmlFor="besoinEclairage"> Besoin Éclairage:</label>
                        <input
                            type="text"
                            id="besoinEclairage"
                            name="besoinEclairage"
                            value={ficheTechniqueArtiste.besoinEclairage}
                            onChange={handleFicheTechniqueArtisteChange}
                            required
                            placeholder="Besoins en éclairage"
                            className="w-full mt-1 rounded-md border border-grey-700 py-2 px-3 text-base font-medium outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                </div>

                {/* Section Équipements et Scène */}
                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label htmlFor="besoinEquipements"> Besoin Équipements:</label>
                        <input
                            type="text"
                            id="besoinEquipements"
                            name="besoinEquipements"
                            value={ficheTechniqueArtiste.besoinEquipements}
                            onChange={handleFicheTechniqueArtisteChange}
                            required
                            placeholder="Besoins en équipements"
                            className="w-full mt-1 rounded-md border border-grey-700 py-2 px-3 text-base font-medium outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                    <div>
                        <label htmlFor="besoinScene"> Besoin Scène:</label>
                        <input
                            type="text"
                            id="besoinScene"
                            name="besoinScene"
                            value={ficheTechniqueArtiste.besoinScene}
                            onChange={handleFicheTechniqueArtisteChange}
                            required
                            placeholder="Besoins en scène"
                            className="w-full mt-1 rounded-md border border-grey-700 py-2 px-3 text-base font-medium outline-none focus:border-[#6A64F1] focus:shadow-md"
                        />
                    </div>
                </div>

                {/* Section Sonorisation */}
                <div className="mb-5">
                    <label htmlFor="besoinSonorisation"> Besoin Sonorisation:</label>
                    <input
                        type="text"
                        id="besoinSonorisation"
                        name="besoinSonorisation"
                        value={ficheTechniqueArtiste.besoinSonorisation}
                        onChange={handleFicheTechniqueArtisteChange}
                        required
                        placeholder="Besoins en sonorisation"
                        className="w-full mt-1 rounded-md border border-grey-700 py-2 px-3 text-base font-medium outline-none focus:border-[#6A64F1] focus:shadow-md"
                    />
                </div>
            </div>
        </div>
    );
};

export default FicheTechniqueArtisteForm;