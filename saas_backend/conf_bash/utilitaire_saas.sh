#! /bin/bash

question="\nQuelle instructions voulez-vous exécutez ?"
echo -e $question

taille=$(expr length "${question}")
for ((i=0; i<taille; i++)); do
    echo -n "-"
done

echo # pour la saut de ligne

echo -e "\t1. Utiliser le loader pour charger des données"
echo -e "\t2. Mettre à jour la BDD avec les changements du modèle"
echo -e "\t3. Créer une Entité"
echo -e "\t4. Créer un Controller\n"

read -p "Entrer l'instruction demandée : " instruction

if [ $instruction == "1" ]; then
    docker-compose exec application php bin/console doctrine:fixtures:load # entre dans le shell interfactif du container BDD
elif [ $instruction == "2" ]; then
    docker-compose exec application php bin/console doctrine:schema:update --force # entre dans le shell interfactif du container BDD
elif [ $instruction == "3" ]; then
    php bin/console make:entity
elif [ $instruction == "4" ]; then
    php bin/console make:controller
fi
