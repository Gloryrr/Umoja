import React, { useEffect, useRef } from 'react';
import PSPDFKit from "pspdfkit";

interface PDFViewerProps {
  base64EncodedDocument: string | null;
}

const PDFViewer: React.FC<PDFViewerProps> = ({ base64EncodedDocument }) => {
  const viewerRef = useRef<HTMLDivElement | null>(null);

  useEffect(() => {
    const loadPSPDFKit = async () => {
      try {
        if (viewerRef.current) {
          console.log("Chargement de PSPDFKit...");
          await PSPDFKit.load({
            container: viewerRef.current,
            document: `data:application/pdf;base64,${base64EncodedDocument}`,
            baseUrl: `${window.location.origin}/`,
          });
          console.log("PSPDFKit chargé avec succès.");
        } else {
          console.error("Le conteneur du visualiseur est introuvable.");
        }
      } catch (error) {
        console.error("Erreur lors du chargement de PSPDFKit :", error);
      }
    };
  
    loadPSPDFKit();
  
    return () => {
      if (viewerRef.current) {
        PSPDFKit.unload(viewerRef.current);
      }
    };
  }, [base64EncodedDocument]);
  

  return (
    <div
      ref={viewerRef}
      style={{ width: "100%", height: "100vh" }}
    ></div>
  );
};

export default PDFViewer;
