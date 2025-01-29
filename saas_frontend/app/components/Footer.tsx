"use client";

import { Footer } from "flowbite-react";
import { Mail } from "lucide-react";
// import { useState, useEffect } from "react";
// import { apiGet } from "../services/internalApiClients";

function FooterComponent() {

    return (
      <Footer container className="py-12 rounded-none border-t border-dark dark:border-gray-500">
        <div className="w-full mx-auto">
          {/* Logo et menu principal */}
          <div className="grid grid-cols-2 gap-10 md:gap-20">
            {/* Colonne gauche : logo et texte */}
            <div>
              <Footer.Brand
                href="https://umoja.com"
                src="/favicon.ico"
                alt="Umoja Logo"
                name="Umoja"
                className="text-lg font-bold"
              />
                <p className="mt-4 text-sm mr-6">
                  Umoja est une plateforme innovante dédiée à la gestion et au suivi de projets collaboratifs. 
                  Découvrez comment contribuez et démarrez votre projets musicaux dès maintenant !
                </p>
            </div>
  
            {/* Colonne droite : liens */}
            <div className="grid grid-cols-3 gap-8">
              <div>
                <Footer.Title title="Les projets" className="uppercase text-sm font-semibold mb-4" />
                <Footer.LinkGroup col className="space-y-4">
                  <Footer.Link href="/offre" className="text-sm">
                    Démarrer votre projet dès maintenant
                  </Footer.Link>
                  <Footer.Link href="/networks" className="text-sm">
                    Découvrez les projets de vos réseaux
                  </Footer.Link>
                  <Footer.Link href="/fonctionnement-projet" className="text-sm">
                    Comment ça marche ?
                  </Footer.Link>
                  <Footer.Link href="/participations" className="text-sm">
                    Les Participations
                  </Footer.Link>
                </Footer.LinkGroup>
              </div>
  
              <div>
                <Footer.Title title="À propos" className="uppercase text-sm font-semibold mb-4" />
                <Footer.LinkGroup col className="space-y-4">
                  <Footer.Link href="/umoja" className="text-sm">
                    Qui est Umoja ?
                  </Footer.Link>
                  <Footer.Link href="/consentement-mail" className="text-sm">
                    Mon consentement aux emails
                  </Footer.Link>
                  <Footer.Link href="/comprendre-les-preferences-de-notifications" className="text-sm">
                    Les préférences
                  </Footer.Link>
                  <Footer.Link href="/politique-confidentialite" className="text-sm">
                    Politique de confidentialité
                  </Footer.Link>
                </Footer.LinkGroup>
              </div>
  
              <div>
                <Footer.Title title="Profil" className="uppercase text-sm font-semibold mb-4" />
                <Footer.LinkGroup col className="space-y-4">
                  <Footer.Link href="/profil" className="text-sm">
                    Mon profil
                  </Footer.Link>
                  <Footer.Link href="/tableau-de-bord" className="text-sm">
                    Mon tableau de bord
                  </Footer.Link>
                  <Footer.Link href="/preferences-notifications" className="text-sm">
                    Mes préférences
                  </Footer.Link>
                </Footer.LinkGroup>
              </div>
            </div>
          </div>
  
          {/* Divider */}
          <Footer.Divider className="my-8" />
  
          {/* Réseaux sociaux et copyright */}
          <div className="flex flex-col sm:flex-row sm:justify-between sm:items-center text-center sm:text-left">
            <Footer.Copyright
              by="Umoja™"
              year={new Date().getFullYear()}
              className="text-sm mb-4 sm:mb-0"
            />
            <div className="flex justify-center space-x-6">
              <Footer.Icon href="/contact" icon={Mail} className="w-5 h-5" />
            </div>
          </div>
        </div>
      </Footer>
    );
}

export default FooterComponent;
