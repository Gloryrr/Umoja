# Saas WEB

## Branche

Branche develop -- branche de versionnage de développement, petite(s) feature(s) implémentée(s)

## Préambule - Présentation

Si pour vous, avoir un outil d'organisation, de planification et de consultation pour des évênements musicaux a toujours été une difficuté conséquente. Découvrez notre solution dès maintenant.  
Planifiez désormais tout vos évênements depuis notre application WEB. Mutualiser des tournées de concerts et des festivals entre plusieurs organisateurs, faire jouer la collaboration entre plusieurs organismes, définir des événements en communs, proposer des offres pour vos évênements, etc... .Tout ça est dès maintenant possible grâce à notre plateforme collaborative.

Rejoignez désormais les réseaux professionels présents sur la plateforme et découvrez toutes les fonctionnalités qui vous permettront de simplifier vos organisations.

## Documentation

Pour toutes informations nécessaires à la compréhension du projet, merci de prendre part aux informations distribuées depuis le réseau centralisé **[ici](https://drive.google.com/drive/u/0/folders/1-W8owdcPgCQNZoVTqhNMLNMSHPmEiNQm)**.  
Pour toutes demandes d'accès, merci d'adresser la demande au propriétaire du dépôt.

## Installation

### Local

1. `git clone https://github.com/Gloryrr/SAE-3annee.git` - Clone le repo git

#### Backend

1. `cd backend` - Navigation dans le dossier dédié au backend
2. // mettre les autres étapes - déploiement conteneurs docker pour le backend

#### Frontend

1. `cd frontend` - Navigation dans le dossier dédié au frontend
2. // mettre les autres étapes - déploiement conteneurs docker pour le frontend

### Accessible partout

Notre plateforme est dès maintenant disponible depuis : **<https://lien-vers-la-platforme/SaaS/cloud/>**

## Contribution

Cette plateforme a été développée par **MARMION Steven**, **KAPLIA Elliot**, **NOBLESSE Oscar**, **PILET Colin**, **BLANDEAU Erwan**. Étudiants en 3ème de BUT Informatique.  

## Architecture

La plateforme a été développé depuis deux langages principaux :

1. `PHP`, utilisation de symfony
2. `React`, utilisation de npm en package manager, JS en complémentarité de front
3. Archi logicielle en `API REST`
4. Modèle de conception en `MVC`
5. Stockage avec // on mettra le SGBD choisie  

La plateforme est donc techniquement composée avec une **architecture WEB 4-tier** classique en 4 couches distinctes : UI/UX avec le frontend, distribution des données avec l'API REST, logique métier avec le backend et mise en stockage avec notre SGBD.