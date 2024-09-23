# Frontend du SAAS

## Contexte

Le frontend en React est généré avec Next.js, merci de suivre les instructions du WEB ci-après en cliquant sur le lien **[ici](https://fr.react.dev/learn/start-a-new-react-project)**

## Instructions

Pour retrouver tous les composants du frontend, merci de vous rendre dans le dossier **./src/app/**.  
La vue initiale est dans le fichier **./src/app/page.js**, elle est notre index.html.

## Lancement

Pour démarrer le frontend, merci de prendre en compte les deux manières suivantes :  
- Soit vous démarrez le serveur de vous même en exécutant :
    ```bash
    npm run dev
    ```
    Mais vous prenez en compte la gestion des dépendances en **installant** sur votre poste en **local** toutes les **dépendances nécessaires au lancement** du frontend en exécutant au préalable la commande :
    ```bash
    npm install
    ```

- Soit vous installez et démarrez le frontend depuis le conteneur prévu à cette effet. Pour cela, merci de vous rendre à la racine du projet et de vous servir de l'utilitaire mis à votre disposition :
    ```bash
    bash config_bash/frontend/build_react.sh
    ```
    Qui construira l'image ( cela peut prendre un peu de temps ) et que vous lancerez (à la suite de l'installation de l'image) avec la commande :
    ```bash
    bash config_bash/frontend/start_front.sh
    ```
