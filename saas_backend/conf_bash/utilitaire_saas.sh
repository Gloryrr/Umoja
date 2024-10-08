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
echo -e "\t4. Créer un Controller"
echo -e "\t5. Exécuter les tests unittaires"
echo -e "\t6. Checker le coverage des tests"
echo -e "\t7. Vérifier la qualité du code"
echo -e "\t8. Corriger la qualité du code\n"

read -p "Entrer l'instruction demandée : " instruction

if [ $instruction == "1" ]; then
    docker-compose exec application php bin/console doctrine:fixtures:load # entre dans le shell interfactif du container BDD
elif [ $instruction == "2" ]; then
    # docker-compose exec application php bin/console doctrine:schema:update --force # entre dans le shell interfactif du container BDD
    docker-compose exec application php bin/console make:migration
    docker-compose exec application php bin/console doctrine:migrations:migrate
elif [ $instruction == "3" ]; then
    php bin/console make:entity
elif [ $instruction == "4" ]; then
    php bin/console make:controller
elif [ $instruction == "5" ]; then
    vendor/bin/phpunit --testdox
elif [ $instruction == "6" ]; then
    vendor/bin/phpunit --coverage-text
elif [ $instruction == "7" ]; then
    vendor/bin/phpcs -p --standard=PSR12 src
elif [ $instruction == "8" ]; then
    vendor/bin/phpcbf src
fi

# exécuter une requête SQL : docker-compose exec application php bin/console doctrine:query:sql "REQUETE SQL"
