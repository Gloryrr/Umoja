import React from 'react';
import { Button } from 'flowbite-react';

interface InfoAdditionnelAlertProps {
    isSuccess: boolean;
    description: string;
    offreId: string;
    onDismiss: () => void;
}

const InfoAdditionnelAlert: React.FC<InfoAdditionnelAlertProps> = ({
    isSuccess,
    description,
    offreId,
    onDismiss,
}) => {
    return (
        <div>
            <div className="flex flex-col">
                {/* Description de l'alerte */}
                <span className={isSuccess ? "text-sm font-medium mb-3 text-green-500" : "text-sm font-medium mb-3 text-red-500"}>
                    {description}
                </span>
                {/* Ligne contenant les boutons */}
                <div className="flex justify-start gap-4">
                    {isSuccess && (
                        <Button size="sm" color="success" href={`/umodja/mes-offres/detail/${offreId}`}>
                            Voir plus
                        </Button>
                    )}
                    <Button size="sm" color="light" onClick={onDismiss}>
                        Cacher
                    </Button>
                </div>
            </div>
        </div>
    );
};

export default InfoAdditionnelAlert;
