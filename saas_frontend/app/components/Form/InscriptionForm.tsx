"use client"
import { useState } from 'react';
import { FaUser } from "react-icons/fa";
import NavigationHandler from '../../navigation/Router';


const InscriptionForm = () => {
  const [nom, setNom] = useState('');
  const [username, setUsername] = useState('');
  const [email, setEmail] = useState('');
  const [numero, setNumero] = useState('');
  const [password, setPassword] = useState('');
  const [repassword, setRePassword] = useState('');
  const [role, setRole] = useState('');

  const onSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();  // Empêche le rechargement de la page
    alert(`Submitted ${username} ${email}`);
  };

  return (
    <div className="w-[35vw] bg-transparent text-white rounded-lg p-8 font-nunito">
      <h1 className="text-8xl text-center pb-12 font-fredoka">Inscris-toi !</h1>
      <form onSubmit={onSubmit}>

        {/* Nom */}
        <div className="relative w-full h-12 my-8">
          <input
            value={nom}
            onChange={(e) => setNom(e.target.value)}
            placeholder="Nom"
            className="w-full h-full bg-transparent outline-none border-solid border-2 border-white rounded-full text-lg text-white p-5 pr-12 placeholder-white"
          />
        </div>

        {/* Username */}
        <div className="relative w-full h-12 my-8">
          <input
            value={username}
            onChange={(e) => setUsername(e.target.value)}
            placeholder="Username"
            className="w-full h-full bg-transparent outline-none border-solid border-2 border-white rounded-full text-lg text-white p-5 pr-12 placeholder-white"
          />
          <FaUser className='absolute right-5 top-1/2 transform -translate-y-1/2 text-lg'/>

        </div>

        {/* Email */}
        <div className="relative w-full h-12 my-8">
          <input
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            placeholder="Email"
            className="w-full h-full bg-transparent outline-none border-solid border-2 border-white rounded-full text-lg text-white p-5 pr-12 placeholder-white"
          />
        </div>

        {/* Numéro */}
        <div className="relative w-full h-12 my-8">
          <input
            value={numero}
            onChange={(e) => setNumero(e.target.value)}
            placeholder="Numéro"
            className="w-full h-full bg-transparent outline-none border-solid border-2 border-white rounded-full text-lg text-white p-5 pr-12 placeholder-white"
          />
        </div>

        {/* Mot de passe */}
        <div className="relative w-full h-12 my-8">
          <input
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            type="password"
            placeholder="Mot de passe"
            className="w-full h-full bg-transparent outline-none border-solid border-2 border-white rounded-full text-lg text-white p-5 pr-12 placeholder-white"
          />
        </div>

        {/* Confirmation de mot de passe */}
        <div className="relative w-full h-12 my-8">
          <input
            value={repassword}
            onChange={(e) => setRePassword(e.target.value)}
            type="password"
            placeholder="Confirmer mot de passe"
            className="w-full h-full bg-transparent outline-none border-solid border-2 border-white rounded-full text-lg text-white p-5 pr-12 placeholder-white"
          />
        </div>

        {/* Rôle */}
        <div className="relative w-full h-12 my-8">
          <input
            value={role}
            onChange={(e) => setRole(e.target.value)}
            placeholder="Rôle"
            className="w-full h-full bg-transparent outline-none border-solid border-2 border-white rounded-full text-lg text-white p-5 pr-12 placeholder-white"
          />
        </div>

        {/* Bouton submit */}
        <button
          type="submit"
          className="w-full h-11 bg-blue-700 text-white border-none outline-none rounded-full shadow-md cursor-pointer text-lg font-bold"
        >
          Submit
        </button>
        <div className="text-sm text-center my-4">
          <p>Tu as déjà un compte ? 
          <NavigationHandler>
          {(handleNavigation: (path: string) => void) => (
            <a onClick={() => handleNavigation('/connexion')} className="text-white no-underline font-semibold hover:underline">Connexion</a>
          )}
          </NavigationHandler>
          </p>
        </div>
      </form>
    </div>


  );
};

export default InscriptionForm;
