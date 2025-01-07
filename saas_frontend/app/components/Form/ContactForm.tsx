"use client";
import React, {useState} from 'react';
import { Button, Label, Textarea, Card } from 'flowbite-react';
import { apiPost } from '@/app/services/internalApiClients';

export default function ContactForm() {
  const [message, setMessage] = useState<string>("");



  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();

    const data = {
      'message' : message
    };
    
    await apiPost('/envoi-message-to-umodja', JSON.parse(JSON.stringify(data))).then(
      (rep) => {
        console.log(rep);
      }
    );
  };

  return (
      <Card className='mt-20 mb-20 '>
        <div className='mb-6'>
          <h1 className="text-center text-2xl font-bold mb-2">Contactez-nous</h1>
          <p className='ml-[10%] mr-[10%] italic'>Indiquez nous votre problème ou simple message de que vous voulez nous communiquer...</p>
        </div>
        <form onSubmit={handleSubmit}>
          <div className="mb-4">
            <Label 
              className='font-semibold' 
              htmlFor="message" 
              value="Message"
            />
            <Textarea
              className='mt-2'
              name="Message"
              placeholder="Bonjour..."
              rows={4}
              required
              onChange={(e) => setMessage(e.target.value)}
            />
          </div>
          <Button type="submit" className="w-full">Envoyer</Button>
        </form>
      </Card>
  );
}
