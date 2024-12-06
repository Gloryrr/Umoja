import { useState } from 'react';
import { Button } from 'flowbite-react';
import Image from 'next/image';

interface Commentaire {
    id: number;
    utilisateur : {
        username : string;
    }
    commentaire: string;
}

interface CommentSectionProps {
    commentaires: Commentaire[];
}

const CommentSection = ({ commentaires }: CommentSectionProps) => {
    (commentaires);
    const [isVisible, setIsVisible] = useState(true);

    const toggleCommentsVisibility = () => {
        setIsVisible(!isVisible);
    };

    return (
        <div className="mt-6 ml-[20%] mr-[20%] mx-auto">
            <h2 className="font-semibold mt-5 mb-3">Les commentaires laissés par les membres du réseau</h2>

            {/* Bouton "Voir les commentaires" */}
            <Button
                onClick={toggleCommentsVisibility}
                className="flex items-center mb-4"
                color='blue'
            >
                <span className="mr-2">Voir les commentaires</span>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    className={`bi bi-chevron-down transition-transform duration-200 ${isVisible ? 'rotate-180' : ''}`}
                    viewBox="0 0 16 16"
                >
                    <path d="M1 4.5a.5.5 0 0 1 .8-.6L8 9.293l6.2-5.393a.5.5 0 1 1 .6.8l-7 6a.5.5 0 0 1-.6 0l-7-6a.5.5 0 0 1-.2-.6z" />
                </svg>
            </Button>

            {/* Affichage conditionnel des commentaires */}
            {isVisible && (
                <div>
                    {commentaires.length === 0 ? (
                        <p>Aucun commentaire pour le moment.</p>
                    ) : (
                        commentaires.map((commentaire, index) => (
                            <div key={index} className="mb-6 p-4 border rounded-lg shadow-md">
                                <div className="flex items-center space-x-4">
                                <Image
                                    src="/favicon.ico"
                                    alt={commentaire.utilisateur?.username || 'Utilisateur inconnu'}
                                    className="w-7 h-7 rounded-full"
                                    width={28}
                                    height={28}
                                />
                                    <div>
                                        <p className="font-semibold text-lg">{commentaire.utilisateur?.username || "Utilisateur inconnu"}</p>
                                    </div>
                                </div>
                                <p className="mt-2">{commentaire.commentaire || "pas de commentaire"}</p>
                            </div>
                        ))
                    )}
                </div>
            )}
        </div>
    );
};

export default CommentSection;
