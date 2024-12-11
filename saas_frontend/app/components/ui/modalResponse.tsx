import React, { useState } from 'react';
import DatePicker from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';
import { apiPost, /*apiGet*/ } from "@/app/services/internalApiClients"; // Ensure this import is correct

interface NumberInputModalProps {
  username: string;
  isOpen: boolean;
  onClose: () => void;
  onSubmit: (startDate: Date | null, endDate: Date | null, price: number | null) => void;
}

const NumberInputModal: React.FC<NumberInputModalProps> = ({ username, isOpen, onClose, onSubmit }) => {
  const [startDate, setStartDate] = useState<Date | null>(null);
  const [endDate, setEndDate] = useState<Date | null>(null);
  const [price, setPrice] = useState<number | null>(null);

  const handleSubmit = async () => {
    if (startDate !== null && endDate !== null && price !== null) {
      const urlParams = new URLSearchParams(window.location.search);
      const idOffre = urlParams.get('id');
      console.log(username);
      const reponse = {
        username: username,
        idOffre: idOffre,
        dateDebut: startDate,
        dateFin: endDate,
        prixParticipation: price
      };
      try {
        await apiPost('/reponse/create', JSON.parse(JSON.stringify(reponse)));
        onSubmit(startDate, endDate, price);
      } catch (error) {
        console.error('Error:', error);
      } 
    }
  };

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div className="bg-gray-800 p-8 rounded-lg">
        <h1 className="text-3xl mb-4 text-white">Donner votre reponse</h1>
        <h2 className="text-2xl mb-4 text-white">Sélectionnez une date de début</h2>
        <DatePicker
          selected={startDate}
          onChange={(date) => setStartDate(date)}
          className="border p-2 rounded w-full mb-4 text-black"
          calendarClassName="text-black" // Ensure calendar text is black
        />
        <h2 className="text-2xl mb-4 text-white">Sélectionnez une date de fin</h2>
        <DatePicker
          selected={endDate}
          onChange={(date) => setEndDate(date)}
          className="border p-2 rounded w-full mb-4 text-black"
          calendarClassName="text-black" // Ensure calendar text is black
        />
        <h2 className="text-2xl mb-4 text-white">Entrez un prix</h2>
        <input
          type="number"
          value={price !== null ? price : ''}
          onChange={(e) => setPrice(Number(e.target.value))}
          className="border p-2 rounded w-full mb-4 text-black"
        />
        <button
          onClick={handleSubmit}
          className="bg-blue-500 text-white px-4 py-2 rounded mr-2"
        >
          Soumettre
        </button>
        <button
          onClick={onClose}
          className="bg-gray-500 text-white px-4 py-2 rounded"
        >
          Fermer
        </button>
      </div>
    </div>
  );
};

export default NumberInputModal;