"use client"

import React from 'react';
import { FaCalendarAlt, FaMapMarkerAlt, FaUsers, FaLink } from "react-icons/fa";
import NavigationHandler from  '../components/router';

interface Offre {
  title_offre: string;
  dead_line: string;
  descr_tournee: string;
  date_min_proposee: string;
  date_max_proposee: string;
  ville_visee: string;
  region_visee: string;
  places_min: number;
  places_max: number;
  nb_artistes_concernes: number;
  nb_invites_concernes: number;
  liens_promotionnels: string;
}

const initialOffre: Offre = {
  title_offre: "",
  dead_line: "",
  descr_tournee: "",
  date_min_proposee: "",
  date_max_proposee: "",
  ville_visee: "",
  region_visee: "",
  places_min: 0,
  places_max: 0,
  nb_artistes_concernes: 0,
  nb_invites_concernes: 0,
  liens_promotionnels: "",
};

export default function Offre() {
  const [offre, setOffre] = React.useState<Offre>(initialOffre);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    const { name, value } = e.target;
    setOffre(prevOffre => ({
      ...prevOffre,
      [name]: value
    }));
  };

  const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    console.log('Offre soumise:', offre);
    // Logique d'envoi des données au serveur
  };

  return (
    <div className="max-w-2xl mx-auto bg-gray-800 p-8 rounded-lg text-white font-nunito m-[2em]">
      <h1 className="text-center text-2xl md:text-4xl font-bold pb-6">Créer une nouvelle offre</h1>
      <form onSubmit={handleSubmit} className="space-y-6">
        
        <div className="space-y-2">
          <label htmlFor="title_offre" className="text-lg">Titre de l'offre</label>
          <div className="relative">
            <input
              type="text"
              name="title_offre"
              value={offre.title_offre}
              onChange={handleChange}
              placeholder="Titre de l'offre"
              required
              className="w-full bg-gray-900 border border-gray-700 rounded-full p-3 pl-10 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500"
            />
            <FaCalendarAlt className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500" />
          </div>
        </div>

        <div className="space-y-2">
          <label htmlFor="dead_line" className="text-lg">Date limite de soumission</label>
          <div className="relative">
            <input
              type="datetime-local"
              name="dead_line"
              value={offre.dead_line}
              onChange={handleChange}
              required
              className="w-full bg-gray-900 border border-gray-700 rounded-full p-3 pl-10 text-white focus:outline-none focus:border-blue-500"
            />
            <FaCalendarAlt className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500" />
          </div>
        </div>

        <div className="space-y-2">
          <label htmlFor="descr_tournee" className="text-lg">Description de la tournée</label>
          <textarea
            name="descr_tournee"
            value={offre.descr_tournee}
            onChange={handleChange}
            placeholder="Description de la tournée"
            required
            className="w-full h-32 bg-gray-900 border border-gray-700 rounded-lg p-3 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 resize-none"
          ></textarea>
        </div>

        <div className="flex space-x-4">
          <div className="space-y-2 flex-1">
            <label htmlFor="date_min_proposee" className="text-lg">Date min proposée</label>
            <input
              type="datetime-local"
              name="date_min_proposee"
              value={offre.date_min_proposee}
              onChange={handleChange}
              required
              className="w-full bg-gray-900 border border-gray-700 rounded-full p-3 text-white focus:outline-none focus:border-blue-500"
            />
          </div>
          <div className="space-y-2 flex-1">
            <label htmlFor="date_max_proposee" className="text-lg">Date max proposée</label>
            <input
              type="datetime-local"
              name="date_max_proposee"
              value={offre.date_max_proposee}
              onChange={handleChange}
              required
              className="w-full bg-gray-900 border border-gray-700 rounded-full p-3 text-white focus:outline-none focus:border-blue-500"
            />
          </div>
        </div>

        <div className="flex space-x-4">
          <div className="space-y-2 flex-1">
            <label htmlFor="ville_visee" className="text-lg">Ville visée</label>
            <div className="relative">
              <input
                type="text"
                name="ville_visee"
                value={offre.ville_visee}
                onChange={handleChange}
                placeholder="Ville visée"
                required
                className="w-full bg-gray-900 border border-gray-700 rounded-full p-3 pl-10 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500"
              />
              <FaMapMarkerAlt className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500" />
            </div>
          </div>
          <div className="space-y-2 flex-1">
            <label htmlFor="region_visee" className="text-lg">Région visée</label>
            <div className="relative">
              <input
                type="text"
                name="region_visee"
                value={offre.region_visee}
                onChange={handleChange}
                placeholder="Région visée"
                required
                className="w-full bg-gray-900 border border-gray-700 rounded-full p-3 pl-10 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500"
              />
              <FaMapMarkerAlt className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500" />
            </div>
          </div>
        </div>

        <div className="flex space-x-4">
          <div className="space-y-2 flex-1">
            <label htmlFor="places_min" className="text-lg">Places min</label>
            <input
              type="number"
              name="places_min"
              value={offre.places_min}
              onChange={handleChange}
              placeholder="Places min"
              required
              className="w-full bg-gray-900 border border-gray-700 rounded-full p-3 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500"
            />
          </div>
          <div className="space-y-2 flex-1">
            <label htmlFor="places_max" className="text-lg">Places max</label>
            <input
              type="number"
              name="places_max"
              value={offre.places_max}
              onChange={handleChange}
              placeholder="Places max"
              required
              className="w-full bg-gray-900 border border-gray-700 rounded-full p-3 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500"
            />
          </div>
        </div>

        <div className="relative space-y-2">
            <label htmlFor="liens_promotionnels" className="text-lg">Liens promotionnels</label>
            <div className="relative">
                <input
                type="url"
                name="liens_promotionnels"
                value={offre.liens_promotionnels}
                onChange={handleChange}
                placeholder="Liens promotionnels"
                className="w-full bg-gray-900 border border-gray-700 rounded-full p-3 pl-10 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500"
                />
                <FaLink className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500" />
            </div>
            </div>


        <button type="submit" className="w-full h-12 bg-blue-600 rounded-full font-bold text-white hover:bg-blue-700 focus:outline-none">
          Créer l'offre
        </button>

        <div className="text-center text-sm mt-4">
          <p>Vous avez des questions sur la création d'offres ?
            <NavigationHandler>
              {(handleNavigation: (path: string) => void) => (
                <a onClick={() => handleNavigation('/faq')} className="text-blue-500 font-semibold hover:underline"> Consultez notre FAQ</a>
              )}
            </NavigationHandler>
          </p>
        </div>
      </form>
    </div>
  );
}
