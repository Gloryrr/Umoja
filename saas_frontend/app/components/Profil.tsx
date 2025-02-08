"use client";
import React, { useState, useEffect, useCallback } from "react";
import { Button, Card, TextInput, Label, Badge, Spinner, Toast } from "flowbite-react";
import { apiGet, apiPatch, apiPost } from "../../app/services/internalApiClients";
import { HiCheck } from 'react-icons/hi';

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
    const [showPasswordModal, setShowPasswordModal] = useState(false);
    const [passwords, setPasswords] = useState({
        currentPassword: "",
        newPassword: "",
        confirmNewPassword: "",
    });

    const [showSuccess, setShowSuccess] = useState(false);
    const [showError, setShowError] = useState(false);

    const [messageMotDePasseDifferent, setMessageMotDePasseDifferent] = useState("");

    const handlePasswordChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setPasswords((prev) => ({
            ...prev,
            [name]: value,
        }));
    };

    const handlePasswordReset = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        if (passwords.newPassword !== passwords.confirmNewPassword) {
            setMessageMotDePasseDifferent("Les mots de passe ne correspondent pas");
            return;
        }
        try {
            const data = {
                currentPassword: passwords.currentPassword,
                newPassword: passwords.newPassword,
            };
            const response = await apiPatch("/utilisateur/update-mot-de-passe", JSON.parse(JSON.stringify(data)));
            if (JSON.parse(response.utilisateur)) {
                setShowSuccess(true);
                setTimeout(() => setShowSuccess(false), 3000);
            } else {
                setShowError(true);
                setTimeout(() => setShowError(false), 3000);
            }
            setShowPasswordModal(false);
        } catch (error) {
            console.error("Erreur lors de la réinitialisation du mot de passe :", error);
        }
    };

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

            <Card className="mx-auto mt-10 mb-10">
                <h2 className="text-2xl font-bold mb-4">Réinitialiser votre mot de passe</h2>
                <p>
                    Vous pouvez réinitialiser votre mot de passe en cliquant sur le bouton ci-dessous.
                </p>
                <div className="flex justify-between">
                    <Button onClick={() => setShowPasswordModal(true)} className="w-full">
                        Réinitialiser le mot de passe
                    </Button>
                </div>
            </Card>

            {showSuccess && (
                <div className="fixed top-4 right-4 z-50">
                    <Toast>
                    <HiCheck className="h-5 w-5 text-green-500" />
                    <div className="ml-3 text-sm font-normal">
                        Mot de passe sauvegardé avec succès
                    </div>
        
                    {/* Barre de vie */}
                    <div className="absolute bottom-0 left-0 h-1 w-full bg-green-200">
                        <div
                        className="h-full bg-green-500 transition-all duration-3000"
                        style={{
                            animation: "shrink 3s linear forwards",
                        }}
                        ></div>
                    </div>
                    </Toast>
        
                    <style jsx>{`
                    @keyframes shrink {
                        from {
                        width: 100%;
                        }
                        to {
                        width: 0%;
                        }
                    }
                    `}</style>
                </div>
                )}
        
                {showError && (
                <div className="fixed top-4 right-4 z-50">
                    <Toast>
                    <HiCheck className="h-5 w-5 text-red-500" />
                    <div className="ml-3 text-sm font-normal">
                        Erreur lors de la sauvegarde du mot de passe
                    </div>
        
                    {/* Barre de vie */}
                    <div className="absolute bottom-0 left-0 h-1 w-full bg-red-200">
                        <div
                        className="h-full bg-red-500 transition-all duration-3000"
                        style={{
                            animation: "shrink 3s linear forwards",
                        }}
                        ></div>
                    </div>
                    </Toast>
        
                    <style jsx>{`
                    @keyframes shrink {
                        from {
                        width: 100%;
                        }
                        to {
                        width: 0%;
                        }
                    }
                    `}</style>
                </div>
                )}

            {showPasswordModal && (
                <div className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h2 className="text-xl font-bold mb-4">Réinitialiser votre mot de passe</h2>
                        <form className="flex flex-col gap-2" onSubmit={handlePasswordReset}>
                            <div>
                                <Label htmlFor="currentPassword" value="Mot de passe actuel" className="font-semibold" />
                                <TextInput
                                    id="currentPassword"
                                    name="currentPassword"
                                    type="password"
                                    placeholder="Mot de passe actuel"
                                    value={passwords.currentPassword}
                                    onChange={handlePasswordChange}
                                    required
                                    className="rounded-lg mt-2"
                                />
                                <p
                                    className="text-sm text-red-500 mt-1 mb-2"
                                >
                                    Nous sommes dans l&apos;obligation de vérifier votre identité
                                </p>
                            </div>
                            <div>
                                <Label htmlFor="newPassword" value="Nouveau mot de passe" className="font-semibold" />
                                <TextInput
                                    id="newPassword"
                                    name="newPassword"
                                    type="password"
                                    placeholder="Nouveau mot de passe"
                                    value={passwords.newPassword}
                                    onChange={handlePasswordChange}
                                    required
                                    className="rounded-lg mt-2"
                                />
                            </div>
                            <div>
                                <Label htmlFor="confirmNewPassword" value="Confirmer le nouveau mot de passe" className="font-semibold" />
                                <TextInput
                                    id="confirmNewPassword"
                                    name="confirmNewPassword"
                                    type="password"
                                    placeholder="Confirmer le nouveau mot de passe"
                                    value={passwords.confirmNewPassword}
                                    onChange={handlePasswordChange}
                                    required
                                    className="rounded-lg mt-2"
                                />
                            </div>
                            <p className="text-sm text-red-500 mt-1 mb-2">
                                Assurez-vous de bien confirmer votre nouveau mot de passe
                            </p>
                            {messageMotDePasseDifferent && (
                                <p className="text-sm text-red-500 mt-1 mb-2">
                                    {messageMotDePasseDifferent}
                                </p>
                            )}
                            <div className="flex justify-end gap-2 mt-6">
                                <Button color="gray" onClick={() => setShowPasswordModal(false)} className="rounded-lg mt-2">
                                    Annuler
                                </Button>
                                <Button type="submit" className="rounded-lg mt-2">
                                    Enregistrer
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {userInfo.roleUtilisateur == "ROLE_ADMIN" ? (
                <Card className="mx-auto mt-10 mb-10">
                    <h2 className="text-2xl font-bold mb-4">Accéder au panel administrateur</h2>
                    <p>
                        Vous avez le rôle d&apos;administrateur. Vous pouvez accéder au panel administrateur.
                    </p>
                    <div className="flex justify-between">
                        <Button href="https://umoja.alexstevenslabs.io/api/v1/admin_umoja" className="w-full">
                            Panel administrateur
                        </Button>
                    </div>
                </Card>
            ) : null}
        </div>
    );
};

export default Profil;
