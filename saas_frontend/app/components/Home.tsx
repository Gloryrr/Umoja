"use client";
import React, { useRef } from 'react';
import NavigationHandler from '../navigation/Router';
import Image from 'next/image';

const Home = () => {
    const scrollContainerRef = useRef<HTMLDivElement>(null);

    const handleScroll = () => {
        const container = scrollContainerRef.current;
        if (container) {
            const scrollWidth = container.scrollWidth;
            const scrollLeft = container.scrollLeft;
            const containerWidth = container.clientWidth;

            if (scrollLeft + containerWidth >= scrollWidth) {
                container.scrollLeft = 0;
            }
        }
    };

    return (
        <div className="min-h-screen bg-white w-full">
            {/* Section principale avec le bouton de création d&apos;offre */}
            <section className="container mx-auto px-6 py-12 flex items-center overflow-x-hidden mb-[10vh]">
                {/* Texte à gauche */}
                <div className="w-full md:w-1/2 ml-[15%]">
                    <h2 className="text-4xl font-bold text-black mb-4">Créez votre propre offre musicale</h2>
                    <p className="text-gray-700 mb-6">
                        Lancez votre propre événement musical et partagez votre passion avec le monde entier. Créez une offre et commencez à attirer des participants dès aujourd&apos;hui.
                    </p>
                    <NavigationHandler>
                        {(handleNavigation: (path: string) => void) => (
                            <button
                                onClick={() => handleNavigation('/offre')}
                                className="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-600 font-semibold"
                            >
                                Créer une offre
                            </button>
                        )}
                    </NavigationHandler>
                </div>
                {/* Image à droite */}
                <div className="hidden md:block w-full md:w-1/2 pl-8 mr-[15%]">
                    <Image
                        width={120}
                        height={120} src="/images/offer-creation.jpg" alt="Créer une offre" className="rounded-lg shadow-lg w-full h-auto" />
                </div>
            </section>

            {/* Steps for Creating a Musical Event */}
            <section className="relative min-h-[600px] flex flex-col justify-center">
                {/* Title that crosses all sections */}
                <h3 className="text-3xl text-black font-semibold text-center absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-8 z-10 px-4 py-2 rounded-full">
                    Étapes pour créer votre projet d&apos;événement musical
                </h3>

                <div className="flex flex-col md:flex-row space-y-0 md:space-y-0 md:space-x-0 items-center justify-center">
                    {/* Step 1: Create an Offer */}
                    <div className="flex-1 bg-pink-100 min-h-[600px] p-6 flex flex-col justify-center items-center">
                        <h4 className="text-2xl font-semibold text-pink-600 mb-4 text-center">1. Création d&apos;une offre</h4>
                        <p className="text-gray-600 mb-6 text-center">
                            Commencez par créer une offre détaillée pour votre événement, incluant les informations essentielles pour attirer les participants.
                        </p>
                        <NavigationHandler>
                            {(handleNavigation: (path: string) => void) => (
                                <button
                                    onClick={() => handleNavigation('/offre')}
                                    className="bg-pink-500 text-white px-6 py-3 rounded hover:bg-pink-600 font-semibold mx-auto"
                                >
                                    Créer une offre
                                </button>
                            )}
                        </NavigationHandler>
                    </div>

                    {/* Step 2: Publish on Networks */}
                    <div className="flex-1 bg-yellow-100 min-h-[600px] p-6 flex flex-col justify-center items-center">
                        <h4 className="text-2xl font-semibold text-yellow-600 mb-4 text-center">2. Publication sur les réseaux</h4>
                        <p className="text-gray-600 mb-6 text-center">
                            Publiez votre offre sur les réseaux sociaux et autres plateformes pour toucher un large public.
                        </p>
                        <NavigationHandler>
                            {(handleNavigation: (path: string) => void) => (
                                <button
                                    onClick={() => handleNavigation('/offre')}
                                    className="bg-yellow-500 text-white px-6 py-3 rounded hover:bg-yellow-600 font-semibold mx-auto"
                                >
                                    Créer une offre
                                </button>
                            )}
                        </NavigationHandler>
                    </div>

                    {/* Step 3: Manage Responses */}
                    <div className="flex-1 bg-green-100 min-h-[600px] p-6 flex flex-col justify-center items-center">
                        <h4 className="text-2xl font-semibold text-green-600 mb-4 text-center">3. Gestion des réponses</h4>
                        <p className="text-gray-600 mb-6 text-center">
                            Gérez les réponses des participants et adaptez votre offre pour maximiser l&apos;engagement.
                        </p>
                        <NavigationHandler>
                            {(handleNavigation: (path: string) => void) => (
                                <button
                                    onClick={() => handleNavigation('/offre')}
                                    className="bg-green-500 text-white px-6 py-3 rounded hover:bg-green-600 font-semibold mx-auto"
                                >
                                    Créer une offre
                                </button>
                            )}
                        </NavigationHandler>
                    </div>
                </div>
            </section>

            {/* Section de bienvenue */}
            <section className="text-center py-16 bg-cover bg-center" style={{ backgroundImage: 'url(/images/banner.jpg)' }}>
                <h2 className="text-4xl font-bold text-black">Financez des événements musicaux dès aujourd&apos;hui</h2>
                <p className="text-black mt-4">Découvrez les événements musicaux de vos réseaux.</p>
                <NavigationHandler>
                    {(handleNavigation: (path: string) => void) => (
                        <button
                            onClick={() => handleNavigation('/explore')}
                            className="mt-8 bg-black text-white font-semibold py-3 px-6 rounded-full"
                        >
                            Explorer les événements
                        </button>
                    )}
                </NavigationHandler>
            </section>

            {/* Section des genres de musique */}
            <section className="py-12 bg-gray-100">
                <div className="container mx-auto text-center">
                    <h3 className="text-3xl text-black font-semibold mb-8">Genres de musique</h3>
                    <div className="flex justify-center gap-8">
                        {['Rock', 'Jazz', 'Électro', 'Classique', 'Pop'].map((genre) => (
                            <div key={genre} className="bg-white shadow-lg rounded-lg p-6 w-40 text-black font-bold hover:bg-blue-100 cursor-pointer">
                                {genre}
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Section des événements musicaux */}
            <section className="py-12">
                <div className="container mx-auto">
                    <h3 className="text-3xl text-black font-semibold mb-8 text-center">Événements musicaux en vedette dans vos réseaux</h3>
                    <div
                        className="flex space-x-6 overflow-x-auto px-8 hide-scrollbar py-8"
                        ref={scrollContainerRef}
                        onScroll={handleScroll}
                    >
                        {['Concert Rock', 'Festival Jazz', 'Soirée Électro', 'Concert Rock', 'Festival Jazz', 'Soirée Électro'].map((event, index) => (
                            <div
                                key={index}
                                className="flex-shrink-0 bg-white shadow-lg rounded-lg overflow-visible w-80 transform transition-all duration-300 hover:shadow-xl"
                            >
                                <Image
                                    width={120}
                                    height={120}
                                    src={`/images/event-${index + 1}.jpg`}
                                    alt={event}
                                    className="w-full h-48 object-cover"
                                />
                                <div className="p-6">
                                    <h4 className="font-semibold text-xl mb-2">{event}</h4>
                                    <p className="text-gray-600">Description brève de l&apos;événement.</p>
                                    <NavigationHandler>
                                        {(handleNavigation: (path: string) => void) => (
                                            <button
                                                onClick={() => handleNavigation(`/event/${index + 1}`)}
                                                className="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 font-semibold"
                                            >
                                                Voir l&apos;événement
                                            </button>
                                        )}
                                    </NavigationHandler>
                                </div>
                            </div>
                        ))}
                        {/* Duplicating the items for the infinite scroll effect */}
                        {['Concert Rock', 'Festival Jazz', 'Soirée Électro'].map((event, index) => (
                            <div
                                key={`duplicate-${index}`}
                                className="flex-shrink-0 bg-white shadow-lg rounded-lg overflow-visible w-80 transform transition-all duration-300 hover:shadow-xl"
                            >
                                <Image
                                    width={120}
                                    height={120}
                                    src={`/images/event-${index + 1}.jpg`}
                                    alt={event}
                                    className="w-full h-48 object-cover"
                                />
                                <div className="p-6">
                                    <h4 className="font-semibold text-xl mb-2">{event}</h4>
                                    <p className="text-gray-600">Description brève de l&apos;événement.</p>
                                    <NavigationHandler>
                                        {(handleNavigation: (path: string) => void) => (
                                            <button
                                                onClick={() => handleNavigation(`/event/${index + 1}`)}
                                                className="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 font-semibold"
                                            >
                                                Voir l&apos;événement
                                            </button>
                                        )}
                                    </NavigationHandler>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

        </div>
    );
};

export default Home;
