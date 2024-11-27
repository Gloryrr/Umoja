import React, { useState, useEffect } from 'react';

type EditUserModalProps = {
  user: User;
  onEditUser: (updatedUser: User) => void;
  onClose: () => void;
};

const EditUserModal: React.FC<EditUserModalProps> = ({ user, onEditUser, onClose }) => {
  const [updatedUser, setUpdatedUser] = useState<User>(user);

  useEffect(() => {
    setUpdatedUser(user);
  }, [user]);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setUpdatedUser((prev) => ({ ...prev, [name]: value }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    onEditUser(updatedUser);
  };

  return (
    <div className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div className="bg-white p-6 rounded-md shadow-lg max-w-sm w-full">
        <h2 className="text-2xl font-semibold mb-4">Modifier l'Utilisateur</h2>
        <form onSubmit={handleSubmit} className="space-y-4">
          <div>
            <label htmlFor="username" className="block text-sm font-medium">Nom d'utilisateur</label>
            <input
              type="text"
              name="username"
              value={updatedUser.username}
              onChange={handleChange}
              required
              className="w-full p-2 border border-gray-300 rounded-md"
            />
          </div>
          <div>
            <label htmlFor="emailUtilisateur" className="block text-sm font-medium">Email</label>
            <input
              id="emailUtilisateur"
              type="email"
              name="emailUtilisateur"
              value={updatedUser.emailUtilisateur}
              onChange={handleChange}
              required
              className="w-full p-2 border border-gray-300 rounded-md"
            />
          </div>
          <div>
            <label htmlFor="numTelUtilisateur" className="block text-sm font-medium">Numéro de téléphone</label>
            <input
              id="numTelUtilisateur"
              type="text"
              name="numTelUtilisateur"
              value={updatedUser.numTelUtilisateur}
              onChange={handleChange}
              className="w-full p-2 border border-gray-300 rounded-md"
            />
          </div>
          <div>
            <label htmlFor="nomUtilisateur" className="block text-sm font-medium">Nom</label>
            <input
              id="nomUtilisateur"
              type="text"
              name="nomUtilisateur"
              value={updatedUser.nomUtilisateur}
              onChange={handleChange}
              className="w-full p-2 border border-gray-300 rounded-md"
            />
          </div>
          <div>
            <label htmlFor="prenomUtilisateur" className="block text-sm font-medium">Prénom</label>
            <input
              type="text"
              name="prenomUtilisateur"
              value={updatedUser.prenomUtilisateur}
              onChange={handleChange}
              className="w-full p-2 border border-gray-300 rounded-md"
            />
          </div>
          <div>
            <label htmlFor="role_utilisateur" className="block text-sm font-medium">Rôle</label>
            <input
              id="role_utilisateur"
              type="text"
              name="role_utilisateur"
              value={updatedUser.role_utilisateur}
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
              Modifier
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default EditUserModal;