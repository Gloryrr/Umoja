"use client";

import { useParams } from "next/navigation";
import ValidationsOffres from "@/app/components/ValidationsOffres";

export default function DetailPage() {
  const { id } = useParams();

  if (!id) {
    return <p>Erreur : ID de l&apos;offre manquant.</p>;
  }

  return (
    <div className="w-full">
      <ValidationsOffres idOffre={Array.isArray(id) ? parseInt(id[0], 10) : parseInt(id, 10)} />;
    </div>
  );

}
