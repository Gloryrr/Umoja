"use client";
import React from 'react';
import { TextInput, Label, Card, Button } from 'flowbite-react';
import { FiRefreshCw } from "react-icons/fi";

interface FicheTechniqueArtisteFormProps {
    ficheTechniqueArtiste: {
        besoinBackline: string | null;
        besoinEclairage: string | null;
        besoinEquipements: string | null;
        besoinScene: string | null;
        besoinSonorisation: string | null;
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

    const handleReset = () => {
        onFicheTechniqueChange("besoinBackline", "");
        onFicheTechniqueChange("besoinEclairage", "");
        onFicheTechniqueChange("besoinEquipements", "");
        onFicheTechniqueChange("besoinScene", "");
        onFicheTechniqueChange("besoinSonorisation", "");
    };

    return (
        <Card className="w-full shadow-none border-none">
            <div className="flex justify-between items-center mb-4">
                <h3 className="text-2xl font-semibold mb-4">Fiche Technique Artiste</h3>
                <Button
                    color="gray"
                    onClick={handleReset}
                    pill
                    aria-label="Reset"
                    className="flex items-center"
                >
                    <FiRefreshCw className="w-4 h-4" />
                </Button>
            </div>

            {/* Section Backline et Éclairage */}
            <div className="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <Label htmlFor="besoinBackline" value="Besoin en backline:" />
                    <TextInput
                        id="besoinBackline"
                        name="besoinBackline"
                        value={ficheTechniqueArtiste.besoinBackline ?? ""}
                        onChange={handleFicheTechniqueArtisteChange}
                        placeholder="Nombre d'amplis, enceinte, etc..."
                        required
                    />
                </div>
                <div>
                    <Label htmlFor="besoinEclairage" value="Besoin en éclairage:" />
                    <TextInput
                        id="besoinEclairage"
                        name="besoinEclairage"
                        value={ficheTechniqueArtiste.besoinEclairage ?? ""}
                        onChange={handleFicheTechniqueArtisteChange}
                        placeholder="Nombre de projecteurs, etc..."
                        required
                    />
                </div>
            </div>

            {/* Section Équipements et Scène */}
            <div className="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <Label htmlFor="besoinEquipements" value="Besoin en équipements:" />
                    <TextInput
                        id="besoinEquipements"
                        name="besoinEquipements"
                        value={ficheTechniqueArtiste.besoinEquipements ?? ""}
                        onChange={handleFicheTechniqueArtisteChange}
                        placeholder="Nombre de micros, etc..."
                        required
                    />
                </div>
                <div>
                    <Label htmlFor="besoinScene" value="Besoin pour la scène:" />
                    <TextInput
                        id="besoinScene"
                        name="besoinScene"
                        value={ficheTechniqueArtiste.besoinScene ?? ""}
                        onChange={handleFicheTechniqueArtisteChange}
                        placeholder="Scène de 30m² minimum, etc..."
                        required
                    />
                </div>
            </div>

            {/* Section Sonorisation */}
            <div className="mb-5">
                <Label htmlFor="besoinSonorisation" value="Besoin en sonorisation:" />
                <TextInput
                    id="besoinSonorisation"
                    name="besoinSonorisation"
                    value={ficheTechniqueArtiste.besoinSonorisation ?? ""}
                    onChange={handleFicheTechniqueArtisteChange}
                    placeholder="Console de mixage, etc..."
                    required
                />
            </div>
        </Card>
    );
};

export default FicheTechniqueArtisteForm;