"use client"
import React from 'react'
import {DashboardCard} from "../components/ui/cardsAdmin"
import { Users, Music, StickerIcon as Stadium, BarChart3, Calendar, Bell } from 'lucide-react'

export default function AccueilAdmin() {
    return (
    <div className="h-full w-full bg-cover bg-center bg-no-repeat flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div className="h-full  w-full space-y-8 backdrop-blur-sm bg-white/30 p-8 rounded-2xl shadow-2xl">
          <div className="text-center">
            <h2 className="mt-6 text-4xl font-extrabold text-gray-900">
              Tableau de bord administrateur
            </h2>
            <p className="mt-2 text-lg text-gray-700">
              Gérez vos utilisateurs, concerts et stades
            </p>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <DashboardCard
              title="Utilisateurs"
              description="Gérer les comptes utilisateurs"
              icon={Users}
              link="/utilisateurAdmin"
            />
            <DashboardCard
              title="Concerts"
              description="Organiser et gérer les concerts"
              icon={Music}
              link="/accueille"
            />
            <DashboardCard
              title="Stades"
              description="Gérer les lieux de concerts"
              icon={Stadium}
              link="/accueille"
            />
            <DashboardCard
              title="Statistiques"
              description="Voir les statistiques globales"
              icon={BarChart3}
              link="/accueille"
            />
            <DashboardCard
              title="Calendrier"
              description="Planifier les événements"
              icon={Calendar}
              link="/accueille"
            />
            <DashboardCard
              title="Notifications"
              description="Gérer les alertes et messages"
              icon={Bell}
              link="/accueille"
            />
          </div>
        </div>
      </div>
    )
  }
  
  