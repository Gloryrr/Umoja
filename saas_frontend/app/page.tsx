"use client"
import React from 'react';
import ConnectionForm from "./components/Form/ConnectionForm";
// import InscriptionForm from './components/inscription_form';

export default function Home() {
  localStorage.setItem('isConnected', 'false');
  return (
    <div>
      <ConnectionForm/>
    </div>
  );
}
