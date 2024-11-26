"use client";

import { Card, Timeline, Button } from "flowbite-react";
import { MessageCircle, DollarSign, CheckCircle, XCircle } from "lucide-react";

function Participations() {
  return (
    <div className="py-12 px-6">
      {/* Titre principal */}
      <div className="text-center mb-10">
        <h1 className="text-xl font-bold mb-4">Comment fonctionnent les participations ?</h1>
        <p className="text-base">
          Découvrez comment vous pouvez participer à des projets et comment gérer les contributions reçues pour vos propres offres.
        </p>
      </div>

      {/* Participer à une offre */}
      <section className="mb-12">
        <h2 className="text-xl font-bold mb-6 text-center">Participer à un projet musical</h2>
        <Timeline>
          <Timeline.Item>
            <Timeline.Point icon={MessageCircle} />
            <Timeline.Content>
              <Timeline.Title>1. Commenter une offre</Timeline.Title>
              <Timeline.Body>
                Trouvez une offre qui vous intéresse et participez en commentant le projet pour discuter du projet.
              </Timeline.Body>
            </Timeline.Content>
          </Timeline.Item>
          <Timeline.Item>
            <Timeline.Point icon={DollarSign} />
            <Timeline.Content>
              <Timeline.Title>2. Indiquer votre participation financière</Timeline.Title>
              <Timeline.Body>
                Soutenez le projet en indiquant le montant que vous souhaitez contribuer à la cagnotte. Chaque
                participation financière aide le créateur de l&apos;offre à atteindre son objectif.
              </Timeline.Body>
            </Timeline.Content>
          </Timeline.Item>
        </Timeline>
      </section>

      {/* Recevoir des participations */}
      <section>
        <h2 className="text-xl font-bold mb-6 text-center">Gérer les participations de votre offre</h2>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
          <Card>
            <h3 className="text-xl font-bold mb-4">Accepter une participation</h3>
            <p>
              Lorsqu&apos;une personne participe à votre projet, vous recevez une notification. Vous pouvez accepter la
              participation si elle correspond à vos attentes.
            </p>
            <div className="flex justify-center mt-4">
              <CheckCircle className="w-10 h-10 text-green-500" />
            </div>
          </Card>

          <Card>
            <h3 className="text-xl font-bold mb-4">Refuser une participation</h3>
            <p>
              Si une participation ne correspond pas aux objectifs ou aux besoins de votre projet, vous pouvez la
              refuser en expliquant brièvement votre décision.
            </p>
            <div className="flex justify-center mt-4">
              <XCircle className="w-10 h-10 text-red-500" />
            </div>
          </Card>
        </div>
      </section>

      {/* Appel à l'action */}
      <div className="text-center mt-12">
        <Button href="/offre" size="lg">
          Voir les offres disponibles
        </Button>
      </div>
    </div>
  );
}

export default Participations;
