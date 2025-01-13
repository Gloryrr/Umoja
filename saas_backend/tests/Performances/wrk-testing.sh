#!/bin/bash

# tous les endpoints GET de l'API
endpoints=(
    "/api/v1/artistes"
    "/api/v1/artiste/1"
    "/api/v1/budgets-estimatifs"
    "/api/v1/budget-estimatif/1"
    "/api/v1/commentaires"
    "/api/v1/commentaire/1"
    "/api/v1/conditions-financieres"
    "/api/v1/condition-financiere/1"
    "/api/v1/etats-offre"
    "/api/v1/etat-offre/1"
    "/api/v1/etats-reponse"
    "/api/v1/etats-reponse/1"
    "/api/v1/extras"
    "/api/v1/extras/1"
    "/api/v1/fiches-techniques"
    "/api/v1/fiches-technique/1"
    "/api/v1/genres-musicaux"
    "/api/v1/genre-musical/1"
    "/api/v1/offres"
    "/api/v1/offre/1"
    "/api/v1/reponses"
    "/api/v1/reponses/offre/1"
    "/api/v1/reponses/PrixGlobalContribution/offre/1"
    "/api/v1/reponse/1"
    "/api/v1/reseaux"
    "/api/v1/type-offres"
    "/api/v1/type-offre/1"
    "/api/v1/utilisateurs"
    "/api/v1/me"
    "/api/v1/utilisateur/preference-notification/testuser"
)

base_url="http://localhost:8000"
errors=0  # Compteur d'erreurs

# Créer un répertoire pour les résultats
results_dir="wrk_resultats"
mkdir -p "./tests/Performances/$results_dir"

echo "Lancement des tests de performances avec wrk..."
echo -e "------------------------\n"
echo "Temps de tests estimées en tout : $((${#endpoints[@]} * 10 / 60)) minutes"
echo -e "------------------------\n"

# Test de chaque endpoint avec wrk
for endpoint in "${endpoints[@]}"; do
    echo "Test de performances sur l'URL: $base_url$endpoint"
    
    # Exécuter wrk et capturer la sortie et le code de retour
    wrk_output=$(wrk -t2 -c50 -d2s "$base_url$endpoint" 2>&1)
    exit_code=$?

    # Enregistrer la sortie dans un fichier
    endpoint_file=$(echo "$endpoint" | tr '/' '_')
    echo "$wrk_output" > "./tests/Performances/$results_dir/$endpoint_file.txt"

    # Vérifier le résultat
    if [ $exit_code -ne 0 ]; then
        echo "Erreur lors du test de $endpoint"
        echo "Détails : $wrk_output"
        errors=$((errors + 1))
    else
        echo "$wrk_output"
    fi

    echo -e "------------------------\n"
done

# Vérifier si des erreurs ont été rencontrées
if [ $errors -ne 0 ]; then
    echo "Le script s'est terminé avec $errors erreur(s)."
    exit 1
else
    echo "Tous les tests se sont terminés avec succès."
    exit 0
fi

echo "Résumé des erreurs rencontrées :"
for endpoint in "${endpoints[@]}"; do
    endpoint_file=$(echo "$endpoint" | tr '/' '_')
    if grep -q "Non-2xx or 3xx responses" "./tests/Performances/$results_dir/$endpoint_file.txt"; then
        echo "Endpoint $endpoint a rencontré des erreurs."
    fi
done
