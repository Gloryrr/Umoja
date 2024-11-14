"use client";
import React, { useState, useEffect } from "react";
import { Avatar, Button, Card, ListGroup, ListGroupItem, TextInput, Label, Badge } from "flowbite-react";
import { HiUserCircle, HiClipboardList, HiBell, HiUsers } from "react-icons/hi";
import { apiPatch, apiPost } from "@/app/services/internalApiClients";

interface UserProfileProps {
    userData: {
        emailUtilisateur: string;
        username: string;
        numTelUtilisateur: string | null;
        nomUtilisateur: string | null;
        prenomUtilisateur: string | null;
    } | null;
    onSave: (updatedData: Record<string, string>) => void;
}

const UserProfile: React.FC<UserProfileProps> = ({ userData, onSave }) => {
    const [userInfo, setUserInfo] = useState({
        id: "",
        emailUtilisateur: "",
        username: "",
        numTelUtilisateur: "",
        nomUtilisateur: "",
        prenomUtilisateur: "",
    });
    const [editedUserInfo, setEditedUserInfo] = useState(userInfo);
    const [selectedTab, setSelectedTab] = useState("profil");
    const [isEditing, setIsEditing] = useState(false);

    const fetchUserProfile = async () => {
        if (localStorage.isConnected === "true") {
            const username = localStorage.getItem("username");
            const data = { username: username };
            try {
                const response = await apiPost("/utilisateur", JSON.parse(JSON.stringify(data)));
                if (response) {
                    setUserInfo(JSON.parse(response.utilisateur)[0]);
                } else {
                    console.error("Erreur lors de la récupération des données utilisateur.");
                }
            } catch (error) {
                console.error("Erreur réseau :", error);
            }
        }
    };

    useEffect(() => {
        if (selectedTab === "profil") {
            fetchUserProfile();
        }
    }, [selectedTab]);

    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        setEditedUserInfo((prev) => ({
            ...prev,
            [name]: value,
        }));
    };

    const handleSave = async () => {
        try {
            const response = await apiPatch(`/utilisateurs/update/${userInfo.id}`, JSON.parse(JSON.stringify(editedUserInfo)));
            setUserInfo(editedUserInfo);
        } catch (error) {
            console.error("Erreur lors de la sauvegarde des données utilisateur :", error);
        }
        setIsEditing(false);
    };

    const handleEditClick = () => {
        setEditedUserInfo(userInfo);
        setIsEditing(true);
    };

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
                            <h2 className="text-xl font-bold">{userInfo.username}</h2>
                            <p>{userInfo.emailUtilisateur}</p>
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

                {selectedTab === "profil" && (
                    <Card>
                        <h2 className="text-xl font-semibold mb-4">Informations du Profil</h2>
                        {isEditing ? (
                            <form className="flex flex-col gap-6 rounded-lg">
                                <div>
                                    <Label htmlFor="emailUtilisateur" className="mb-2 block text-sm font-semibold">
                                        Email
                                    </Label>
                                    <TextInput
                                        id="emailUtilisateur"
                                        name="emailUtilisateur"
                                        type="email"
                                        placeholder="Votre email"
                                        value={editedUserInfo.emailUtilisateur}
                                        onChange={handleInputChange}
                                        required
                                        className="rounded-lg"
                                    />
                                </div>

                                <div>
                                    <Label htmlFor="username" className="mb-2 block text-sm font-semibold">
                                        Nom d'utilisateur
                                    </Label>
                                    <TextInput
                                        id="username"
                                        name="username"
                                        placeholder="Votre nom d'utilisateur"
                                        value={editedUserInfo.username}
                                        onChange={handleInputChange}
                                        required
                                        className="rounded-lg"
                                    />
                                </div>

                                <div>
                                    <Label htmlFor="numTelUtilisateur" className="mb-2 block text-sm font-semibold">
                                        Numéro de téléphone
                                    </Label>
                                    <TextInput
                                        id="numTelUtilisateur"
                                        name="numTelUtilisateur"
                                        placeholder="Votre numéro de téléphone"
                                        value={editedUserInfo.numTelUtilisateur}
                                        onChange={handleInputChange}
                                        className="rounded-lg"
                                    />
                                </div>

                                <div>
                                    <Label htmlFor="nomUtilisateur" className="mb-2 block text-sm font-semibold">
                                        Nom
                                    </Label>
                                    <TextInput
                                        id="nomUtilisateur"
                                        name="nomUtilisateur"
                                        placeholder="Votre nom"
                                        value={editedUserInfo.nomUtilisateur}
                                        onChange={handleInputChange}
                                        className="rounded-lg"
                                    />
                                </div>

                                <div>
                                    <Label htmlFor="prenomUtilisateur" className="mb-2 block text-sm font-semibold">
                                        Prénom
                                    </Label>
                                    <TextInput
                                        id="prenomUtilisateur"
                                        name="prenomUtilisateur"
                                        placeholder="Votre prénom"
                                        value={editedUserInfo.prenomUtilisateur}
                                        onChange={handleInputChange}
                                        className="rounded-lg"
                                    />
                                </div>

                                <div className="flex justify-end gap-4 mt-6">
                                    <Button color="gray" size="lg" onClick={() => setIsEditing(false)} className="rounded-lg">
                                        Annuler
                                    </Button>
                                    <Button size="lg" onClick={handleSave} className="rounded-lg">
                                        Enregistrer
                                    </Button>
                                </div>
                            </form>
                        ) : (
                            <div className="flex flex-col gap-6 rounded-lg">
                                <div className="flex items-center justify-between">
                                    <span className="font-semibold">Email :</span>
                                    <span>{userInfo.emailUtilisateur || <Badge color="failure">Non renseigné</Badge>}</span>
                                </div>
                                <div className="flex items-center justify-between">
                                    <span className="font-semibold">Nom d'utilisateur :</span>
                                    <span>{userInfo.username || <Badge color="failure">Non renseigné</Badge>}</span>
                                </div>

                                <div className="flex items-center justify-between">
                                    <span className="font-semibold">Téléphone :</span>
                                    <span>{userInfo.numTelUtilisateur || <Badge color="failure">Non renseigné</Badge>}</span>
                                </div>

                                <div className="flex items-center justify-between">
                                    <span className="font-semibold">Nom :</span>
                                    <span>{userInfo.nomUtilisateur || <Badge color="failure">Non renseigné</Badge>}</span>
                                </div>

                                <div className="flex items-center justify-between">
                                    <span className="font-semibold">Prénom :</span>
                                    <span>{userInfo.prenomUtilisateur || <Badge color="failure">Non renseigné</Badge>}</span>
                                </div>
                                <Button
                                    color="info"
                                    onClick={handleEditClick}
                                    className="w-full hover:bg-blue-600"
                                >
                                    Modifier le profil
                                </Button>
                            </div>
                        )}
                    </Card>
                )}
            </div>
        </div>
    );
};

export default UserProfile;
