"use client"
import React, { useState, useEffect } from 'react'
import { PlusCircle, Pencil, Trash2 } from 'lucide-react'
import { apiGet, apiPost, apiPatch, apiDelete } from '../services/internalApiClients'
import AddUserModal from '../components/ui/addUserModal';
import EditUserModal from '../components/ui/EditUserModal';
import Table from '../components/ui/tableAdmin';
import { User } from '../components/ui/modal';


const columns = [
  { header: 'Pseudo', accessor: 'username' },
  { header: 'Email', accessor: 'emailUtilisateur' },
  { header: 'Rôle', accessor: 'role_utilisateur' },
  { header: 'Nom', accessor: 'nomUtilisateur' },
  { header: 'Prénom', accessor: 'prenomUtilisateur' },
  { header: 'Téléphone', accessor: 'numTelUtilisateur' },
  { header: 'Actions', accessor: 'actions' },
];


export default function UserManagement() {
  const [originalUsers, setOriginalUsers] = useState<User[]>([]);
  const [filteredUsers, setFilteredUsers] = useState<User[]>([]);

  const [isAddUserOpen, setIsAddUserOpen] = useState(false)
  const [isEditUserOpen, setIsEditUserOpen] = useState(false)
  const [currentUser, setCurrentUser] = useState<User | null>(null)

  const handleSearch = (searchTerm: string) => {
    const lowerCaseSearchTerm = searchTerm.toLowerCase();
    const filtered = originalUsers.filter(user =>
      user.username.toLowerCase().includes(lowerCaseSearchTerm) ||
      user.emailUtilisateur.toLowerCase().includes(lowerCaseSearchTerm) ||
      user.nomUtilisateur?.toLowerCase().includes(lowerCaseSearchTerm) ||
      user.prenomUtilisateur?.toLowerCase().includes(lowerCaseSearchTerm) ||
      user.numTelUtilisateur?.includes(lowerCaseSearchTerm)
    );
    setFilteredUsers(filtered);
  };


  async function loadUtilisateur(){
    try {
      
    const fetchData = await apiGet('/utilisateurs');
    const utilisateursArray = JSON.parse(fetchData.utilisateurs);

    if (Array.isArray(utilisateursArray)) {
      setOriginalUsers(utilisateursArray);
      setFilteredUsers(utilisateursArray);
    }
    } catch (error) {
      console.error('Erreur lors du chargement des utilisateurs:', error);
    }
  }

  const handleAddUser = async (newUser: Omit<User, 'id'>) => {
    try {

      const userdata1 = {
        emailUtilisateur: newUser.emailUtilisateur,
        username: newUser.username,
        mdpUtilisateur: "defaultpassword", // Assuming a default password for new users
        numTelUtilisateur: newUser.numTelUtilisateur ?? "",
        nomUtilisateur: newUser.nomUtilisateur ?? "",
        prenomUtilisateur: newUser.prenomUtilisateur ?? ""
      };

      const userData: JSON = JSON.parse(JSON.stringify(userdata1));

      

      await apiPost('/utilisateurs/create', userData);
      setIsAddUserOpen(false);

      loadUtilisateur();

      
    } catch (error) {
      console.error('Erreur lors de l\'ajout de l\'utilisateur:', error);
    }
  };

  const handleEditUser = async (updatedUser: User) => {
    try {
      const userData: JSON = JSON.parse(JSON.stringify(updatedUser));
      await apiPatch(`/utilisateurs/update/${updatedUser.id}`, userData);

      loadUtilisateur();

      setIsEditUserOpen(false);
    } catch (error) {
      console.error('Erreur lors de la modification de l\'utilisateur:', error);
    }
  };

  const handleDeleteUser = async (id: number) => {
    try {
        console.log(id);
        await apiDelete(`/utilisateurs/delete/${id}`);
        loadUtilisateur();
        console.log(`Utilisateur ${id} supprimé avec succès.`);
    } catch (error) {
        console.error('Erreur lors de la suppression de l\'utilisateur:', error);
    }
};

  useEffect(() => {
    loadUtilisateur();
  }, []);


  const data = filteredUsers.map((user) => ({
    ...user,
    actions: (
      <div className="flex space-x-2">
        <button
          onClick={() => {
            setCurrentUser(user);
            setIsEditUserOpen(true);
          }}
          className="p-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
          <Pencil className="h-4 w-4" />
        </button>
        <button
          onClick={() => handleDeleteUser(user.id)}
          className="p-1 bg-red-100 text-red-600 rounded hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
        >
          <Trash2 className="h-4 w-4" />
        </button>
      </div>
    ),
  }));
  
  return (
    <div className="container mx-auto p-6 space-y-8">
      <h1 className="text-3xl font-bold">Gestion des Utilisateurs</h1>

      <div className="flex justify-between items-center">
        <input
          className="max-w-sm px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Rechercher un utilisateur..."
          onChange={(e) => handleSearch(e.target.value)}
        />
        <button
          onClick={() => setIsAddUserOpen(true)}
          className="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
          <PlusCircle className="inline-block mr-2 h-4 w-4" />
          Ajouter un Utilisateur
        </button>
      </div>

      <div className="overflow-x-auto">
        <Table columns={columns} data={data} />;
      </div>

      {/* Modale pour l'ajout et l'édition d'utilisateur */}
      {isAddUserOpen && (
        <AddUserModal onAddUser={handleAddUser} onClose={() => setIsAddUserOpen(false)} />
      )}
      {isEditUserOpen && currentUser && (
        <EditUserModal user={currentUser} onEditUser={handleEditUser} onClose={() => setIsEditUserOpen(false)} />
      )}
    </div>
  );
}

