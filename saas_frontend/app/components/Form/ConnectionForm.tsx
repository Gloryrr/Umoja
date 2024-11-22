"use client"
import React, { useState } from 'react';
import NavigationHandler from '../../navigation/Router';
import { Button, Checkbox, Label, TextInput } from "flowbite-react";
import { apiPost } from '@/app/services/internalApiClients';

export default function ConnectionForm() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [rememberMe, setRememberMe] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    const data = {
      "username" : username,
      "mdpUtilisateur" : password
    }

    const response = await apiPost('/login', JSON.parse(JSON.stringify(data)));
    console.log(data);

    // console.log(response);

    if (response != null) {
      localStorage.setItem('isConnected', 'true');
      localStorage.setItem('username', data.username);
      window.location.href = 'umodja/home';
    } else {
      localStorage.setItem('isConnected', 'false');
    }
  };

  return (
    <div className="mt-20 flex items-center justify-center">
      <div className="w-[35vw] rounded-lg p-8">
        {/* <h1 className="text-3xl font-semibold text-center pb-20">UmoDJA</h1> */}
        <form onSubmit={handleSubmit} className="flex max-w-md flex-col gap-4">
          <div>
            <div className="mb-2 block">
              <Label htmlFor="username" value="Votre nom d'utilisateur" className="font-semibold" />
            </div>
            <TextInput
              id="username"
              type="text"
              placeholder="username..."
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              required
            />
          </div>
          <div>
            <div className="mb-2 block">
              <Label className="font-semibold" htmlFor="password" value="Votre mot de passe" />
            </div>
            <TextInput
              id="password"
              type="password"
              placeholder="mot de passe..."
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
          </div>
          <div className="flex items-center gap-2">
            <Checkbox
              id="remember"
              checked={rememberMe}
              onChange={(e) => setRememberMe(e.target.checked)}
            />
            <Label className="font-semibold" htmlFor="remember">Se souvenir de moi</Label>
          </div>
          <Button className="font-semibold" type="submit">
            Se connecter
          </Button>

          <div className="text-sm text-center my-4">
            <p>
              Tu n&apos;as pas encore de compte ?{' '}
              <NavigationHandler>
                {(handleNavigation: (path: string) => void) => (
                  <a onClick={() => handleNavigation('/inscription')} className="no-underline font-semibold hover:underline">
                    Inscription
                  </a>
                )}
              </NavigationHandler>
            </p>
          </div>
        </form>
      </div>
      {/* <div className="relative w-full h-1/2 my-8">
      <input type="text" placeholder="Nom d'utilisateur" required className="w-full h-full bg-transparent outline-none border-solid  border-2 border-white rounded-full text-lg text-white p-5 pr-12 placeholder-white" />
        <FaUser className='absolute right-5 top-1/2 transform -translate-y-1/2 text-lg' />
      </div>

      <div className="relative w-full h-1/2 my-8">
        <input type="password" placeholder="Mot De Passe" required className="w-full h-full bg-transparent  outline-none border-solid border-2 border-white rounded-full text-lg text-white p-5 pr-12 placeholder-white" />
        <FaLock className='absolute right-5 top-1/2 transform -translate-y-1/2 text-lg' />
      </div>

      <div className="flex justify-between text-sm my-4">
        <label className="flex items-center"><input type="checkbox" className="accent-white mr-1" />Se rappeler de moi</label>
        <a href="#" className="text-white no-underline hover:underline">Mot de passe oublié ?</a>
      </div>

      <button className="w-full h-11 bg-blue-700 text-white border-none outline-none rounded-full shadow-md cursor-pointer text-lg font-bold" type="submit">Se connecter</button> */}
    </div>
  );
}
