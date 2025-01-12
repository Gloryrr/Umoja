"use client";
import React, { useState, useEffect, useCallback } from "react";
import { Button, Card, TextInput, Label, Badge, Spinner } from "flowbite-react";
import { apiGet, apiPatch, apiPost } from "@/app/services/internalApiClients";

const Profil: React.FC = () => {
    const [userInfo, setUserInfo] = useState({
        id: "",
        emailUtilisateur: "",
        username: "",
        numTelUtilisateur: "",
        nomUtilisateur: "",
        prenomUtilisateur: "",
        roleUtilisateur: "",
    });
    const [editedUserInfo, setEditedUserInfo] = useState(userInfo);
    const [isEditing, setIsEditing] = useState(false);

    const fetchUserProfile = useCallback(async () => {
        await apiGet("/me").then( async (response) => {
            const data = {"username" : response.utilisateur };
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
        });
    }, []);

    useEffect(() => {
        fetchUserProfile();
    }, [fetchUserProfile]);

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
        } catch (error) {
            console.error("Erreur lors de la sauvegarde des données utilisateur :", error);
        }
        setIsEditing(false);
    };

    const handleEditClick = () => {
        setEditedUserInfo(userInfo);
        setIsEditing(true);
    };

    if (userInfo.id == "") {
        return (
            <div className="flex justify-center min-h-[300px] items-center">
                <p>Chargement des données de votre profil, veuillez patienter quelques secondes</p>
                <Spinner className="ml-2" />
            </div>
        );
    }

    return (
        <div>
            <Card className="mx-auto mt-10 mb-10">
                <h2 className="text-2xl font-bold mb-4">Informations du Profil</h2>
                {isEditing ? (
                    <form className="flex flex-col gap-2">
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

                        <div className="flex justify-end gap-2 mt-6">
                            <Button color="gray" onClick={() => setIsEditing(false)} className="rounded-lg mt-2">
                                Annuler
                            </Button>
                            <Button onClick={handleSave} className="rounded-lg mt-2">
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
                            <span className="font-semibold">Nom d&apos;utilisateur :</span>
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

            {userInfo.roleUtilisateur == "ROLE_ADMIN" ? (
                <Card className="mx-auto mt-10 mb-10">
                    <h2 className="text-2xl font-bold mb-4">Accéder au panel administrateur</h2>
                    <p>
                        Vous avez le rôle d&apos;administrateur. Vous pouvez accéder au panel administrateur.
                    </p>
                    <div className="flex justify-between">
                        <Button href="http://localhost:8000/admin_umodja" className="w-full">
                            Panel administrateur
                        </Button>
                    </div>
                </Card>
            ) : null}
        </div>
    );
};

export default Profil;
