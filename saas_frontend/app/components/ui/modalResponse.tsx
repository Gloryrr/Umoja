import React, { useState } from 'react';
// import DatePicker from 'react-datepicker';
import { Button, Label, Modal, TextInput, Datepicker, Textarea } from 'flowbite-react';
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

// - Nom Salle ou Festival
// - Nom Salle de concert ou de la scène
// - Ville
// - Date(s) possible(s)
// - Capacité
// - Deadline
// - Durée du show
// - Montant du cachet
// - Devise du cachet
// - Extra : (ici on indique ce que le festival/salle offre aussi... exemple : hotels, transports, etc.) - champ libre text
// - Estimation des couts pour les extras (montant)
// - Ordre de passage  - champ libre text
// - Conditions générales de l’offre : - champ libre text
// - Possibilité d’ajouter un fichier joint à l’offre
  const [nomSalleFestival, setNomSalleFestival] = useState<string | null>(null);
  const [nomSalleConcert, setNomSalleConcert] = useState<string | null>(null);
  const [ville, setVille] = useState<string | null>(null);
  const [datePossible, setDatePossible] = useState<string | null>(null);
  const [capacite, setCapacite] = useState<number | null>(null);
  const [deadline, setDeadline] = useState<string | null>(null);
  const [dureeShow, setDureeShow] = useState<string | null>(null);
  const [montantCachet, setMontantCachet] = useState<number | null>(null);
  const [deviseCachet, setDeviseCachet] = useState<string | null>(null);
  const [extras, setExtras] = useState<string | null>(null);
  const [coutsExtras, setCoutsExtras] = useState<number | null>(null);
  const [ordrePassage, setOrdrePassage] = useState<string | null>(null);
  const [conditionsGenerales, setConditionsGenerales] = useState<string | null>(null);
  const [fichierJoint, setFichierJoint] = useState<string | null>(null);

  const handleSubmit = async () => {
    if (startDate !== null && endDate !== null && price !== null) {
      const urlParams = new URLSearchParams(window.location.search);
      const idOffre = urlParams.get('id');
      const reponse = {
        username: username,
        idOffre: idOffre,
        dateDebut: startDate,
        dateFin: endDate,
        prixParticipation: price
        // nomSalleFestival: nomSalleFestival,
        // nomSalleConcert: nomSalleConcert,
        // ville: ville,
        // datePossible: datePossible,
        // capacite: capacite,
        // deadline: deadline,
        // dureeShow: dureeShow,
        // montantCachet: montantCachet,
        // deviseCachet: deviseCachet,
        // extras: extras,
        // coutsExtras: coutsExtras,
        // ordrePassage: ordrePassage,
        // conditionsGenerales: conditionsGenerales,
        // fichierJoint: fichierJoint,
      };
      try {
        await apiPost('/reponse/create', JSON.parse(JSON.stringify(reponse))).then(async () => {
          onSubmit(startDate, endDate, price);
          const data = {
            'idOffre' : idOffre,
            'username' : username,
            'prixParticipation' : price,
          };
          await apiPost('/envoi-email-new-contribution', JSON.parse(JSON.stringify(data)));
        });
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
              placeholder='Prix en €'
            />
          </div>

          {/* Nom Salle ou Festival */}
          <div>
            <Label htmlFor="nomSalleFestival" value="Nom Salle ou Festival" />
            <TextInput
              id="nomSalleFestival"
              type="text"
              value={nomSalleFestival !== null ? nomSalleFestival : ""}
              onChange={(e) => {
                const value = e.target.value;
                setNomSalleFestival(value);
              }}
              className="mt-2"
              placeholder='Paris la Défense Arena'
            />
          </div>

          {/* Nom Salle de concert ou de la scène */}
          <div>
            <Label htmlFor="nomSalleConcert" value="Nom Salle de concert ou de la scène" />
            <TextInput
              id="nomSalleConcert"
              type="text"
              value={nomSalleConcert !== null ? nomSalleConcert : ""}
              onChange={(e) => {
                const value = e.target.value;
                setNomSalleConcert(value);
              }}
              className="mt-2"
              placeholder='Scène de la Grande Halle de la Villette'
            />
          </div>

          {/* Ville */}
          <div>
            <Label htmlFor="ville" value="Ville" />
            <TextInput
              id="ville"
              type="text"
              value={ville !== null ? ville : ""}
              onChange={(e) => {
                const value = e.target.value;
                setVille(value);
              }}
              className="mt-2"
              placeholder='Paris'
            />
          </div>

          {/* Date(s) possible(s) */}
          <div>
            <Label htmlFor="datePossible" value="Date(s) possible(s)" />
            <TextInput
              id="datePossible"
              type="text"
              value={datePossible !== null ? datePossible : ""}
              onChange={(e) => {
                const value = e.target.value;
                setDatePossible(value);
              }}
              className="mt-2"
              placeholder='15/07/2022'
            />
          </div>

          {/* Capacité */}
          <div>
            <Label htmlFor="capacite" value="Capacité" />
            <TextInput
              id="capacite"
              type="number"
              value={capacite !== null ? capacite : ""}
              onChange={(e) => {
                const value = Number(e.target.value);
                if (value >= 0) {
                  setCapacite(value);
                }
              }}
              className="mt-2"
              placeholder='1000'
            />
          </div>

          {/* Deadline */}
          <div>
            <Label htmlFor="deadline" value="Deadline" />
            <TextInput
              id="deadline"
              type="text"
              value={deadline !== null ? deadline : ""}
              onChange={(e) => {
                const value = e.target.value;
                setDeadline(value);
              }}
              className="mt-2"
              placeholder='20/06/2022'
            />
          </div>

          {/* Durée du show */}
          <div>
            <Label htmlFor="dureeShow" value="Durée du show" />
            <TextInput
              id="dureeShow"
              type="text"
              value={dureeShow !== null ? dureeShow : ""}
              onChange={(e) => {
                const value = e.target.value;
                setDureeShow(value);
              }}
              className="mt-2"
              placeholder='2h'
            />
          </div>

          {/* Montant du cachet */}
          <div>
            <Label htmlFor="montantCachet" value="Montant du cachet" />
            <TextInput
              id="montantCachet"
              type="number"
              value={montantCachet !== null ? montantCachet : ""}
              onChange={(e) => {
                const value = Number(e.target.value);
                if (value >= 0) {
                  setMontantCachet(value);
                }
              }}
              className="mt-2"
              placeholder='1000'
            />
          </div>

          {/* Devise du cachet */}
          <div>
            <Label htmlFor="deviseCachet" value="Devise du cachet" />
            <TextInput
              id="deviseCachet"
              type="text"
              value={deviseCachet !== null ? deviseCachet : ""}
              onChange={(e) => {
                const value = e.target.value;
                setDeviseCachet(value);
              }}
              className="mt-2"
              placeholder='€'
            />
          </div>

          {/* Extra */}
          <div>
            <Label htmlFor="extras" value="Extra" />
            <TextInput
              id="extras"
              type="text"
              value={extras !== null ? extras : ""}
              onChange={(e) => {
                const value = e.target.value;
                setExtras(value);
              }}
              className="mt-2"
              placeholder='Hôtels, transports, etc.'
            />
          </div>

          {/* Estimation des couts pour les extras */}
          <div>
            <Label htmlFor="coutsExtras" value="Estimation des couts pour les extras" />
            <TextInput
              id="coutsExtras"
              type="number"
              value={coutsExtras !== null ? coutsExtras : ""}
              onChange={(e) => {
                const value = Number(e.target.value);
                if (value >= 0) {
                  setCoutsExtras(value);
                }
              }}
              className="mt-2"
              placeholder='500'
            />
          </div>

          {/* Ordre de passage */}
          <div>
            <Label htmlFor="ordrePassage" value="Ordre de passage" />
            <TextInput
              id="ordrePassage"
              type="text"
              value={ordrePassage !== null ? ordrePassage : ""}
              onChange={(e) => {
                const value = e.target.value;
                setOrdrePassage(value);
              }}
              className="mt-2"
              placeholder='artiste 1 - artiste 2 - artiste 3'
            />
          </div>

          {/* Conditions générales de l’offre */}
          <div>
            <Label htmlFor="conditionsGenerales" value="Conditions générales de l’offre" />
            <Textarea
              id="conditionsGenerales"
              value={conditionsGenerales !== null ? conditionsGenerales : ""}
              onChange={(e) => {
                const value = e.target.value;
                setConditionsGenerales(value);
              }}
              className="mt-2"
              placeholder="Conditions générales de l'offre"
            />
          </div>

          {/* Possibilité d’ajouter un fichier joint à l’offre */}
          <div>
            <Label htmlFor="fichierJoint" value="Possibilité d’ajouter un fichier joint à l’offre" />
            <TextInput
              id="fichierJoint"
              type="text"
              value={fichierJoint !== null ? fichierJoint : ""}
              onChange={(e) => {
                const value = e.target.value;
                setFichierJoint(value);
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