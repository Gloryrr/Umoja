"use client";
import React, { useState, useEffect } from "react";
import { Button, Card, TextInput, Label, Badge } from "flowbite-react";
import { apiPatch, apiPost } from "@/app/services/internalApiClients";

const UserProfile: React.FC = () => {
    const [userInfo, setUserInfo] = useState({
        id: "",
        emailUtilisateur: "",
        username: "",
        numTelUtilisateur: "",
        nomUtilisateur: "",
        prenomUtilisateur: "",
    });
    const [editedUserInfo, setEditedUserInfo] = useState(userInfo);
    const [isEditing, setIsEditing] = useState(false);

    const fetchUserProfile = async () => {
        if (localStorage.isConnected === "true") {
            const username = window.localStorage.getItem("username");
            const data = {
                username,
            };
            try {
                const response = await apiPost("/utilisateur", JSON.parse(JSON.stringify(data)));
                if (response) {
                    setUserInfo(JSON.parse(response.utilisateur)[0]);
                    console.log(userInfo);
                } else {
                    console.error("Erreur lors de la récupération des données utilisateur.");
                }
            } catch (error) {
                console.error("Erreur réseau :", error);
            }
        }
    };

    useEffect(() => {
        fetchUserProfile();
    }, []);

    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setEditedUserInfo((prev) => ({
            ...prev,
            [name]: value,
        }));
    };

    const handleSave = async () => {
        try {
            const data = JSON.parse(JSON.stringify(editedUserInfo));
            await apiPatch(`/utilisateurs/update/${userInfo.id}`, data);
            setUserInfo(editedUserInfo);
            localStorage.setItem("username", editedUserInfo.username);
        } catch (error) {
            console.error("Erreur lors de la sauvegarde des données utilisateur :", error);
        }
        setIsEditing(false);
    };

    const handleEditClick = () => {
        setEditedUserInfo(userInfo);
        setIsEditing(true);
    };

    return (
        <Card className="mx-auto w-[70%]">
            <h2 className="text-2xl font-bold mb-4">Informations du Profil</h2>
            {isEditing ? (
                <form className="flex flex-col gap-6">
                    <div>
                        <Label 
                            htmlFor="emailUtilisateur" 
                            value="Email"
                            className="font-semibold" 
                        />
                        <TextInput
                            id="emailUtilisateur"
                            name="emailUtilisateur"
                            type="email"
                            placeholder="Votre email"
                            value={editedUserInfo.emailUtilisateur}
                            onChange={handleInputChange}
                            required
                            className="rounded-lg mt-2"
                        />
                    </div>
                    <div>
                        <Label 
                            htmlFor="username" 
                            value="Nom d'utilisateur"
                            className="font-semibold" 
                        />
                        <TextInput
                            id="username"
                            name="username"
                            placeholder="Votre nom d'utilisateur"
                            value={editedUserInfo.username}
                            onChange={handleInputChange}
                            required
                            className="rounded-lg mt-2"
                        />
                    </div>
                    <div>
                        <Label 
                            htmlFor="numTelUtilisateur" 
                            value="Téléphone"
                            className="font-semibold" 
                        />
                        <TextInput
                            id="numTelUtilisateur"
                            name="numTelUtilisateur"
                            placeholder="Votre numéro de téléphone"
                            value={editedUserInfo.numTelUtilisateur}
                            onChange={handleInputChange}
                            className="rounded-lg mt-2"
                        />
                    </div>
                    <div>
                        <Label 
                            htmlFor="nomUtilisateur" 
                            value="Nom"
                            className="font-semibold" 
                        />
                        <TextInput
                            id="nomUtilisateur"
                            name="nomUtilisateur"
                            placeholder="Votre nom"
                            value={editedUserInfo.nomUtilisateur}
                            onChange={handleInputChange}
                            className="rounded-lg mt-2"
                        />
                    </div>
                    <div>
                        <Label 
                            htmlFor="prenomUtilisateur" 
                            value="Prénom"
                            className="font-semibold" 
                        />
                        <TextInput
                            id="prenomUtilisateur"
                            name="prenomUtilisateur"
                            placeholder="Votre prénom"
                            value={editedUserInfo.prenomUtilisateur}
                            onChange={handleInputChange}
                            className="rounded-lg mt-2"
                        />
                    </div>

                    <div className="flex justify-end gap-4 mt-6">
                        <Button color="gray" size="lg" onClick={() => setIsEditing(false)} className="rounded-lg mt-2">
                            Annuler
                        </Button>
                        <Button size="lg" onClick={handleSave} className="rounded-lg mt-2">
                            Enregistrer
                        </Button>
                    </div>
                </form>
            ) : (
                <div className="flex flex-col gap-6">
                    <div className="flex items-center justify-between">
                        <span className="font-semibold">Email :</span>
                        <span>{userInfo.emailUtilisateur ? userInfo.emailUtilisateur : <Badge color="failure">Non renseigné</Badge>}</span>
                    </div>
                    <div className="flex justify-between">
                        <span className="font-semibold">Nom d'utilisateur :</span>
                        <span>{userInfo.username ? userInfo.username : <Badge color="failure">Non renseigné</Badge>}</span>
                    </div>
                    <div className="flex justify-between">
                        <span className="font-semibold">Téléphone :</span>
                        <span>{userInfo.numTelUtilisateur ? userInfo.numTelUtilisateur : <Badge color="failure">Non renseigné</Badge>}</span>
                    </div>
                    <div className="flex justify-between">
                        <span className="font-semibold">Nom :</span>
                        <span>{userInfo.nomUtilisateur ? userInfo.nomUtilisateur : <Badge color="failure">Non renseigné</Badge>}</span>
                    </div>
                    <div className="flex justify-between">
                        <span className="font-semibold">Prénom :</span>
                        <span>{userInfo.prenomUtilisateur ? userInfo.prenomUtilisateur : <Badge color="failure">Non renseigné</Badge>}</span>
                    </div>
                    <Button color="info" onClick={handleEditClick} className="w-full">
                        Modifier le profil
                    </Button>
                </div>
            )}
        </Card>
    );
};

export default UserProfile;
