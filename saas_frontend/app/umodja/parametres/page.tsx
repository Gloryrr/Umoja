"use client";
import React, { useState, useEffect } from "react";
import { Avatar, Button, Card, ListGroup, ListGroupItem } from "flowbite-react";
import { HiUserCircle, HiClipboardList, HiBell, HiUsers, HiOutlinePencilAlt } from "react-icons/hi"; // Importation des icônes

// Définir les types de données utilisateur
interface UserProfileProps {
    userData: {
        email: string;
        password: string;
        role: string;
        username: string;
        phone: string | null;
        lastName: string | null;
        firstName: string | null;
    } | null;
    onSave: (updatedData: Record<string, string>) => void;
}

const UserProfile: React.FC<UserProfileProps> = ({ userData, onSave }) => {
    const [userInfo, setUserInfo] = useState({
        email: "marmionsteven8@gmail.com",
        password: "",
        role: "",
        username: "Steven Marmion",
        phone: "",
        lastName: "",
        firstName: "",
    });
    const [selectedTab, setSelectedTab] = useState("profil");

    useEffect(() => {
        if (userData) {
            setUserInfo(userData);
        }
    }, [userData]);

    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        setUserInfo((prev) => ({
            ...prev,
            [name]: value,
        }));
    };

    const handleSave = () => {
        onSave(userInfo);
    };

    const handleTabChange = (tab: string) => {
        setSelectedTab(tab);
    };

    // Fonction pour obtenir le titre en fonction du groupe sélectionné
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
            {/* ListGroup à gauche (sticky) encapsulé dans une Card */}
            <div className="w-1/3 sticky top-6 mr-10">
                <Card>
                    {/* Affichage du nom et de l'email de l'utilisateur */}
                    <div className="flex items-center p-4 border-b">
                        <Avatar img="../../favicon.ico" className='mx-auto' />
                        <div className="ml-4">
                            <h2 className="text-xl font-bold">{userInfo.username}</h2>
                            <p className="text-gray-600">{userInfo.email}</p>
                        </div>
                    </div>

                    {/* ListGroup */}
                    <ListGroup className="">
                        <ListGroupItem
                            onClick={() => handleTabChange("profil")}
                            active={selectedTab === "profil"}
                            icon={HiUserCircle}
                        >
                            Profil
                        </ListGroupItem>
                        <ListGroupItem
                            onClick={() => handleTabChange("offres")}
                            active={selectedTab === "offres"}
                            icon={HiClipboardList}
                        >
                            Mes offres
                        </ListGroupItem>
                        <ListGroupItem
                            onClick={() => handleTabChange("notifications")}
                            active={selectedTab === "notifications"}
                            icon={HiBell}
                        >
                            Mes notifications
                        </ListGroupItem>
                        <ListGroupItem
                            onClick={() => handleTabChange("contributions")}
                            active={selectedTab === "contributions"}
                            icon={HiUsers}
                        >
                            Mes contributions
                        </ListGroupItem>
                    </ListGroup>
                </Card>
            </div>

            {/* Section droite avec le contenu du profil */}
            <div className="w-3/4 ml-6">
                {/* Affichage du titre de la section choisie */}
                <h3 className="text-2xl font-bold mb-4">{getSectionTitle()}</h3>

                {/* Affichage du profil ou des autres sections */}
                {selectedTab === "profil" && (
                    <Card className="mb-6">
                        <div className="flex items-center">
                            <Avatar img="../../favicon.ico" className='mx-auto' />
                            <div className="ml-4">
                                <h2 className="text-2xl font-bold">{userInfo.username}</h2>
                                <p className="text-gray-600">{userInfo.email}</p>
                            </div>
                            <Button
                                color="gray"
                                className="ml-auto"
                                pill
                                icon={HiOutlinePencilAlt}
                            >
                                Modifier le profil
                            </Button>
                        </div>
                    </Card>
                )}

                {selectedTab === "offres" && (
                    <Card>
                        <p>Contenu pour "Mes Offres"</p>
                    </Card>
                )}

                {selectedTab === "notifications" && (
                    <Card>
                        <p>Contenu pour "Mes Notifications"</p>
                    </Card>
                )}

                {selectedTab === "contributions" && (
                    <Card>
                        <p>Contenu pour "Mes Contributions"</p>
                    </Card>
                )}
            </div>
        </div>
    );
};

export default UserProfile;
