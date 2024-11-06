"use client";
import React from 'react';
import NavigationHandler from '@/app/navigation/Router';
import OffreForm from '@/app/components/Form/Offre/OffreForm';

export default function Offre() {
    return (
        <div className="relative w-full flex items-center justify-center">
            <div className="absolute top-4 left-4">
                <NavigationHandler>
                    {(handleNavigation: (path: string) => void) => (
                        <button
                            onClick={() => handleNavigation('/home')}
                            className="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 font-semibold"
                        >
                            Retour à l'accueil
                        </button>
                    )}
                </NavigationHandler>
            </div>
            <OffreForm />
        </div>
    );
}
