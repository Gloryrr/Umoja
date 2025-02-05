# Étape de build
FROM node:18 AS builder

WORKDIR /app_frontend

# on limite l'utilisation de la RAM à 512 Mo
# ENV NODE_OPTIONS=--max_old_space_size=512

# Copier uniquement les fichiers nécessaires à l'installation des dépendances
COPY package.json package-lock.json ./
RUN npm ci --omit=dev

# Copier le reste du projet
COPY . .

RUN ls -R

# Générer le build de Next.js
RUN npm run build

# Étape de production
FROM node:18 AS production

WORKDIR /app_frontend

# Copier uniquement les fichiers nécessaires
COPY --from=builder /app_frontend/package.json /app_frontend/package-lock.json ./
COPY --from=builder /app_frontend/.next /app_frontend/.next
COPY --from=builder /app_frontend/public /app_frontend/public
COPY --from=builder /app_frontend/node_modules /app_frontend/node_modules

# Définir les variables d'environnement
ENV NODE_ENV=production
EXPOSE 3000

# Commande pour démarrer l'application
CMD ["npm", "run", "start"]
