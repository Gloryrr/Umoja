"use client";
import React from 'react';
import {Label, TextInput, Textarea, Card } from 'flowbite-react';

interface ExtrasFormProps {
    extras: {
        descrExtras: string;
        coutExtras: number;
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
                <Card className="mx-auto w-full max-w p-8">
                    <h3 className="text-2xl font-semibold mb-4">Extras de l&apos;offre</h3>
    
                    {/* Section description et coût */}
                    <div className="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <Label htmlFor="descrExtras" value="Description de l'extras" />
                            <TextInput
                                id="descrExtras"
                                name="descrExtras"
                                type="text"
                                value={extras.descrExtras}
                                onChange={handleExtrasChange}
                                placeholder="Description des Extras"
                            />
                        </div>
                        <div>
                            <Label htmlFor="coutExtras" value="Coût des extras" />
                            <TextInput
                                id="coutExtras"
                                name="coutExtras"
                                type="number"
                                value={extras.coutExtras || 0}
                                onChange={handleExtrasChange}
                                placeholder="Coût des Extras"
                            />
                        </div>
                    </div>
    
                    {/* Section exclusivité et exception */}
                    <div className="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <Label htmlFor="exclusivite" value="Exclusivité proposée" />
                            <TextInput
                                id="exclusivite"
                                name="exclusivite"
                                type="text"
                                value={extras.exclusivite}
                                onChange={handleExtrasChange}
                                placeholder="Exclusivité"
                            />
                        </div>
                        <div>
                            <Label htmlFor="exception" value="Exception de l'extras" />
                            <TextInput
                                id="exception"
                                name="exception"
                                type="text"
                                value={extras.exception}
                                onChange={handleExtrasChange}
                                placeholder="Exceptions"
                            />
                        </div>
                    </div>
    
                    {/* Section ordre de passage et clauses de confidentialité */}
                    <div className="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <Label htmlFor="ordrePassage" value="Ordre de passage" />
                            <TextInput
                                id="ordrePassage"
                                name="ordrePassage"
                                type="text"
                                value={extras.ordrePassage}
                                onChange={handleExtrasChange}
                                placeholder="Ordre de Passage"
                            />
                        </div>
                        <div>
                            <Label htmlFor="clausesConfidentialites" value="Clauses de confidentialité" />
                            <Textarea
                                id="clausesConfidentialites"
                                name="clausesConfidentialites"
                                value={extras.clausesConfidentialites}
                                onChange={handleExtrasChange}
                                placeholder="Clauses de Confidentialité"
                            />
                        </div>
                    </div>
    
                    {/* Bouton de suppression */}
                    {/* <Button color="failure" onClick={() => onRemove(0)} pill className="mt-2">
                        Supprimer Extras
                    </Button> */}
                </Card>
            </div>
        );    
};

export default ExtrasForm;
