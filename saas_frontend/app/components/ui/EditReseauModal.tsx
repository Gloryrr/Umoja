import React, { useState, useEffect } from 'react';

type EditReseauModalProps = {
  reseau: Reseaux;
  onEditReseau: (updatedReseau: Reseaux) => void;
  onClose: () => void;
};

const EditReseauModal: React.FC<EditReseauModalProps> = ({ reseau, onEditReseau, onClose }) => {
  const [updatedReseau, setUpdatedReseau] = useState<Reseaux>(reseau);

  useEffect(() => {
    setUpdatedReseau(reseau);
  }, [reseau]);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setUpdatedReseau((prev) => ({ ...prev, [name]: value }));

  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    onEditReseau(updatedReseau);
  };

  return (
    <div className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div className="bg-white p-6 rounded-md shadow-lg max-w-sm w-full">
        <h2 className="text-2xl font-semibold mb-4">Modifier le Réseau</h2>
        <form onSubmit={handleSubmit} className="space-y-4">
          <div>
            <label htmlFor="nom" className="block text-sm font-medium">Nom du Réseau</label>
            <input
              type="text"
              name="nomReseau"
              value={updatedReseau.nomReseau}
              onChange={handleChange}
              required
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

export default EditReseauModal;
