"use client";
import React, { useState } from "react";
import { Avatar, Card, ListGroup, ListGroupItem } from "flowbite-react";
import { HiUserCircle, HiClipboardList, HiBell, HiUsers } from "react-icons/hi";
import UserProfile from "@/app/components/UserProfil";
import OffresProfil from "@/app/components/OffresProfil";

const SettingsPage: React.FC = () => {
    const [selectedTab, setSelectedTab] = useState("profil");
    const username = window.localStorage.getItem("username");

    const handleTabChange = (tab: string) => {
        setSelectedTab(tab);
    };

    const getSectionTitle = () => {
        switch (selectedTab) {
            case "profil":
                return "Profil Utilisateur";
            case "offres":
                return "Mes Offres";
            case "notifications":
                return "Mes Notifications";
            case "contributions":
                return "Mes Contributions";
            default:
                return "";
        }
    };

    return (
        <div className="container ml-20 mt-10 p-6 flex w-[70%]">
            <div className="w-1/3 sticky top-6 mr-10">
                <Card>
                    <div className="flex items-center p-4 border-b">
                        <Avatar img="../../favicon.ico" className="mx-auto" />
                        <div className="ml-4">
                            <h2 className="text-xl font-bold">{username}</h2>
                            <p>email@example.com</p>
                        </div>
                    </div>

                    <ListGroup>
                        <ListGroupItem onClick={() => handleTabChange("profil")} active={selectedTab === "profil"} icon={HiUserCircle}>
                            Profil
                        </ListGroupItem>
                        <ListGroupItem onClick={() => handleTabChange("offres")} active={selectedTab === "offres"} icon={HiClipboardList}>
                            Mes Offres
                        </ListGroupItem>
                        <ListGroupItem onClick={() => handleTabChange("notifications")} active={selectedTab === "notifications"} icon={HiBell}>
                            Mes Notifications
                        </ListGroupItem>
                        <ListGroupItem onClick={() => handleTabChange("contributions")} active={selectedTab === "contributions"} icon={HiUsers}>
                            Mes Contributions
                        </ListGroupItem>
                    </ListGroup>
                </Card>
            </div>

            <div className="w-3/4 ml-6">
                <h3 className="text-2xl font-bold mb-4">{getSectionTitle()}</h3>
                {selectedTab === "profil" && <UserProfile />}
                {selectedTab === "offres" && <OffresProfil />}
            </div>
        </div>
    );
};

export default SettingsPage;
