"use client";
import React from 'react';
import {Label, TextInput, Textarea, Card, Button } from 'flowbite-react';
import { FiRefreshCw } from "react-icons/fi";

interface ExtrasFormProps {
    extras: {
        descrExtras: string | null;
        coutExtras: number | null;
        exclusivite: string | null;
        exception: string | null;
        ordrePassage: string | null;
        clausesConfidentialites: string | null;
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

    const handleReset = () => {
        onExtrasChange("descrExtras", "");
        onExtrasChange("coutExtras", "");
        onExtrasChange("exclusivite", "");
        onExtrasChange("exception", "");
        onExtrasChange("ordrePassage", "");
        onExtrasChange("clausesConfidentialites", "");
    };

    return (
        <Card className="shadow-none border-none mx-auto w-full">
            <div className="flex justify-between items-center mb-4">
                <h3 className="text-2xl font-semibold mb-4">Conditions spécifiques à l&apos;offre</h3>
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

            {/* Section description et coût */}
            <div className="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <Label htmlFor="descrExtras" value="Description de l'extras:" />
                    <TextInput
                        id="descrExtras"
                        name="descrExtras"
                        type="text"
                        value={extras.descrExtras ?? ""}
                        onChange={handleExtrasChange}
                        placeholder="Transport offert pour les invités spéciaux..."
                    />
                </div>
                <div>
                    <Label htmlFor="coutExtras" value="Coût total des extras" />
                    <TextInput
                        id="coutExtras"
                        name="coutExtras"
                        type="number"
                        value={extras.coutExtras ?? ""}
                        onChange={handleExtrasChange}
                        placeholder="250... (en €)"
                    />
                </div>
            </div>

            {/* Section exclusivité et exception */}
            <div className="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <Label htmlFor="exclusivite" value="Exclusivité proposée pour l'évènement:" />
                    <TextInput
                        id="exclusivite"
                        name="exclusivite"
                        type="text"
                        value={extras.exclusivite ?? ""}
                        onChange={handleExtrasChange}
                        placeholder="Exclusivité territoriale..."
                    />
                </div>
                <div>
                    <Label htmlFor="exception" value="Exception de l'extras:" />
                    <TextInput
                        id="exception"
                        name="exception"
                        type="text"
                        value={extras.exception ?? ""}
                        onChange={handleExtrasChange}
                        placeholder="Sauf pour les artistes suivants..."
                    />
                </div>
            </div>

            {/* Section ordre de passage et clauses de confidentialité */}
            <div className="grid gap-4 mb-5">
                <div>
                    <Label htmlFor="ordrePassage" value="Ordre de passage des artistes durant l'évènement:" />
                    <TextInput
                        id="ordrePassage"
                        name="ordrePassage"
                        type="text"
                        value={extras.ordrePassage ?? ""}
                        onChange={handleExtrasChange}
                        placeholder="Artiste 1 - Artiste 2 - Artiste 3..."
                        className='w-full'
                    />
                </div>
            </div>
            <div>
                <Label htmlFor="clausesConfidentialites" value="Clauses de confidentialité pour l'évènement:" />
                <Textarea
                    id="clausesConfidentialites"
                    name="clausesConfidentialites"
                    value={extras.clausesConfidentialites ?? ""}
                    onChange={handleExtrasChange}
                    placeholder="Les artistes ne peuvent pas divulguer les informations de l'évènement..."
                    className='w-full'
                />
            </div>

            {/* Bouton de suppression */}
            {/* <Button color="failure" onClick={() => onRemove(0)} pill className="mt-2">
                Supprimer Extras
            </Button> */}
        </Card>
    );
};

export default ExtrasForm;
