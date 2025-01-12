
# **Manuel Utilisateur - Plateforme SaaS pour la Mutualisation des Tournées d’Artistes**

---

## **Introduction**

Cette plateforme SaaS vise à optimiser la gestion des tournées d’artistes en facilitant la collaboration entre agents, programmateurs, organisateurs et autres professionnels de l'industrie musicale. Elle offre des outils pour créer, partager et gérer des tournées tout en mutualisant les ressources et en simplifiant les échanges entre les différents acteurs.

- **Frontend** : React, TypeScript, Tailwind CSS
- **Backend** : Symfony
- **Base de données** : PostgreSQL

---

## **Installation et Prérequis**

### **1. Prérequis Techniques**

- **Serveur** :
  - PHP >= 8.1 avec les extensions nécessaires (ex. PDO, cURL, intl).
  - Serveur web Nginx.
  - Base de données PostgreSQL.

- **Frontend** :
  - Node.js >= 16.x
  - Yarn ou npm pour la gestion des dépendances.

- **Outils supplémentaires** :
  - Composer pour Symfony.
  - Git pour le versionnement du code.

### **2. Installation**

#### **Backend (Symfony)**
1. Clonez le dépôt du projet :
   ```bash
   git clone <url-du-dépôt>
   cd backend
   ```
2. Installez les dépendances avec Composer :
   ```bash
   composer install
   ```
3. Configurez les variables d'environnement :
   - Copiez le fichier `.env.example` en `.env`.
   - Renseignez les paramètres de connexion à la base de données.

4. Générez le schéma de la base de données :
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

5. Lancez le serveur local :
   ```bash
   symfony server:start
   ```

#### **Frontend (React)**
1. Naviguez dans le répertoire du frontend :
   ```bash
   cd saas_frontend
   ```
2. Installez les dépendances :
   ```bash
   npm install
   # ou
   yarn install
   ```
3. Lancez l'application :
   ```bash
   npm start
   # ou
   yarn start
   ```

---

## **Fonctionnalités Utilisateur**

### **1. Création et publication d’offres de concerts**

#### **Création d’offres**
- Un formulaire intuitif permet de créer des offres complètes :
  - Artiste(s).
  - Date(s), lieu(x), cachet(s).
  - Équipements nécessaires.
  - Informations supplémentaires (genre musical, public cible).

#### **Gestion des statuts**
- Statuts possibles :
  - **Brouillon** : non publiées. // PAS FAIT
  - **Publié** : accessibles au réseau.
  - **Fermé** : offres expirées ou terminées.

---

### **2. Gestion des réseaux professionnels**
- Création et gestion de réseaux professionnels fermés regroupant :
  - Salles de concert.
  - Festivals.
  - Agents d’artistes.
- Possibilité de rejoindre plusieurs réseaux selon les affiliations.
- Accès à des offres spécifiques à chaque réseau.

---

### **3. Base de données collaborative sur les artistes**

#### **Fiches artistes**
- Informations détaillées :
  - Biographie.
  - Genre musical.
  - Historique des performances.
  - Photos, vidéos et contacts.

#### **Collaboration**
- Modification collaborative des fiches.
- Historique des changements avec validation par les administrateurs.

---

### **4. Collaboration et mutualisation**

#### **Messagerie interne**
- Communication directe entre utilisateurs via une messagerie intégrée.

#### **Notifications**
- Alertes en temps réel pour :
  - Nouvelles offres.
  - Changements dans les collaborations.

#### **Co-organisation d’événements**
- Partage des coûts et des ressources pour organiser des événements.

---

### **5. Optimisation de la gestion des tournées**

#### **Calendrier partagé**
- Synchronisation des événements et concerts sur un calendrier centralisé.

#### **Génération d’itinéraires**
- Propositions automatiques pour :
  - Réduire les coûts.
  - Optimiser les temps de trajet.

---

### **6. Gestion des utilisateurs et permissions**

#### **Rôles spécifiques**
- Rôles attribués aux utilisateurs :
  - Agent.
  - Programmateur.
  - Organisateur.

#### **Gestion des permissions**
- Permissions personnalisées selon les rôles et affiliations.

---

### **7. Outils d’analyse et reporting**

#### **Statistiques avancées**
- Données sur :
  - Mutualisation des tournées.
  - Performances des réseaux.

#### **Rapports d’activité**
- Exports au format PDF ou CSV.

---

### **8. Intégration et interopérabilité**

- Synchronisation avec des outils tiers :
  - Google Calendar, Outlook.
  - CRM et gestion de projet (Trello, Asana).
- API REST pour les intégrations externes.

---

### **9. Sécurité et confidentialité**

#### **Chiffrement**
- Données sensibles chiffrées via SSL/TLS.

#### **Sauvegardes**
- Sauvegardes automatiques et régulières des données.

---

### **10. Interface utilisateur et accessibilité**

#### **Interface web**
- Conception adaptée aux non-techniciens avec une navigation intuitive.

---

### **11. Maintenance et support**


#### **Mises à jour**
- Mise à jour des fonctionnalités selon les retours utilisateurs.

#### **Documentation**
- Guide complet pour chaque module de la plateforme.

---

## **Conclusion**

Cette plateforme propose une solution innovante et collaborative pour l’industrie musicale. En centralisant les informations, les événements et les communications, elle facilite la gestion des tournées et permet une optimisation des ressources entre les différents acteurs du secteur.
