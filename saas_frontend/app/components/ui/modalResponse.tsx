import React, { useState, useEffect } from 'react';
// import DatePicker from 'react-datepicker';
import { Button, Label, Modal, TextInput, Datepicker, Textarea, Select, FileInput } from 'flowbite-react';
import 'react-datepicker/dist/react-datepicker.css';
import { apiPost, /*apiGet*/ } from "@/app/services/internalApiClients";
import { apiGet } from "@/app/services/externalApiClients";
import { apiPostSFTP } from "@/app/services/internalApiClients";

interface NumberInputModalProps {
  username: string;
  isOpen: boolean;
  onClose: () => void;
  onSubmit: () => void;
}

interface DatesPossible {
  dateDebut: Date;
  dateFin: Date;
}

const NumberInputModal: React.FC<NumberInputModalProps> = ({ username, isOpen, onClose, onSubmit }) => {
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
  const [datesPossible, setDatesPossible] = useState<Array<DatesPossible>>([]);
  const [capacite, setCapacite] = useState<number | null>(null);
  const [deadline, setDeadline] = useState<Date | null>(null);
  const [dureeShow, setDureeShow] = useState<string | null>(null);
  const [montantCachet, setMontantCachet] = useState<number | null>(null);
  const [deviseCachet, setDeviseCachet] = useState<string | null>(null);
  const [extras, setExtras] = useState<string | null>(null);
  const [coutsExtras, setCoutsExtras] = useState<number | null>(null);
  const [ordrePassage, setOrdrePassage] = useState<string | null>(null);
  const [conditionsGenerales, setConditionsGenerales] = useState<string | null>(null);
  const [conditionsPaiement, setConditionsPaiement] = useState<string[]>([]);
  const [file, setFile] = useState<File | null>(null);

  const handleFileChange = async (e: React.ChangeEvent<HTMLInputElement>) => {
    setFile(e.target.files?.[0] || null);
  };


  // Fonction pour ajouter un nouveau champ de date
  const handleAddDates = () => {
    setDatesPossible((prev) => [...prev, { dateDebut: new Date(), dateFin: new Date() }]);
  };

  // Fonction pour mettre à jour une date dans l'état
  const handleDateChange = (
    index: number,
    key: "dateDebut" | "dateFin",
    date: Date
  ) => {
    const updatedDates = [...datesPossible];
    updatedDates[index][key] = date;
    setDatesPossible(updatedDates);
  };

  const handleSubmit = async () => {
    if (datesPossible.length != 0 && price !== null) {
      const urlParams = new URLSearchParams(window.location.search);
      const idOffre = urlParams.get('id');
      const reponse = {
        username: username,
        idOffre: idOffre,
        prixParticipation: price,
        nomSalleFestival: nomSalleFestival,
        nomSalleConcert: nomSalleConcert,  
        ville: ville,
        datesPossible: datesPossible,
        capacite: capacite,
        deadline: deadline,
        dureeShow: dureeShow,
        montantCachet: montantCachet,
        deviseCachet: deviseCachet,
        extras: extras,
        coutsExtras: coutsExtras,
        ordrePassage: ordrePassage,
        conditionsGenerales: conditionsGenerales,
      };

      if (file && idOffre) {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('idProjet', idOffre.toString());
        formData.append('typeFichier', "proposition_contribution");

        try {
          await apiPostSFTP('/upload-sftp-fichier', formData);
          // setColorMessage('text-green-500');
          // setMessage('Le fichier a été transféré avec succès');
        } catch (error) {
          console.error('Erreur lors du transfert du fichier :', error);
          // setColorMessage('text-red-500');
          // setMessage('Erreur lors du transfert du fichier, veuillez réessayer');
        }
      }

      try {
        await apiPost('/reponse/create', JSON.parse(JSON.stringify(reponse))).then(async () => {
          onSubmit();
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

  useEffect(() => {
    const fetchMonnaieExistantes = async () => {
        try {
            const data: { currencies: Record<string, unknown> }[] = await apiGet("https://restcountries.com/v3.1/all");
            const monnaieList = Array.from(
                new Set(data.flatMap((country) => Object.keys(country.currencies || {})))
            );
            setConditionsPaiement(monnaieList);
        } catch (error) {
            console.error("Erreur lors de la récupération des monnaies existantes :", error);
        }
    };

    fetchMonnaieExistantes();
  }, []);

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
          {/* Bouton pour ajouter des dates */}
          <Button
            onClick={handleAddDates}
          >
            Ajouter des dates
          </Button>

          {/* Liste des champs dynamiques */}
          <div className="mt-4 space-y-4">
            {datesPossible.map((date, index) => (
              <div key={index} className="grid grid-cols-1 md:grid-cols-2 gap-4">
                {/* Date de début */}
                <div className="flex flex-col">
                  <Label htmlFor={`startDate-${index}`} value="Sélectionnez une date de début" />
                  <Datepicker
                    id={`startDate-${index}`}
                    value={date.dateDebut}
                    onChange={(selectedDate) =>
                      selectedDate && handleDateChange(index, "dateDebut", selectedDate)
                    }
                    className="mt-2"
                  />
                </div>

                {/* Date de fin */}
                <div className="flex flex-col">
                  <Label htmlFor={`endDate-${index}`} value="Sélectionnez une date de fin" />
                  <Datepicker
                    id={`endDate-${index}`}
                    value={date.dateFin}
                    onChange={(selectedDate) =>
                      selectedDate && handleDateChange(index, "dateFin", selectedDate)
                    }
                    className="mt-2"
                  />
                </div>

                <Button
                  color="failure"
                  onClick={() => {
                    const updatedDates = [...datesPossible];
                    updatedDates.splice(index, 1);
                    setDatesPossible(updatedDates);
                  }}
                >
                  Supprimer la ligne
                </Button>
              </div>
            ))}
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
            <Datepicker
              id="deadline"
              type="text"
              value={deadline !== null ? deadline : new Date()}
              onChange={(e) => {
                const value = e;
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
            <Label htmlFor="conditionsPaiement" value="Devise du cachet:" />
            <Select
              id="deviseCachet"
              value={deviseCachet ?? ""}
              onChange={(e) => {
                const value = e.target.value;
                setDeviseCachet(value);
              }}
              required
              className="mt-1"
            >
              <option value="">Sélectionnez une monnaie</option>
              {conditionsPaiement.map((monnaie, index) => (
                  <option key={index} value={monnaie}>
                      {monnaie}
                  </option>
              ))}
            </Select>
          </div>

          {/* Extra */}
          <div>
            <Label htmlFor="extras" value="Extra" />
            <Textarea
              id="extras"
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
            <Label 
              htmlFor="file" 
              value="Ajouter un fichier joint à la proposition de contribution" 
            />
            <FileInput
              className="mt-2"
              accept="application/pdf"
              onChange={handleFileChange}
            />
          </div>
        </div>
      </Modal.Body>
      <Modal.Footer>
        {/* Boutons */}
        <Button onClick={handleSubmit}>
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