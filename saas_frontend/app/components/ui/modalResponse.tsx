import React, { useState } from 'react';
// import DatePicker from 'react-datepicker';
import { Button, Label, Modal, TextInput, Datepicker } from 'flowbite-react';
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
    <Modal show={isOpen} onClose={onClose} size="lg" position="center">
      <Modal.Header>
        <span className="text-xl font-semibold text-gray-900 dark:text-white">
          Contribuer dès maintenant
        </span>
      </Modal.Header>
      <Modal.Body>
        <div className="space-y-6">
          {/* Date de début */}
          <div className='flex flex-col'>
            <Label htmlFor="startDate" value="Sélectionnez une date de début" />
            <Datepicker
              id="startDate"
              //onSelect={(date) => setStartDate(date)}
              //selected={startDate}
              onChange={(date) => setStartDate(date)}
              className="mt-2"
              // calendarClassName="text-black" // Texte noir pour le calendrier
            />
          </div>

          {/* Date de fin */}
          <div className='flex flex-col'>
            <Label htmlFor="endDate" value="Sélectionnez une date de fin" />
            <Datepicker
              id="endDate"
              //onSelect={startDate}
              //selected={endDate}
              onChange={(date) => setEndDate(date)}
              className="mt-2"
              // calendarClassName="text-black" // Texte noir pour le calendrier
            />
          </div>

          {/* Prix */}
          <div>
            <Label htmlFor="price" value="Entrez un prix" />
            <TextInput
              id="price"
              type="number"
              value={price !== null ? price : ""}
              onChange={(e) => {
                const value = Number(e.target.value);
                if (value >= 0) {
                  setPrice(value);
                }
              }}
              className="mt-2"
            />
          </div>
        </div>
      </Modal.Body>
      <Modal.Footer>
        {/* Boutons */}
        <Button color="blue" onClick={handleSubmit}>
          Soumettre
        </Button>
        <Button color="gray" onClick={onClose}>
          Fermer
        </Button>
      </Modal.Footer>
    </Modal>
  );
};

export default NumberInputModal;