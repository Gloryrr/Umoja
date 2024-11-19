"use client";

import { useState } from "react";
import { Breadcrumb, Card, Button } from "flowbite-react";
import { HiHome } from "react-icons/hi";
import OffresProfil from "@/app/components/OffresProfil";

export function TableauDeBord() {
    const [showOffres, setShowOffres] = useState(false);

    const handleShowViewOffres = () => {
        setShowOffres(true);
    };
    const handleHideViewOffres = () => {
        setShowOffres(false);
    };

    return (
        <div className="p-4">
            {/* Breadcrumb Section */}
            <div className="mb-4">
                <Breadcrumb>
                    <Breadcrumb.Item icon={HiHome}>
                        Mon tableau de bord
                    </Breadcrumb.Item>
                    {showOffres && (
                        <Breadcrumb.Item className="font-bold">
                            Mes Offres
                        </Breadcrumb.Item>
                    )}
                </Breadcrumb>
            </div>

            {/* Main Content Section */}
            <div>
                <h1 className="text-2xl font-bold mb-4">Tableau de Bord</h1>

                {/* Offres Section */}
                {showOffres ? (
                    <section className="mb-8">
                        <Button onClick={handleHideViewOffres} className="mt-4">
                            Cacher mes offres
                        </Button>
                        <OffresProfil />
                    </section>
                ) : (
                    <Card className="mb-8">
                        <h2 className="text-xl font-semibold mb-2">
                            Bienvenue dans votre tableau de bord
                        </h2>
                        <p>
                            Consultez toutes vos offres en cliquant sur le bouton ci-dessous.
                        </p>
                        <Button onClick={handleShowViewOffres} className="mt-4">
                            Voir mes offres
                        </Button>
                    </Card>
                )}

                {/* Placeholder for Future Components */}
                <section>
                    <h2 className="text-xl font-semibold mb-2">Autre Section</h2>
                    <p>Du contenu supplémentaire pourra être ajouté ici.</p>
                </section>
            </div>
        </div>
    );
}

export default TableauDeBord;
