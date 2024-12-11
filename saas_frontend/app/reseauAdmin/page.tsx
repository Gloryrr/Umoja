"use client"
import React, { useState, useEffect } from 'react'
import { PlusCircle, Pencil, Trash2 } from 'lucide-react'
import { apiGet, apiPost, apiPatch, apiDelete, apiDeleteWithParams } from '../services/internalApiClients'
import Table from '../components/ui/tableAdmin';
import AddReseauModal from '../components/ui/addReseauModal';
import EditReseauModal from '../components/ui/EditReseauModal';
import LookUsersReseauModal from '../components/ui/LookUsersReseauModal';
import AddUserReseauModal from '../components/ui/AddUserReseauModal';

type Reseaux = {
  id: number;
  nomReseau : string;
  id_utilisateur: number;
  id_genre_musique: number;
  offre: number;
};

type ReseauAll = {
  id: number;
  nomReseau : string;
};





const columns = [
  { header: 'Nom', accessor: 'nomReseau' },
  { header: 'Actions', accessor: 'actions' },
  { header: 'Utilisateurs', accessor: 'utilisateurs' },
];


export default function ReseauManagement() {
  const [originalReseaux, setOriginalReseau] = useState<Reseaux[]>([]);
  const [filteredReseaux, setFilteredReseau] = useState<Reseaux[]>([]);


  const [isAddReseauOpen, setIsAddReseauOpen] = useState(false)
  const [isEditReseauOpen, setIsEditReseauOpen] = useState(false)

  
  const [currentReseau, setCurrentReseau] = useState<Reseaux | null>(null)

  const [lookUsersReseauOpen, setLookUsersReseauOpen] = useState(false)
  const [AddUsersReseauOpen, setAddUsersReseauOpen] = useState(false)


  const handleSearch = (searchTerm: string) => {
    const lowerCaseSearchTerm = searchTerm.toLowerCase();
    const filtered = originalReseaux.filter(user =>
      user.nomReseau.toLowerCase().includes(lowerCaseSearchTerm)
    );
    setFilteredReseau(filtered);
  };

  async function loadReseaux(){
    try {
      
    const fetchData = await apiGet('/reseaux');

    const utilisateursArray = JSON.parse(fetchData.reseaux);

    console.log(utilisateursArray);
    if (Array.isArray(utilisateursArray)) {
      setOriginalReseau(utilisateursArray);
      setFilteredReseau(utilisateursArray);
    }
    } catch (error) {
      
    }
  }


  const handleDeleteUserInReseau = async (
      reseau: {id: number; nom: string; utilisateurs: User[] },
      userId: number
    ) => {
    // Filtrer les utilisateurs pour exclure celui dont l'ID correspond
    const updatedUsers = reseau.utilisateurs.filter((user) => user.id !== userId);
  

  
    const reseauDataString = {
      idReseau: reseau.id,
      idUtilisateur: userId,
    };    
    const reseauData: JSON = JSON.parse(JSON.stringify(reseauDataString));
    
    await apiDeleteWithParams(`/reseau/delete-membre`, reseauData);
    console.log(`Utilisateur avec l'ID ${userId} supprimé du réseau ${reseau.id}`);
    console.log("Utilisateurs mis à jour :", updatedUsers);

    setLookUsersReseauOpen(false);
    loadReseaux();
  
    // Vous pouvez inclure une mise à jour de l'état ou une logique d'API ici
  };
  

  const handleAddReseau = async (newReseau: Omit<Reseaux, 'id_utilisateur'>) => {
    try {

      const reseauDataString = {
        nomReseau: newReseau.nomReseau,
      };

      const ReseauData: JSON = JSON.parse(JSON.stringify(reseauDataString));

      
      console.log(newReseau);
      await apiPost('/reseau/create', ReseauData);
      setIsAddReseauOpen(false);

      loadReseaux();

      
    } catch (error) {
      console.error('Erreur lors de l\'ajout de l\'utilisateur:', error);
    }
  };

  const handleEditReseau = async (updatedReseau: Reseaux) => {
    try {
      const ReseauData: JSON = JSON.parse(JSON.stringify(updatedReseau));
      console.log(updatedReseau);
      await apiPatch(`/reseau/update/${updatedReseau.id}`, ReseauData);
      loadReseaux();

      setIsEditReseauOpen(false);
    } catch (error) {
      console.error('Erreur lors de la modification de l\'utilisateur:', error);
    }
  };

  const onAddUserInReseau = async (idReseau: number, userId: number) => {
    try {
      const reseauDataString = {
        idReseau: idReseau,
        idUtilisateur: userId,
      };    
      const reseauData: JSON = JSON.parse(JSON.stringify(reseauDataString));
      
      await apiPost('/reseau/add-membre', reseauData);
      console.log(`Utilisateur avec l'ID ${userId} ajouté au réseau ${idReseau}`);
      setAddUsersReseauOpen(false);
      loadReseaux();
    } catch (error) {
      console.error('Erreur lors de l\'ajout de l\'utilisateur:', error);
    }
  }

  const handleDeleteUser = async (id: number) => {
    try {
        console.log(id);
        await apiDelete(`/reseau/delete/${id}`);
        loadReseaux();
        console.log(`Reseau ${id} supprimé avec succès.`);
    } catch (error) {
        console.error('Erreur lors de la suppression du reseau:', error);
    }
};

  useEffect(() => {
    loadReseaux();
  }, []);


  const data = filteredReseaux.map((reseau) => ({
    ...reseau,
    actions: (
      <div className="flex space-x-2">
        <button
          onClick={() => {
            setCurrentReseau(reseau);
            setIsEditReseauOpen(true);
          }}
          className="p-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
          <Pencil className="h-4 w-4" />
        </button>
        <button
          onClick={() => handleDeleteUser(reseau.id)}
          className="p-1 bg-red-100 text-red-600 rounded hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
        >
          <Trash2 className="h-4 w-4" />
        </button>
      </div>
    ),
    utilisateurs: (
      <div className="flex space-x-2">
        <button
          onClick={() => {
            setCurrentReseau(reseau);
            setLookUsersReseauOpen(true);
          }}
          className="p-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
          Voir
        </button>
        <button
          onClick={() => {
            setCurrentReseau(reseau);
            setAddUsersReseauOpen(true);
          }}
          className="p-1 bg-green-100 text-green-600 rounded hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
          Ajouter
        </button>
      </div>
    ),
  }));
  
  return (
    <div className="container mx-auto p-6 space-y-8">
      <h1 className="text-3xl font-bold">Gestion des Reseaux</h1>

      <div className="flex justify-between items-center">
        <input
          className="max-w-sm px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Rechercher un reseau ..."
          onChange={(e) => handleSearch(e.target.value)}
        />
        <button
          onClick={() => setIsAddReseauOpen(true)}
          className="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
          <PlusCircle className="inline-block mr-2 h-4 w-4" />
          Ajouter un reseau
        </button>
      </div>

      <div className="overflow-x-auto">
        <Table columns={columns} data={data} />;
      </div>

      {/* Modale pour l'ajout et l'édition d'utilisateur */}
      {isAddReseauOpen && (
        <AddReseauModal onAddReseau={handleAddReseau} onClose={() => setIsAddReseauOpen(false)} />
      )}
      {isEditReseauOpen && currentReseau && (
        <EditReseauModal reseau={currentReseau} onEditReseau={handleEditReseau} onClose={() => setIsEditReseauOpen(false)} />
      )}
      {AddUsersReseauOpen && currentReseau && (
        <AddUserReseauModal reseau={currentReseau} onAddUserInReseau={onAddUserInReseau} onClose={() => setAddUsersReseauOpen(false)} />
      )}

      {lookUsersReseauOpen && currentReseau && (
        <LookUsersReseauModal reseau={currentReseau} onDeleteUser={handleDeleteUserInReseau} onClose={() => setLookUsersReseauOpen(false)} />
      )}
    </div>
  );
}

