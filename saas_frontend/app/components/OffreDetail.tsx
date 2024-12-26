import React from 'react';

interface OfferDetailsProps {
  title: string;
  description: string;
  type: string;
  status: string;
  startDate: string;
  endDate: string;
  deadline: string;
  extras: string[];
  contact: {
    email: string;
    phone: string;
  };
}

const DetailOffer: React.FC<OfferDetailsProps> = ({
  title,
  description,
  type,
  status,
  startDate,
  endDate,
  deadline,
  extras,
  contact,
}) => {
  return (
    <div className="p-6 bg-white shadow-md rounded-md">
      <h2 className="text-xl font-bold mb-4">{title}</h2>
      <p className="mb-4 text-gray-600">{description}</p>
      <div className="border-t pt-4">
        <h3 className="font-semibold text-lg">Détails de l'offre</h3>
        <ul className="list-disc pl-5 mt-2 text-gray-800">
          <li><strong>Type :</strong> {type}</li>
          <li><strong>État :</strong> {status}</li>
          <li><strong>Date de début :</strong> {startDate}</li>
          <li><strong>Date de fin :</strong> {endDate}</li>
          <li><strong>Date limite :</strong> {deadline}</li>
        </ul>
      </div>
      {extras.length > 0 && (
        <div className="border-t pt-4">
          <h3 className="font-semibold text-lg">Extras inclus</h3>
          <ul className="list-disc pl-5 mt-2 text-gray-800">
            {extras.map((extra, index) => (
              <li key={index}>{extra}</li>
            ))}
          </ul>
        </div>
      )}
      <div className="border-t pt-4">
        <h3 className="font-semibold text-lg">Contact</h3>
        <p className="mt-2 text-gray-800">
          <strong>Email :</strong> {contact.email} <br />
          <strong>Téléphone :</strong> {contact.phone}
        </p>
      </div>
    </div>
  );
};

export default DetailOffer;
