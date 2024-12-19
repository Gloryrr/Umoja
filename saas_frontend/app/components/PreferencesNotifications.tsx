"use client";

import React, { useEffect, useState, useCallback } from 'react';
import { Card, ToggleSwitch, Button, ListGroup } from 'flowbite-react';
import { apiGet, apiPatch } from '@/app/services/internalApiClients';
import { DarkThemeToggle, Flowbite } from "flowbite-react";

const PreferencesNotifications: React.FC = () => {
  const [username, setUsername] = useState("");
  const [loading, setLoading] = useState(false);
  const [preferences, setPreferences] = useState({
    email_nouvelle_offre: false,
    email_update_offre: false,
    reponse_offre: false,
  });

  const updatePreferences = async () => {
    if (!username) return;

    try {
      const data = JSON.parse(JSON.stringify(preferences))
      const response = await apiPatch(`/utilisateur/preference-notification/update/${username}`, data);

      if (response) {
        alert('Préférences sauvegardées avec succès !');
      } else {
        alert('Erreur lors de la sauvegarde des préférences.');
      }
    } catch (error) {
      console.error("Erreur réseau :", error);
      alert('Erreur réseau lors de la sauvegarde.');
    }
  };

  const handleReset = () => {
    setPreferences({
      email_nouvelle_offre: false,
      email_update_offre: false,
      reponse_offre: false,
    });
  };

  const handleToggle = (key: keyof typeof preferences) => {
    setPreferences((prev) => ({
      ...prev,
      [key]: !prev[key],
    }));
  };

  const fetchPreferences = useCallback(async () => {
    if (!username) return;

    setLoading(true);
    try {
      const response = await apiGet(`/utilisateur/preference-notification/${username}`);
      if (response) {
        setPreferences({
          email_nouvelle_offre: JSON.parse(response.preferences)[0].email_nouvelle_offre,
          email_update_offre: JSON.parse(response.preferences)[0].email_update_offre,
          reponse_offre: JSON.parse(response.preferences)[0].reponse_offre,
        });
      } else {
        console.error("Erreur lors de la récupération des préférences");
      }
    } catch (error) {
      console.error("Erreur réseau :", error);
    } finally {
      setLoading(false);
    }
  }, [username]);

  useEffect(() => {
    fetchPreferences();
  }, [fetchPreferences]);

  useEffect(() => {
    const fetchUtilisateur = async () => {
      await apiGet("/me").then((response) => {
        setUsername(response.utilisateur);
      });
    }
    fetchUtilisateur();
  }, []);

  return (
    <div className="mx-auto mt-10 mb-10">
      <Card>
        <h2 className="text-2xl font-bold text-center mb-6">Notifications</h2>

        {loading ? (
          <span>Chargement des préférences...</span>
        ) : (
          <>
            <section>
              <div className="flex items-center justify-between pt-2 pb-2 border-b">
                <span>Nouvelle offre sur un réseau</span>
                <div className="ml-auto">
                  <ToggleSwitch
                    checked={preferences.email_nouvelle_offre}
                    label=""
                    onChange={() => handleToggle('email_nouvelle_offre')}
                  />
                </div>
              </div>

              <div className="flex items-center justify-between pt-2 pb-2 border-b">
                <span>Offre modifiée sur un réseau</span>
                <div className="ml-auto">
                  <ToggleSwitch
                    checked={preferences.email_update_offre}
                    label=""
                    onChange={() => handleToggle('email_update_offre')}
                  />
                </div>
              </div>

              <div className="flex items-center justify-between pt-2 pb-2 border-b">
                <span>Réponse à une offre que j&apos;ai postée</span>
                <div className="ml-auto">
                  <ToggleSwitch
                    checked={preferences.reponse_offre}
                    label=""
                    onChange={() => handleToggle('reponse_offre')}
                  />
                </div>
              </div>
            </section>

            <div className="flex justify-end gap-4 mt-6">
              <Button color="light" onClick={handleReset}>
                Réinitialiser
              </Button>
              <Button onClick={updatePreferences}>
                Enregistrer
              </Button>
            </div>
          </>
        )}
      </Card>

      <Card className='mt-5'>
        <h2 className="text-2xl font-bold text-center mb-6">Thème de l&apos;application</h2>

        <ListGroup>
          <div className="flex items-center justify-between p-2">
            <span>Thème</span>
            <div className="ml-auto">
              <Flowbite>
                <DarkThemeToggle />
              </Flowbite>
            </div>
          </div>
        </ListGroup>
      </Card>
    </div>
  );
};

export default PreferencesNotifications;
