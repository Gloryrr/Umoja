import React from 'react'
import Accueil from '../components/accueil';

export default function Home() {
  const projects = [
    {
      id: 1,
      title: "Tournée de Angele",
      creator: "Alex Stevens Lab",
      contributions: 512,
      endDate: "25/02/22",
      amountRaised: 15600,
      goal: 15000,
      imageUrl: "/angele.jpeg" // Replace with actual image URL
    },
    {
      id: 2,
      title: "Tournée de Damso",
      creator: "Alex Stevens Lab",
      contributions: 512,
      endDate: "28/02/24",
      amountRaised: 8000,
      goal: 15000,
      imageUrl: "/Damso.jpeg" // Replace with actual image URL
    },
  ]
  
  return (
    <Accueil projects={projects} />
  )
}