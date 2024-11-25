"use client";

import { Button, Card, ListGroup, Timeline } from "flowbite-react";
import { Lightbulb, Edit, Share, Users } from "lucide-react";

function FonctionnementProjet() {
  return (
    <div className="py-12 px-6">
      {/* Titre principal */}
      <div className="text-center mb-10">
        <h1 className="text-4xl font-bold mb-4">Comment fonctionne la création d'un projet ?</h1>
        <p className="text-lg">
          Découvrez comment construire, gérer et faire vivre votre projet sur notre application.
        </p>
      </div>

      {/* Définition d'un projet */}
      <section className="mb-12">
        <Card>
          <h2 className="text-2xl font-bold mb-4">Qu'est-ce qu'un projet ?</h2>
          <p>
            Un projet est une idée, un objectif ou une activité que vous souhaitez concrétiser grâce à l'aide de votre réseau
            et de notre plateforme. Cela peut être une collecte de fonds, une initiative sociale, un événement ou toute autre activité
            nécessitant des participations.
          </p>
        </Card>
      </section>

      {/* Étapes de création */}
      <section className="mb-12">
        <h2 className="text-3xl font-bold mb-6 text-center">Étapes pour construire un projet</h2>
        <Timeline>
          <Timeline.Item>
            <Timeline.Point icon={Lightbulb} />
            <Timeline.Content>
              <Timeline.Title>1. Définir votre idée</Timeline.Title>
              <Timeline.Body>
                Identifiez le but de votre projet, les personnes concernées et les ressources nécessaires.
              </Timeline.Body>
            </Timeline.Content>
          </Timeline.Item>
          <Timeline.Item>
            <Timeline.Point icon={Edit} />
            <Timeline.Content>
              <Timeline.Title>2. Créer votre projet</Timeline.Title>
              <Timeline.Body>
                Utilisez notre formulaire de création de projet pour définir les objectifs, ajouter des détails et planifier les étapes.
              </Timeline.Body>
            </Timeline.Content>
          </Timeline.Item>
          <Timeline.Item>
            <Timeline.Point icon={Share} />
            <Timeline.Content>
              <Timeline.Title>3. Partager votre projet</Timeline.Title>
              <Timeline.Body>
                Une fois votre projet créé, partagez-le avec vos contacts via les réseaux sociaux ou par e-mail.
              </Timeline.Body>
            </Timeline.Content>
          </Timeline.Item>
          <Timeline.Item>
            <Timeline.Point icon={Users} />
            <Timeline.Content>
              <Timeline.Title>4. Recevoir des participations</Timeline.Title>
              <Timeline.Body>
                Suivez les contributions, les messages et les interactions de votre réseau pour faire avancer votre projet.
              </Timeline.Body>
            </Timeline.Content>
          </Timeline.Item>
        </Timeline>
      </section>

      {/* Description de la vie du projet */}
      <section>
        <h2 className="text-3xl font-bold mb-6 text-center">Faire vivre votre projet</h2>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
          <Card>
            <h3 className="text-2xl font-bold mb-4">Participations</h3>
            <p>
              Suivez et gérez les participations reçues. Répondez aux questions des participants et remerciez-les pour leur soutien.
            </p>
          </Card>

          <Card>
            <h3 className="text-2xl font-bold mb-4">Gestion du projet</h3>
            <p>
              Modifiez les informations du projet, ajustez les objectifs ou ajoutez de nouvelles étapes au fur et à mesure de son avancement.
            </p>
          </Card>

          <Card>
            <h3 className="text-2xl font-bold mb-4">Réponses et retours</h3>
            <p>
              Consultez les retours des participants, répondez à leurs messages et collectez leurs avis pour améliorer votre projet.
            </p>
          </Card>

          <Card>
            <h3 className="text-2xl font-bold mb-4">Suivi des performances</h3>
            <p>
              Analysez les performances de votre projet grâce à des statistiques sur les participations, les interactions et les contributions.
            </p>
          </Card>
        </div>
      </section>

      {/* Bouton d'action */}
      <div className="text-center mt-12">
        <Button href="/offre" size="lg">
          Démarrer mon projet
        </Button>
      </div>
    </div>
  );
}

export default FonctionnementProjet;
