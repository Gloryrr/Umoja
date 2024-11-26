"use client";

import { Button, Card, Timeline } from "flowbite-react";
import { Lightbulb, Edit, Share, Users } from "lucide-react";

function FonctionnementProjet() {
  return (
    <div className="py-12 px-6">
      {/* Titre principal */}
      <div className="text-xl text-center mb-10">
        <h1 className="font-bold mb-4">Comment fonctionne la création d'une offre de projet ?</h1>
        <p className="text-base">
          Découvrez comment construire, gérer et faire vivre votre projet sur notre application et au sein de vos réseaux.
        </p>
      </div>

      {/* Définition d'un projet */}
      <section className="mb-12">
        <Card>
          <h2 className="font-bold mb-4">Qu'est-ce qu'une offre de projet ?</h2>
          <p className="text-base">
            Un offre de projet est une idée d'évènement musical que vous souhaitez concrétiser grâce à l'aide de votre réseau
            et de notre plateforme. 
            Votre réseau vous permet de trouver des personnes qui souhaite vous aider à rendre ce projet réalisable en participant financièrement.
          </p>
        </Card>
      </section>

      {/* Étapes de création */}
      <section className="mb-12">
        <h2 className="text-xl font-bold mb-6 text-center">Étapes pour construire un projet</h2>
        <Timeline>
          <Timeline.Item>
            <Timeline.Point icon={Lightbulb} />
            <Timeline.Content>
              <Timeline.Title>1. Définir votre évènement musical</Timeline.Title>
              <Timeline.Body>
                Identifiez les éléments principaux de votre évènement musical comme par exemple le lieu, la description, les dates, les artistes, le budget que vous aimeriez avoir pour réaliser ce projet, etc....
              </Timeline.Body>
            </Timeline.Content>
          </Timeline.Item>
          <Timeline.Item>
            <Timeline.Point icon={Edit} />
            <Timeline.Content>
              <Timeline.Title>2. Créer votre offre de projet</Timeline.Title>
              <Timeline.Body>
                Grâce à notre plateforme, utilisez notre formulaire de création de projet pour définir les détails nécessaires et planifier les étapes.
              </Timeline.Body>
            </Timeline.Content>
          </Timeline.Item>
          <Timeline.Item>
            <Timeline.Point icon={Share} />
            <Timeline.Content>
              <Timeline.Title>3. Partager votre offre</Timeline.Title>
              <Timeline.Body>
                Une fois votre projet créé, partagez-le dans vos réseaux via notre plateforme.
              </Timeline.Body>
            </Timeline.Content>
          </Timeline.Item>
          <Timeline.Item>
            <Timeline.Point icon={Users} />
            <Timeline.Content>
              <Timeline.Title>4. Recevoir des participations</Timeline.Title>
              <Timeline.Body>
                Suivez les offres de contributions, les commentaires et les interactions de votre réseau pour faire avancer votre projet.
              </Timeline.Body>
            </Timeline.Content>
          </Timeline.Item>
        </Timeline>
      </section>

      {/* Description de la vie du projet */}
      <section>
        <h2 className="font-bold mb-6 text-center">Faire vivre votre projet</h2>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
          <Card>
            <h3 className="font-bold mb-4">Participations</h3>
            <p>
              Suivez et gérez les participations reçues. Répondez aux questions des participants.
            </p>
          </Card>

          <Card>
            <h3 className="font-bold mb-4">Gestion du projet</h3>
            <p>
              Modifiez les informations du projet, ajustez le budget nécessaire, les artistes ou le lieux au fur et à mesure de l'avancement.
            </p>
          </Card>

          <Card>
            <h3 className="font-bold mb-4">Réponses et retours</h3>
            <p>
              Consultez les retours des participants et répondez à leurs commentaires.
            </p>
          </Card>

          <Card>
            <h3 className="font-bold mb-4">Tableau de bord</h3>
            <p>
              Suivez l'avancement de votre projet depuis le tableau de bord, visualisez la bar de progression du budget total et disuctez avec les participants.
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
