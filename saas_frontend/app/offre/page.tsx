"use client";
import React from 'react';
import NavigationHandler from '@/app/navigation/Router';
import OffreForm from '@/app/components/Form/Offre/OffreForm';
import { Button } from 'flowbite-react';

export default function Offre() {
    return (
        <div className="relative w-full flex items-center justify-center">
            <div className="absolute top-4 left-4">
                <NavigationHandler>
                    {(handleNavigation: (path: string) => void) => (
                        <Button
                            onClick={() => handleNavigation('/accueil')}
                        >
                            Retour à l&apos;accueil
                        </Button>
                    )}
                </NavigationHandler>
            </div>
            <OffreForm />
        </div>
    );
}
