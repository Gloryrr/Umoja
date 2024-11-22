"use client";
import React from "react";
import { Tabs } from "flowbite-react";
import { HiUserCircle, HiAdjustments } from "react-icons/hi";
import { MdDashboard } from "react-icons/md";
import UserProfile from "@/app/components/UserProfil";
import PreferencesProfil from "@/app/components/PreferencesProfil";
import TableauDeBord from "@/app/components/TableauDeBord";

const SettingsPage: React.FC = () => {

    return (
        <div className="container mt-1 mb-1 flex flex-col items-center">
            <div className="w-full max-w-4xl">
                {/* User Card */}
                {/* <Card className="mb-6">
                    <div className="flex items-center p-4 border-b">
                        <Avatar img="../../favicon.ico" className="mx-auto" />
                        <div className="ml-4">
                            <h2 className="text-xl font-bold">{username}</h2>
                            <p>email@example.com</p>
                        </div>
                    </div>
                </Card> */}

                {/* Tabs */}
                <Tabs aria-label="Settings tabs" className="mx-auto">
                    <Tabs.Item title="Profil" icon={HiUserCircle}>
                        <UserProfile />
                    </Tabs.Item>
                    <Tabs.Item title="Mes Préférences" icon={HiAdjustments}>
                        <PreferencesProfil />
                    </Tabs.Item>
                    <Tabs.Item title="Tableau de Bord" icon={MdDashboard}>
                        <TableauDeBord />
                    </Tabs.Item>
                </Tabs>
            </div>
        </div>
    );
};

export default SettingsPage;
