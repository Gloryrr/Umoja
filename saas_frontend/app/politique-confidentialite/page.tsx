import React from 'react';
import { Card, Button } from 'flowbite-react';

const PrivacyPolicyPage: React.FC = () => {
    return (
        <div className="max-w-3xl mx-auto p-6">
            {/* Titre principal */}
            <h1 className="text-2xl font-semibold text-center text-blue-600 mb-8">
                Politique de Confidentialité
            </h1>

            {/* Section introduction */}
            <Card className="mb-8 p-6 shadow-lg border border-gray-200 rounded-xl">
                <p className="text-gray-700 dark:text-gray-300 mb-4">
                    Chez Umoja, la protection de vos données personnelles est une priorité. Cette politique de confidentialité explique comment nous collectons, utilisons et protégeons vos informations personnelles lorsque vous utilisez nos services.
                </p>

                <p className="text-gray-700 dark:text-gray-300 mb-4">
                    Nous nous engageons à respecter la confidentialité et la sécurité de vos données, en conformité avec le Règlement Général sur la Protection des Données (RGPD) de l&apos;Union Européenne.
                </p>
            </Card>

            {/* Section collecte des données */}
            <Card className="mb-8 p-6 shadow-lg border border-gray-200 rounded-xl">
                <h2 className="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Collecte des Données</h2>
                <p className="text-gray-700 dark:text-gray-300 mb-4">
                    Nous collectons les informations suivantes lorsque vous utilisez nos services :
                </p>
                <ul className="list-disc pl-5 mb-4">
                    <li className="text-gray-700 dark:text-gray-300">Nom et prénom</li>
                    <li className="text-gray-700 dark:text-gray-300">Numéro de téléphone</li>
                    <li className="text-gray-700 dark:text-gray-300">Adresse email</li>
                    <li className="text-gray-700 dark:text-gray-300">Historique des actions sur notre plateforme</li>
                </ul>
            </Card>

            {/* Section utilisation des données */}
            <Card className="mb-8 p-6 shadow-lg border border-gray-200 rounded-xl">
                <h2 className="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Utilisation des Données</h2>
                <p className="text-gray-700 dark:text-gray-300 mb-4">
                    Nous utilisons vos données personnelles pour les finalités suivantes :
                </p>
                <ul className="list-disc pl-5 mb-4">
                    <li className="text-gray-700 dark:text-gray-300">Améliorer nos services et personnaliser votre expérience</li>
                    <li className="text-gray-700 dark:text-gray-300">Envoyer des notifications et des informations importantes liées à votre compte</li>
                    <li className="text-gray-700 dark:text-gray-300">Respecter nos obligations légales</li>
                </ul>
            </Card>

            {/* Section stockage des données et RGPD */}
            <Card className="mb-8 p-6 shadow-lg border border-gray-200 rounded-xl">
                <h2 className="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Stockage et Sécurité des Données</h2>
                <p className="text-gray-700 dark:text-gray-300 mb-4">
                    Vos informations personnelles sont stockées de manière sécurisée sur nos serveurs. Nous mettons en œuvre des mesures techniques et organisationnelles appropriées pour protéger vos données contre tout accès non autorisé, divulgation, modification ou destruction.
                </p>
                <p className="text-gray-700 dark:text-gray-300 mb-4">
                    En vertu du Règlement Général sur la Protection des Données (RGPD), vous avez le droit d&apos;accéder à vos données personnelles, de les rectifier, de les supprimer ou de limiter leur traitement.
                </p>
                <p className="text-gray-700 dark:text-gray-300 mb-4">
                    Si vous souhaitez exercer vos droits, vous pouvez nous contacter en cliquant sur le lien suivant : <a href="/contact" className="text-blue-500">nous contacter</a> ou en agissant directement sur vos données en modifiant ces dernières depuis votre espace personnel : <a href="/profil" className='text-blue-500'>mon espace profil</a>.
                </p>
            </Card>

            {/* Section partage des données */}
            <Card className="mb-8 p-6 shadow-lg border border-gray-200 rounded-xl">
                <h2 className="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Partage des Données</h2>
                <p className="text-gray-700 dark:text-gray-300 mb-4">
                    Nous ne partageons pas vos données personnelles avec des tiers, sauf dans les cas suivants :
                </p>
                <ul className="list-disc pl-5 mb-4">
                    <li className="text-gray-700 dark:text-gray-300">Si cela est nécessaire pour fournir nos services (par exemple, avec des prestataires de services tiers).</li>
                    <li className="text-gray-700 dark:text-gray-300">Si la loi nous y oblige, notamment en réponse à une demande légale d&apos;une autorité compétente.</li>
                </ul>
            </Card>

            {/* Section consentement et acceptation */}
            <Card className="mb-8 p-6 shadow-lg border border-gray-200 rounded-xl">
                <h2 className="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Consentement et Acceptation</h2>
                <p className="text-gray-700 dark:text-gray-300 mb-4">
                    En utilisant nos services, vous consentez à la collecte, à l&apos;utilisation et au stockage de vos données personnelles telles que décrites dans cette politique de confidentialité.
                </p>
            </Card>

            {/* Section bouton de redirection */}
            <div className="mt-6 text-center">
                <Button
                    color='blue'
                    href="/contact"
                >
                    Contactez-nous pour toute question
                </Button>
            </div>
        </div>
    );
};

export default PrivacyPolicyPage;
