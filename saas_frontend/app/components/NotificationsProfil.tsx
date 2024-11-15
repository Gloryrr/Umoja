// Components/NotificationPreferences.tsx

import React, { useState } from 'react';
import { Card, ToggleSwitch, Button, ListGroup } from 'flowbite-react';

const NotificationPreferences: React.FC = () => {
  const [preferences, setPreferences] = useState({
    newOffer: true,
    offerUpdate: true,
    offerResponse: true,
  });

  const handleToggle = (key: keyof typeof preferences) => {
    setPreferences((prev) => ({
      ...prev,
      [key]: !prev[key],
    }));
  };

  const handleSave = () => {
    alert('Préférences sauvegardées avec succès !');
  };

  const handleReset = () => {
    setPreferences({
      newOffer: false,
      offerUpdate: false,
      offerResponse: false,
    });
  };

  return (
    <div className="my-10">
      <Card>

        <ListGroup>
          <ListGroup.Item className="flex items-center justify-between">
            <span>Nouvelle offre sur un réseau</span>
            <ToggleSwitch
                className='ml-auto'
                checked={preferences.newOffer}
                label=""
                onChange={() => handleToggle('newOffer')}
            />
          </ListGroup.Item>

          <ListGroup.Item className="flex items-center justify-between">
            <span>Offre modifiée sur un réseau</span>
            <ToggleSwitch
                className='ml-auto'
                checked={preferences.offerUpdate}
                label=""
                onChange={() => handleToggle('offerUpdate')}
            />
          </ListGroup.Item>

          <ListGroup.Item className="flex items-center justify-between">
            <span>Réponse à une offre que j'ai postée</span>
            <ToggleSwitch
                className='ml-auto'
                checked={preferences.offerResponse}
                label=""
                onChange={() => handleToggle('offerResponse')}
            />
          </ListGroup.Item>
        </ListGroup>

        <div className="flex justify-end gap-4 mt-6">
          <Button color='light' onClick={handleReset}>
            Réinitialiser
          </Button>
          <Button onClick={handleSave}>
            Enregistrer
          </Button>
        </div>
      </Card>
    </div>
  );
};

export default NotificationPreferences;
