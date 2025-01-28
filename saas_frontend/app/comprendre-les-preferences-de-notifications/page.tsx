import React from 'react';
import { Card, List, ListItem, Button } from 'flowbite-react';
import { IoIosNotifications } from "react-icons/io";

const NotificationPreferencesPage: React.FC = () => {
    return (
        <div className="max-w-3xl mx-auto p-6 mt-5 mb-5">
            {/* Titre principal */}
            <h1 className="text-4xl font-semibold text-center mb-6">
                Comprendre les Préférences de Notifications
            </h1>

            {/* Section avec texte explicatif */}
            <Card className="mb-8 p-6 shadow-lg bg-white border border-gray-200 rounded-xl">
                <p className="mb-4">
                    Umoja exerce le droit d&apos;envoyer des emails en fonction de vos préférences de notifications. Vous pouvez choisir de recevoir des emails pour :
                </p>

                {/* Liste des options de notifications */}
                <List className="space-y-2 mb-4">
                    <ListItem className="text-gray-700 dark:text-gray-300">
                        Le post d&apos;un nouveau projet dans un réseau auquel vous appartenez
                    </ListItem>
                    <ListItem className="text-gray-700 dark:text-gray-300">
                        La modification d&apos;un de vos projets
                    </ListItem>
                    <ListItem className="text-gray-700 dark:text-gray-300">
                        La réponse à un de vos projets
                    </ListItem>
                </List>
                
                {/* Lien vers la gestion des préférences */}
                <p className="text-base text-gray-600">
                    Si vous souhaitez gérer vos préférences de notifications, merci de vous rendre à l&apos;adresse suivante : 
                    <a href='/preferences-notifications' className="text-blue-500 hover:text-blue-700 font-semibold"> Préférences de Notifications</a>
                </p>
            </Card>

            {/* Section des instructions supplémentaires */}
            <Card className="p-6 shadow-lg bg-white border border-gray-200 rounded-xl">
                <p className="text-gray-700">
                    Vous pouvez gérer vos préférences de notifications dans les paramètres de votre compte. Assurez-vous de les mettre à jour pour recevoir les notifications qui vous intéressent.
                </p>
            </Card>

            {/* Section de bouton de redirection */}
            <div className="mt-6 text-center">
                <Button
                    href="/preferences-notifications"
                    color='blue'
                    className="flex items-center justify-center"
                >
                    Accéder aux paramètres
                    <IoIosNotifications size={20} className="ml-2 mb-auto mt-auto" />
                </Button>
            </div>
        </div>
    );
};

export default NotificationPreferencesPage;
