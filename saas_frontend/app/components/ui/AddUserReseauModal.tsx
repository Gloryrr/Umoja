import { apiGet } from '@/app/services/internalApiClients';
import React, { useState } from 'react';

type AddReseauModalProps = {
  reseau: Reseaux;
  onAddUserInReseau: ( idReseau: string, idUtilisateur: string) => void;
  onClose: () => void;
};

const AddReseauModal: React.FC<AddReseauModalProps> = ({reseau, onAddUserInReseau, onClose }) => {
 
  const [allUtilisateurs, setAllUtilisateurs] = useState<User[]>([]);

  const [userInReseau, setUserInReseau] = useState< { idReseau: string; idUtilisateur: string }>({
      idReseau: reseau.id,
      idUtilisateur: '',
    });

  async function loadUtilisateur(){
    try {
      
    const fetchData = await apiGet('/utilisateurs');
    const utilisateursArray = JSON.parse(fetchData.utilisateurs);

    if (Array.isArray(utilisateursArray)) {
      setAllUtilisateurs(utilisateursArray);
    }
    } catch (error) {
      console.error('Erreur lors du chargement des utilisateurs:', error);
    }
  }

  const handleChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    const { name, value } = e.target;
    setUserInReseau((prev) => ({ ...prev, [name]: value }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    onAddUserInReseau(userInReseau.idReseau, userInReseau.idUtilisateur);
  };

  React.useEffect(() => {
    loadUtilisateur();
  }, []);
  console.log(allUtilisateurs);

  return (
    <div className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div className="bg-white p-6 rounded-md shadow-lg max-w-sm w-full">
        <h2 className="text-2xl font-semibold mb-4">Ajouter un utilisateur au reseau </h2>
        <form onSubmit={handleSubmit} className="space-y-4">
          <div>
            <label className="block text-sm font-medium">Choisir le nom d'utilisateur </label>
            <select
              name="idUtilisateur"
              onChange={(e) => {
              handleChange(e);
              setUserInReseau((prev) => ({
                ...prev,
                idUtilisateur: e.target.value,
              }));
              }}
              required
              className="w-full p-2 border border-gray-300 rounded-md"
            >
              {allUtilisateurs.map((utilisateur) => (
              <option key={utilisateur.id} value={utilisateur.id}>
                {utilisateur.username}
              </option>
              ))}
            </select>
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

export default AddReseauModal;
