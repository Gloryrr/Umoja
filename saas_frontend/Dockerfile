# importe l'image de node pour l'environnement
FROM node:18 AS builder

WORKDIR /app_frontend

# copie les fichiers de dépendances pour l'install
COPY package.json package-lock.json ./
RUN npm install

COPY . .

RUN npm run build

# importe l'image de node pour l'environnement
FROM node:18 AS production

WORKDIR /app_frontend

COPY --from=builder /app_frontend ./

# Exposer le port sur lequel l'application sera accessible
EXPOSE 3000

CMD ["npm", "start"]
