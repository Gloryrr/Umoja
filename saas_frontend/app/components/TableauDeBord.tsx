"use client";

import { Breadcrumb } from "flowbite-react";
import { HiHome } from "react-icons/hi";
import TableDesOffres from "../../app/components/OffresTableauDeBord";

export function TableauDeBord() {
    return (
        <div className="p-4 mt-10 mb-10">
            {/* Breadcrumb Section */}
            <div className="mb-4">
                <Breadcrumb className="bg-gray-50 px-5 py-3 dark:bg-gray-800">
                    <Breadcrumb.Item icon={HiHome}>
                        Mon tableau de bord
                    </Breadcrumb.Item>
                    <Breadcrumb.Item className="font-bold">
                        Mes Offres
                    </Breadcrumb.Item>
                </Breadcrumb>
            </div>

            {/* Main Content Section */}
            <div>
                {/* Offres Section */}
                <section className="w-full">
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
            </div>
        </div>
    );
}

export default TableauDeBord;
