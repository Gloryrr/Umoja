"use client";

import { Card, Button } from "flowbite-react";
import { Music, Users, Globe } from "lucide-react";

function UmodDJA() {
  return (
    <div className="py-12 px-6">
      {/* Titre principal */}
      <div className="text-center mb-10">
        <h1 className="text-2xl font-bold mb-4">UmoDJA</h1>
      </div>

      {/* Présentation du concept */}
      <section className="mb-12">
        <Card className="max-w-4xl mx-auto">
          <h2 className="text-xl font-bold mb-4">Qu&apos;est-ce qu&apos;UmoDJA ?</h2>
          <p className="text-gray-700">
            UmoDJA est une plateforme participative dédiée aux projets d&apos;événements musicaux. Elle permet aux artistes,
            organisateurs et passionnés de collaborer pour créer des expériences uniques. Que vous soyez musicien,
            DJ, ou simplement fan de musique, UmoDJA vous offre les outils pour financer, organiser et vivre des
            événements mémorables.
          </p>
        </Card>
      </section>

      {/* Objectifs de la plateforme */}
      <section className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <Card>
          <div className="flex flex-col items-center">
            <Music className="w-12 h-12 text-blue-500 mb-4" />
            <h3 className="text-xl font-semibold mb-2">Soutenir les artistes</h3>
            <p className="text-gray-700 text-center">
              Permettre aux talents émergents de trouver des financements et d&apos;organiser leurs propres événements.
            </p>
          </div>
        </Card>

        <Card>
          <div className="flex flex-col items-center">
            <Users className="w-12 h-12 text-green-500 mb-4" />
            <h3 className="text-xl font-semibold mb-2">Créer une communauté</h3>
            <p className="text-gray-700 text-center">
              Mettre en relation les passionnés de musique, les organisateurs et les artistes pour créer ensemble des
              événements uniques.
            </p>
          </div>
        </Card>

        <Card>
          <div className="flex flex-col items-center">
            <Globe className="w-12 h-12 text-yellow-500 mb-4" />
            <h3 className="text-xl font-semibold mb-2">Faciliter l&apos;organisation</h3>
            <p className="text-gray-700 text-center">
              Offrir des outils simples et efficaces pour planifier et gérer des événements musicaux en toute
              sérénité.
            </p>
          </div>
        </Card>
      </section>

      {/* Appel à l&apos;action */}
      <div className="text-center">
        <Button href="/offre" size="lg">
          Démarrer votre projet dès maintenant
        </Button>
      </div>
    </div>
  );
}

export default UmodDJA;
