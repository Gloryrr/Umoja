import React, { useState } from 'react';

type LookUsersReseauModalProps = {
  reseau: {
    id : number;
    nom: string;
    utilisateurs: User[]; // Liste des utilisateurs du réseau
  };
  onClose: () => void;
  onDeleteUser: (reseau: { id: number; nom: string; utilisateurs: User[] }, userId: number) => void; // Fonction pour supprimer un utilisateur
};

const LookUsersReseauModal: React.FC<LookUsersReseauModalProps> = ({
  reseau,
  onClose,
  onDeleteUser,
}) => {
  const [searchQuery, setSearchQuery] = useState(''); // État pour le champ de recherche
  // Filtrer les utilisateurs en fonction du nom ou de l'email
  const filteredUsers = reseau.utilisateurs.filter(
    (user) =>
      user.username.toLowerCase().includes(searchQuery.toLowerCase()) ||
      user.emailUtilisateur.toLowerCase().includes(searchQuery.toLowerCase())
  );

  console.log(filteredUsers);
  return (
    <div className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div className="bg-white p-6 rounded-md shadow-lg max-w-lg w-full">
        <h2 className="text-2xl font-semibold mb-4">Utilisateurs du Réseau: {reseau.nom}</h2>
        
        {/* Champ de recherche */}
        <input
          type="text"
          placeholder="Rechercher par nom ou email"
          value={searchQuery}
          onChange={(e) => setSearchQuery(e.target.value)}
          className="w-full mb-4 p-2 border border-gray-300 rounded-md"
        />
        
        <ul className="space-y-4">
          {filteredUsers.length > 0 ? (
            filteredUsers.map((user) => (
              <li
                key={user.id}
                className="flex justify-between items-center border-b pb-2"
              >
                <div>
                  <p className="text-sm font-medium">{user.username}</p>
                  <p className="text-sm text-gray-600">{user.emailUtilisateur}</p>
                </div>
                <button
                  onClick={() => onDeleteUser(reseau, user.id)}
                  className="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600"
                >
                  Supprimer
                </button>
              </li>
            ))
          ) : (
            <p className="text-gray-500">Aucun utilisateur ne correspond à votre recherche.</p>
          )}
        </ul>
        
        <div className="flex justify-end space-x-4 mt-4">
          <button
            type="button"
            onClick={onClose}
            className="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300"
          >
            Fermer
          </button>
        </div>
      </div>
    </div>
  );
};

export default LookUsersReseauModal;
