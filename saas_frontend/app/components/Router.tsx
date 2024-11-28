"use client"
import React, { ReactNode } from 'react';
import { useRouter } from 'next/navigation';

interface NavigationHandlerProps {
  children: (handleNavigation: (path: string) => Promise<void>) => ReactNode;
}

const NavigationHandler: React.FC<NavigationHandlerProps> = ({ children }) => {
  const router = useRouter();

  const handleNavigation = async (path: string) => {
    // Précharge la page sans changer immédiatement
    // await router.prefetch(path); await inutil ???

    router.prefetch(path);

    // Attendre que l'animation de fermeture soit terminée (ajuster le délai selon l'animation)
    // await new Promise(resolve => setTimeout(resolve, 400));

    // Naviguer une fois l'animation terminée
    router.push(`${path}`);
  };

  return <>{children(handleNavigation)}</>;
};

export default NavigationHandler;