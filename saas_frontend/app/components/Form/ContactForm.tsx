"use client"
import React from 'react';
import { FaUser, FaEnvelope, FaComment } from "react-icons/fa";
import NavigationHandler from '../../navigation/Router';

interface User {
  name: string;
  email: string;
}

const user: User = {
  name: "John Doe",
  email: "john.doe@example.com"
};

export default function ContactForm() {

const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    const nom = (e.target as HTMLFormElement).elements.namedItem('Nom') as HTMLInputElement;
    const email = (e.target as HTMLFormElement).elements.namedItem('Email') as HTMLInputElement;
    const message = (e.target as HTMLFormElement).elements.namedItem('Message') as HTMLTextAreaElement;

    console.log('Nom:', nom.value);
    console.log('Email:', email.value);
    console.log('Message:', message.value);
    console.log('Nom:', nom.value);

  };
  
  return (
    <div className='w-auto bg-transparent text-white rounded-lg p-8 font-nunito'>
      
      <h1 className=' text-center pb-12 font-fredoka text-2xl md:text-8xl '>Contactez-nous !</h1>
      <form onSubmit={handleSubmit}>

        <div className="relative w-full h-1/6 my-8">
          <input type="text" name='Nom' placeholder="Nom" defaultValue={user.name} required className="w-full h-full bg-gray-700 cursor-not-allowed outline-none border-solid border-2 border-white rounded-full text-lg text-white p-5 pr-12 placeholder-white" readOnly/>
          <FaUser className='absolute right-5 top-1/2 transform -translate-y-1/2 text-lg' />
        </div>

        <div className="relative w-full h-1/2 my-8">
          <input type="email" name='Email' placeholder="Email" defaultValue={user.email} required className="w-full h-full bg-gray-700 cursor-not-allowed outline-none border-solid border-2 border-white rounded-full text-lg text-white p-5 pr-12 placeholder-white" readOnly />
          <FaEnvelope className='absolute right-5 top-1/2 transform -translate-y-1/2 text-lg' />
        </div>

        <div className="relative w-full h-1/2 my-8">
          <textarea placeholder="Message" name='Message' required className="w-full h-32 bg-transparent outline-none cursor-pointer border-solid border-2 border-white rounded-lg text-lg text-white p-5 placeholder-white resize-none"></textarea>
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