"use client"
import React from 'react';
import { FaUser, FaLock } from "react-icons/fa";
import NavigationHandler from './router';

export default function connection_form() {

  return (
    <div className='w-[35vw] bg-transparent text-white rounded-lg p-8 font-nunito'>
      <h1 className='text-8xl text-center pb-12 font-fredoka'>Connecte toi !</h1>
      <form action="">

        <div className="relative w-full h-1/2 my-8">
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

        <button className="w-full h-11 bg-blue-700 text-white border-none outline-none rounded-full shadow-md cursor-pointer text-lg font-bold" type="submit">Se connecter</button>

        <div className="text-sm text-center my-4">
          <p>Tu n&aposas pas encore de compte ? 
          <NavigationHandler>
            {(handleNavigation: (path: string) => void) => (
              <a onClick={() => handleNavigation('/inscription')} className="text-white no-underline font-semibold hover:underline">Inscription</a>
            )}
          </NavigationHandler>
          </p>
        </div>
      </form>
    </div>
  );
}