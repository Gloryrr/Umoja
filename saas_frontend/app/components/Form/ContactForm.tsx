"use client";
import React, { useState } from "react";
import { Button, Label, Textarea, Card, Spinner, Toast } from "flowbite-react";
import { HiCheck } from "react-icons/hi"; // Icone pour la popup
import { apiPost } from "@/app/services/internalApiClients";

export default function ContactForm() {
  const [message, setMessage] = useState<string>("");
  const [loading, setLoading] = useState<boolean>(false);
  const [showSuccess, setShowSuccess] = useState<boolean>(false);
  const [showError, setShowError] = useState<boolean>(false);
  const [messageRetourAction, setMessageRetourAction] = useState<string>("");
  const [etatRetourActionIsOk, setEtatRetourActionIsOk] = useState<boolean | null>(null);

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    setLoading(true);
    e.preventDefault();

    const data = {
      message: message,
    };

    await apiPost("/envoi-message-to-umoja", JSON.parse(JSON.stringify(data)))
      .then(() => {
        setShowSuccess(true);
        setMessageRetourAction("Message envoyé avec succès !");
        setEtatRetourActionIsOk(true);
      })
      .catch(() => {
        setShowError(true);
        setMessageRetourAction("Erreur lors de l'envoi du message");
        setEtatRetourActionIsOk(false);
      })
      .finally(() => {
        setLoading(false);
        setMessage("");
        setTimeout(() => setShowSuccess(false), 3000);
        setTimeout(() => setShowError(false), 3000);
      });
  };

  return (
    <div>
      {/* Affichage de la popup */}
      {showSuccess && (
        <div className="fixed top-4 right-4 z-50">
          <Toast>
            <HiCheck className="h-5 w-5 text-green-500" />
            <div className="ml-3 text-sm font-normal">
              Message envoyé avec succès !
            </div>

            {/* Barre de vie */}
            <div className="absolute bottom-0 left-0 h-1 w-full bg-green-200">
              <div
                className="h-full bg-green-500 transition-all duration-3000"
                style={{
                  animation: "shrink 3s linear forwards",
                }}
              ></div>
            </div>
          </Toast>

          <style jsx>{`
            @keyframes shrink {
              from {
                width: 100%;
              }
              to {
                width: 0%;
              }
            }
          `}</style>
        </div>
      )}

      {showError && (
        <div className="fixed top-4 right-4 z-50">
          <Toast>
            <HiCheck className="h-5 w-5 text-red-500" />
            <div className="ml-3 text-sm font-normal">
              Erreur lors de l&apos;envoi du message
            </div>

            {/* Barre de vie */}
            <div className="absolute bottom-0 left-0 h-1 w-full bg-red-200">
              <div
                className="h-full bg-red-500 transition-all duration-3000"
                style={{
                  animation: "shrink 3s linear forwards",
                }}
              ></div>
            </div>
          </Toast>

          <style jsx>{`
            @keyframes shrink {
              from {
                width: 100%;
              }
              to {
                width: 0%;
              }
            }
          `}</style>
        </div>
      )}

      <Card className="mt-20 mb-20">
        <div className="mb-6">
          <h1 className="text-center text-2xl font-bold mb-2">Contactez-nous</h1>
          <p className="ml-[10%] mr-[10%] italic">
            Indiquez nous votre problème ou simple message que vous voulez nous communiquer...
          </p>
        </div>
        <form onSubmit={handleSubmit}>
          <div className="mb-4">
            <Label className="font-semibold" htmlFor="message" value="Message" />
            <Textarea
              className="mt-2"
              name="Message"
              placeholder="Bonjour..."
              rows={4}
              required
              value={message}
              onChange={(e) => setMessage(e.target.value)}
            />
            {etatRetourActionIsOk == false && (
              <div className="text-red-500 text-sm mt-2">
                <span>{messageRetourAction}</span>
              </div>
            )}
            {etatRetourActionIsOk == true && (
              <div className="text-green-500 text-sm mt-2">
                <span>{messageRetourAction}</span>
              </div>
            )}
          </div>
          <div className="flex ml-auto">
            <Button className="mt-2" type="submit" disabled={loading}>
              {loading ? (
                <div>
                  <span>Envoi en cours...</span>
                  <Spinner size="sm" className="ml-2" />
                </div>
              ) : (
                <span>Envoyer</span>
              )}
            </Button>
          </div>
        </form>
      </Card>
    </div>
  );
}
