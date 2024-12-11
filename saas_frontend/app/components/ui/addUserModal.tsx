import React, { useState } from 'react';

type AddUserModalProps = {
  onAddUser: (newUser: Omit<User, 'id_utilisateur'>) => void;
  onClose: () => void;
};

const AddUserModal: React.FC<AddUserModalProps> = ({ onAddUser, onClose }) => {
  const [newUser, setNewUser] = useState<Omit<User, 'id_utilisateur'>>({
    emailUtilisateur: '',
    username: '',
    numTelUtilisateur: '',
    nomUtilisateur: '',
    prenomUtilisateur: '',
    role_utilisateur: '',
  });

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setNewUser((prev) => ({ ...prev, [name]: value }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    onAddUser(newUser);
    setNewUser({
      emailUtilisateur: '',
      username: '',
      numTelUtilisateur: '',
      nomUtilisateur: '',
      prenomUtilisateur: '',
      role_utilisateur: '',
    });
  };

  return (
    <div className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div className="bg-white p-6 rounded-md shadow-lg max-w-sm w-full">
        <h2 className="text-2xl font-semibold mb-4">Ajouter un Utilisateur</h2>
        <form onSubmit={handleSubmit} className="space-y-4">
          <div>
            <label className="block text-sm font-medium">Nom d&apos;utilisateur</label>
            <input
              type="text"
              name="username"
              value={newUser.username}
              onChange={handleChange}
              required
              className="w-full p-2 border border-gray-300 rounded-md"
            />
          </div>
          <div>
            <label className="block text-sm font-medium">Email</label>
            <input
              type="email"
              name="emailUtilisateur"
              value={newUser.emailUtilisateur}
              onChange={handleChange}
              required
              className="w-full p-2 border border-gray-300 rounded-md"
            />
          </div>
          <div>
            <label className="block text-sm font-medium">Numéro de téléphone</label>
            <input
              type="text"
              name="numTelUtilisateur"
              value={newUser.numTelUtilisateur}
              onChange={handleChange}
              className="w-full p-2 border border-gray-300 rounded-md"
            />
          </div>
          <div>
            <label className="block text-sm font-medium">Nom</label>
            <input
              type="text"
              name="nomUtilisateur"
              value={newUser.nomUtilisateur}
              onChange={handleChange}
              className="w-full p-2 border border-gray-300 rounded-md"
            />
          </div>
          <div>
            <label className="block text-sm font-medium">Prénom</label>
            <input
              type="text"
              name="prenomUtilisateur"
              value={newUser.prenomUtilisateur}
              onChange={handleChange}
              className="w-full p-2 border border-gray-300 rounded-md"
            />
          </div>
          <div>
            <label className="block text-sm font-medium">Rôle</label>
            <input
              type="text"
              name="role_utilisateur"
              value={newUser.role_utilisateur}
              onChange={handleChange}
              className="w-full p-2 border border-gray-300 rounded-md"
            />
          </div>
          <div className="flex justify-end space-x-4 mt-4">
            <button
              type="button"
              onClick={onClose}
              className="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300"
            >
              Annuler
            </button>
            <button
              type="submit"
              className="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
            >
              Ajouter
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default AddUserModal;