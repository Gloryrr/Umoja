import React, { useState, useEffect } from 'react';
import { Button } from 'flowbite-react';
import { FaDownload } from 'react-icons/fa';

interface DownloadButtonProps {
    donneePDFbase64: string | null;
}

const DownloadButton: React.FC<DownloadButtonProps> = ({ donneePDFbase64 }) => {
    const [pdfData, setPdfData] = useState<string | null>(null);

    const downloadFile = () => {
        if (!pdfData) {
            console.error('Aucune donnée PDF disponible pour le téléchargement.');
            return;
        }

        try {
            // Convertir les données base64 en un blob
            const byteCharacters = atob(pdfData); // Décodage du base64
            const byteNumbers = Array.from(byteCharacters).map((char) => char.charCodeAt(0));
            const byteArray = new Uint8Array(byteNumbers);

            // Créer un blob à partir du tableau d'octets
            const blob = new Blob([byteArray], { type: 'application/pdf' });

            // Créer une URL pour le téléchargement
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'file.pdf'); // Nom du fichier
            document.body.appendChild(link);
            link.click();

            // Nettoyer l'élément et révoquer l'URL pour libérer la mémoire
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);
        } catch (error) {
            console.error('Erreur lors du traitement des données base64 :', error);
        }
    };

    useEffect(() => {
        if (donneePDFbase64) {
            setPdfData(donneePDFbase64);
        } else {
            console.warn('donneePDFbase64 est vide ou null.');
        }
    }, [donneePDFbase64]);

    return (
        <Button 
            onClick={downloadFile} 
            disabled={!pdfData}
            className='flex items-center'
        >
            {pdfData ? 'Télécharger le document PDF' : 'Aucun fichier à télécharger'}
            <FaDownload size={20} className="ml-2 mt-auto mb-auto" />
        </Button>
    );
};

export default DownloadButton;
