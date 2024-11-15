"use client";

import { useParams } from "next/navigation";
import OffreDetail from "@/app/components/OffreDetail";

export default function DetailPage() {
  const { id } = useParams();

  console.log("on est la", id);

  if (!id) {
    return <p>Erreur : ID de l'offre manquant.</p>;
  }

  return <OffreDetail offreId={id} />;
}
