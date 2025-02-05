"use client";

import { useParams } from "next/navigation";
import OffreDetail from "../../../../app/components/OffreDetail";

export default function DetailPage() {
  const { id } = useParams();

  if (!id) {
    return <p>Erreur : ID de l&apos;offre manquant.</p>;
  }

  return (
    <div className="w-full">
      <OffreDetail offreId={Array.isArray(id) ? parseInt(id[0], 10) : parseInt(id, 10)} />;
    </div>
  );

}
