"use client";

import { useState } from "react";
import { Breadcrumb, Card, Button } from "flowbite-react";
import { HiHome } from "react-icons/hi";
import TableDesOffres from "@/app/components/OffresTableauDeBord";

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
                {/* Offres Section */}
                {showOffres ? (
                    <section className="w-full">
                        <Button
                            onClick={handleHideViewOffres}
                            className="mt-4"
                        >
                            Cacher mes offres
                        </Button>
                        <div className="w-full mt-4">
                            {/* Conteneur pour gérer l'overflow */}
                            <div>
                                {/* TableDesOffres sans marges */}
                                <div className="w-full">
                                    <TableDesOffres />
                                </div>
                            </div>
                        </div>
                    </section>
                ) : (
                    <Button
                        onClick={handleShowViewOffres}
                        className="mt-4"
                    >
                        Voir mes offres
                    </Button>
                )}
            </div>
        </div>
    );
}

export default TableauDeBord;
