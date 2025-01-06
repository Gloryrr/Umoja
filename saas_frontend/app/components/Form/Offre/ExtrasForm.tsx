"use client";
import React, { useEffect, useState } from 'react';
import {
    Label,
    TextInput,
    Textarea,
    Card,
    Button,
    FileInput,
    Checkbox,
} from 'flowbite-react';
import { apiPostSFTP } from '@/app/services/internalApiClients';
import { FiRefreshCw } from 'react-icons/fi';

interface ExtrasFormProps {
    extras: {
        extrasParPDF: boolean | null;
        descrExtras: string | null;
        coutExtras: number | null;
        exclusivite: string | null;
        exception: string | null;
        clausesConfidentialites: string | null;
    };
    idProjet: string;
    onExtrasChange: (name: string, value: string | boolean) => void;
}

const ExtrasForm: React.FC<ExtrasFormProps> = ({
    extras,
    onExtrasChange,
    idProjet,
}) => {
    const [offreId, setOffreId] = useState<string>(idProjet);
    const [file, setFile] = useState<File | null>(null);
    const [message, setMessage] = useState('');
    const [colorMessage, setColorMessage] = useState('success');
    const [isTextInputActive, setIsTextInputActive] = useState(true);

    const handleExtrasChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
        const { name, value, type } = e.target as HTMLInputElement;
        const newValue = type === "checkbox" ? !extras.extrasParPDF : value;

        onExtrasChange(name, newValue);
        if (name === 'extrasParPDF') {
            setIsTextInputActive(!isTextInputActive);
        }
    };

    const handleFileChange = async (e: React.ChangeEvent<HTMLInputElement>) => {
        setFile(e.target.files?.[0] || null);
    };

    useEffect(() => {
        setOffreId(idProjet);
    }, [idProjet]);

    useEffect(() => {
        if (offreId && file) {
            const handleSubmit = async () => {
    
                const formData = new FormData();
                formData.append('file', file);
                formData.append('idProjet', offreId.toString());
                formData.append('typeFichier', "extras");
    
                try {
                    await apiPostSFTP('/upload-sftp-fichier', formData);
                    setColorMessage('text-green-500');
                    setMessage('Le fichier a été transféré avec succès');
                } catch (error) {
                    console.error('Erreur lors du transfert du fichier :', error);
                    setColorMessage('text-red-500');
                    setMessage('Erreur lors du transfert du fichier, veuillez réessayer');
                }
            };
    
            handleSubmit();
        }
    }, [offreId, file]);

    const handleReset = () => {
        onExtrasChange("descrExtras", "");
        onExtrasChange("coutExtras", "");
        onExtrasChange("exclusivite", "");
        onExtrasChange("exception", "");
        onExtrasChange("clausesConfidentialites", "");
    };

    return (
        <Card className="shadow-none border-none mx-auto w-full">
            <div className="flex justify-between items-center mb-4">
                <h3 className="text-2xl font-semibold">Extras</h3>
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
            <div className="mb-4">
                <Checkbox
                    checked={isTextInputActive}
                    onChange={handleExtrasChange}
                    id="extrasParPDF"
                    name="extrasParPDF"
                />
                <Label htmlFor="extrasParPDF" className="ml-2">
                    Ne pas importer de PDF
                </Label>
            </div>

            <div>
                {/* Section description et coût */}
                <div className="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <Label htmlFor="descrExtras" value="Description de l'extras:" />
                        <TextInput
                            disabled={!isTextInputActive}
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
                            disabled={!isTextInputActive}
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
                            disabled={!isTextInputActive}
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
                            disabled={!isTextInputActive}
                            id="exception"
                            name="exception"
                            type="text"
                            value={extras.exception ?? ""}
                            onChange={handleExtrasChange}
                            placeholder="Sauf pour les artistes suivants..."
                        />
                    </div>
                </div>

                <div>
                    <Label htmlFor="clausesConfidentialites" value="Clauses de confidentialité pour l'évènement:" />
                    <Textarea
                        disabled={!isTextInputActive}
                        id="clausesConfidentialites"
                        name="clausesConfidentialites"
                        value={extras.clausesConfidentialites ?? ""}
                        onChange={handleExtrasChange}
                        placeholder="Les artistes ne peuvent pas divulguer les informations de l'évènement..."
                        className='w-full'
                    />
                </div>
            </div>
            <div className="flex">
                <FileInput
                    disabled={isTextInputActive}
                    className="w-full mr-5"
                    accept="application/pdf"
                    onChange={handleFileChange}
                />
            </div>

            {message && <p className={colorMessage}>{message}</p>}
        </Card>
    );
};

export default ExtrasForm;
