"use client";

import React, { useState } from 'react';
import { FaUser, FaLock } from "react-icons/fa";
import { TextInput, Button, Toast } from 'flowbite-react';
import { apiPost } from '@/app/services/internalApiClients';
import { HiCheck, HiX } from 'react-icons/hi';

export function connection_form() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [toastMessage, setToastMessage] = useState('');
  const [showToast, setShowToast] = useState(false);
  const [toastType, setToastType] = useState<'success' | 'failure'>('success');

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    const data = {
      "username": username,
      "mdpUtilisateur": password
    };

    const response = await apiPost('/login', JSON.parse(JSON.stringify(data)));
    console.log(response);

    if (response.token) {
      localStorage.setItem('isConnected', 'true');
      localStorage.setItem('username', data.username);
      localStorage.setItem('token', response.token);
      setToastMessage('Connexion réussie ! Redirection en cours...');
      setToastType('success');
      setShowToast(true);
      setTimeout(() => window.location.href = '/accueil', 1000);
    } else {
      localStorage.setItem('isConnected', 'false');
      setToastMessage('Compte introuvable, veuillez vérifier vos identifiants.');
      setToastType('failure');
      setShowToast(true);
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center">
      <div className='w-[35vw] rounded-lg p-8 font-nunito'>
        <h1 className='text-4xl text-center pb-6 font-fredoka'>Connecte toi !</h1>
        <form action="">
          <div className="relative w-full h-1/2">
            <TextInput
              type="text"
              placeholder="Nom d'utilisateur"
              required
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              className="w-full h-full outline-none border-solid border-2 border-none text-lg p-5 pr-12 placeholder-white"
            />
            <FaUser className='absolute right-5 top-1/2 transform -translate-y-1/2 text-lg' />
          </div>

          <div className="relative w-full h-1/2">
            <TextInput
              type="password"
              placeholder="Mot De Passe"
              required
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              className="w-full h-full outline-none border-solid border-2 border-none text-lg p-5 pr-12 placeholder-white"
            />
            <FaLock className='absolute right-5 top-1/2 transform -translate-y-1/2 text-lg' />
          </div>

          <div className="flex justify-between text-sm my-4">
            <label className="flex items-center">
              <TextInput
                type="checkbox"
                className="accent-white mr-1" />Se rappeler de moi
            </label>
            <a href="#" className="no-underline hover:underline">Mot de passe oublié ?</a>
          </div>

          <Button
            className="w-full h-11 border-none outline-none rounded-full shadow-md cursor-pointer text-lg font-bold"
            type="submit"
            onClick={handleSubmit}
          >
            Se connecter
          </Button>

          {showToast && (
            <Toast className="mt-4 w-full ml-auto mr-auto">
              <div className={`inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg ${toastType === 'success' ? 'bg-green-100 text-green-500 dark:bg-green-800 dark:text-green-200' : 'bg-red-100 text-red-500 dark:bg-red-800 dark:text-red-200'}`}>
                {toastType === 'success' ? (
                  <HiCheck className="h-5 w-5" />
                ) : (
                  <HiX className="h-5 w-5" />
                )}
              </div>
              <div className="ml-3 text-sm">{toastMessage}</div>
              <Toast.Toggle onClick={() => setShowToast(false)} />
            </Toast>
          )}
        </form>
      </div>
    </div>
  );
}

export default connection_form;
