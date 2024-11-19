import React from 'react';
import { Button } from 'flowbite-react';
import { useRouter } from 'next/navigation';

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
    const router = useRouter();

    const handleVoirPlus = () => {
        router.push(`/umodja/mes-offres/detail/${offreId}`);
    };

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
                        <Button size="sm" color="success" onClick={handleVoirPlus}>
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
