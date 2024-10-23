"use client"
import React from 'react';
import { FaUser, FaEnvelope, FaComment } from "react-icons/fa";
import NavigationHandler from './router';

interface User {
  name: string;
  email: string;
}

const user: User = {
  name: "John Doe",
  email: "john.doe@example.com"
};

export default function contact_form() {

  return (
    <div className='w-auto bg-transparent text-white rounded-lg p-8 font-nunito'>
      <h1 className='text-8xl text-center pb-12 font-fredoka'>Contactez-nous !</h1>
      <form action="">

        <div className="relative w-full h-1/2 my-8">
          <input type="text" placeholder="Nom" value={user.name} required className="w-full h-full bg-gray-700 outline-none border-solid border-2 border-white rounded-full text-lg text-white p-5 pr-12 placeholder-white" readOnly/>
          <FaUser className='absolute right-5 top-1/2 transform -translate-y-1/2 text-lg' />
        </div>

        <div className="relative w-full h-1/2 my-8">
          <input type="email" placeholder="Email" value={user.email} required className="w-full h-full bg-gray-700 outline-none border-solid border-2 border-white rounded-full text-lg text-white p-5 pr-12 placeholder-white" />
          <FaEnvelope className='absolute right-5 top-1/2 transform -translate-y-1/2 text-lg' />
        </div>

        <div className="relative w-full h-1/2 my-8">
          <textarea placeholder="Message" required className="w-full h-32 bg-transparent outline-none border-solid border-2 border-white rounded-lg text-lg text-white p-5 placeholder-white resize-none"></textarea>
          <FaComment className='absolute right-5 top-5 text-lg' />
        </div>

        <button className="w-full h-11 bg-blue-700 text-white border-none outline-none rounded-full shadow-md cursor-pointer text-lg font-bold" type="submit">Envoyer</button>

        <div className="text-sm text-center my-4">
          <p>Vous avez des questions ?  
          <NavigationHandler>
            {(handleNavigation: (path: string) => void) => (
              <a onClick={() => handleNavigation('/faq')} className="text-white no-underline font-semibold hover:underline"> Consultez notre FAQ</a>
            )}
          </NavigationHandler>
          </p>
        </div>
      </form>
    </div>
  );
}