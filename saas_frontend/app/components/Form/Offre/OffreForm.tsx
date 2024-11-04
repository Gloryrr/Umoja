"use client";
import React, { useState } from 'react';
import ExtrasForm from '@/app/components/Form/Offre/ExtrasForm';
import ConditionsFinancieresForm from '@/app/components/Form/Offre/ConditionFinancieresForm';

const OffreForm: React.FC = () => {

    const [formData, setFormData] = useState({
        titleOffre: '',
        deadLine: '',
        descrTournee: '',
        dateMinProposee: '',
        dateMaxProposee: '',
        villeVisee: '',
        regionVisee: '',
        placesMin: '',
        placesMax: '',
        nbArtistesConcernes: '',
        nbInvitesConcernes: '',
        liensPromotionnels: '',
        extras: {
            descrExtras: '',
            coutExtras: '',
            exclusivite: '',
            exception: '',
            ordrePassage: '',
            clausesConfidentialites: ''
        },
        etatOffre: '',
        typeOffre: '',
        conditionsFinancieres: {
            minimumGaranti: '',
            conditionsPaiement: '',
            pourcentageRecette: ''
        },
        budgetEstimatif: {
            cachetArtiste: '',
            fraisDeplacement: '',
            fraisHebergement: '',
            fraisRestauration: ''
        },
        ficheTechniqueArtiste: {
            besoinBackline: '',
            besoinEclairage: '',
            besoinEquipements: '',
            besoinScene: '',
            besoinSonorisation: ''
        },
        utilisateur: '',
        reseau: '',
        genreMusical: '',
        artiste: ''
    });
    const [liensPromotionnels, setLiensPromotionnels] = useState<string[]>(['']);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: value
        });
    };

    const handleLienChange = (index: number, value: string) => {
        const newLiens = [...liensPromotionnels];
        newLiens[index] = value;
        setLiensPromotionnels(newLiens);
    };

    const handleAddLien = () => {
        setLiensPromotionnels([...liensPromotionnels, '']);
    };

    const handleRemoveLien = (index: number) => {
        const newLiens = liensPromotionnels.filter((_, i) => i !== index);
        setLiensPromotionnels(newLiens);
    };

    const handleExtrasChange = (e: React.ChangeEvent<HTMLInputElement> | React.ChangeEvent<HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        setFormData((prevData) => ({
            ...prevData,
            extras: {
                ...prevData.extras,
                [name]: value
            }
        }));
    };

    // const handleRemoveExtras = (index: number) => {
    //     const newExtras = { ...formData.extras };
    //     delete newExtras[index];
    //     setFormData((prevData) => ({
    //         ...prevData,
    //         extras: newExtras
    //     }));
    // };

    const handleConditionsFinancieresChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setFormData((prevData) => ({
            ...prevData,
            conditionsFinancieres: {
                ...prevData.conditionsFinancieres,
                [name]: value
            }
        }));
    };

    const handleBudgetEstimatifChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setFormData((prevData) => ({
            ...prevData,
            budgetEstimatif: {
                ...prevData.budgetEstimatif,
                [name]: value
            }
        }));
    };

    const handleFicheTechniqueChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setFormData((prevData) => ({
            ...prevData,
            ficheTechniqueArtiste: {
                ...prevData.ficheTechniqueArtiste,
                [name]: value
            }
        }));
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        console.log("Création de l'offre:", { ...formData, liensPromotionnels });
    };

    return (
        <div className='mt-10 mb-10 w-[70%]'>
            <form onSubmit={handleSubmit} className="w-full mx-auto bg-white shadow-md rounded-lg p-8 space-y-4">
                <h2 className="text-2xl font-semibold text-center text-gray-800 mb-6">Offre Formulaire</h2>
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div className="flex flex-col">
                        <label htmlFor="titleOffre" className="text-gray-700">Titre de l'Offre:</label>
                        <input
                            type="text"
                            id="titleOffre"
                            name="titleOffre"
                            value={formData.titleOffre}
                            onChange={handleChange}
                            required
                            placeholder="Indiquer le titre de l'Offre"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="deadLine" className="text-gray-700">Date maximale de réponse:</label>
                        <input
                            type="date"
                            id="deadLine"
                            name="deadLine"
                            value={formData.deadLine}
                            onChange={handleChange}
                            required
                            placeholder="La date limite de réponse à l'offre"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="col-span-full flex flex-col">
                        <label htmlFor="descrTournee" className="text-gray-700">Description de la Tournée:</label>
                        <textarea
                            id="descrTournee"
                            name="descrTournee"
                            value={formData.descrTournee}
                            onChange={handleChange}
                            required
                            placeholder='La description de la tournée'
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="dateMinProposee" className="text-gray-700">Date Min Proposée:</label>
                        <input
                            type="date"
                            id="dateMinProposee"
                            name="dateMinProposee"
                            value={formData.dateMinProposee}
                            onChange={handleChange}
                            required
                            placeholder="Date Mininmale Proposée"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="dateMaxProposee" className="text-gray-700">Date Max Proposée:</label>
                        <input
                            type="date"
                            id="dateMaxProposee"
                            name="dateMaxProposee"
                            value={formData.dateMaxProposee}
                            onChange={handleChange}
                            required
                            placeholder="Date Maximale Proposée"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="villeVisee" className="text-gray-700">Ville Visée:</label>
                        <input
                            type="text"
                            id="villeVisee"
                            name="villeVisee"
                            value={formData.villeVisee}
                            onChange={handleChange}
                            required
                            placeholder="Dans quelle ville se déroulera l'offre"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="regionVisee" className="text-gray-700">Région Visée:</label>
                        <input
                            type="text"
                            id="regionVisee"
                            name="regionVisee"
                            value={formData.regionVisee}
                            onChange={handleChange}
                            required
                            placeholder="Dans quelle région se déroulera l'offre"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="placesMin" className="text-gray-700">Places Minimum:</label>
                        <input
                            type="number"
                            id="placesMin"
                            name="placesMin"
                            value={formData.placesMin}
                            onChange={handleChange}
                            required
                            placeholder="Nombre de places minimum"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="placesMax" className="text-gray-700">Places Maximum:</label>
                        <input
                            type="number"
                            id="placesMax"
                            name="placesMax"
                            value={formData.placesMax}
                            onChange={handleChange}
                            required
                            placeholder="Nombre de places maximum"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="nbArtistesConcernes" className="text-gray-700">Nombre d'Artistes Concernés:</label>
                        <input
                            type="number"
                            id="nbArtistesConcernes"
                            name="nbArtistesConcernes"
                            value={formData.nbArtistesConcernes}
                            onChange={handleChange}
                            required
                            placeholder="Nombre d'artistes concernés"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="nbInvitesConcernes" className="text-gray-700">Nombre d'Invités Concernés:</label>
                        <input
                            type="number"
                            id="nbInvitesConcernes"
                            name="nbInvitesConcernes"
                            value={formData.nbInvitesConcernes}
                            onChange={handleChange}
                            required
                            placeholder="Nombre d'invités concernés"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="col-span-full flex flex-col space-y-4">
                        <label htmlFor="liensPromotionnels" className="text-gray-700">Liens Promotionnels:</label>
                        
                        {liensPromotionnels.map((lien, index) => (
                            <div key={index} className="flex items-center space-x-2">
                                <input
                                    type="url"
                                    id={`liensPromotionnels${index}`}
                                    name="liensPromotionnels"
                                    value={lien}
                                    onChange={(e) => handleLienChange(index, e.target.value)}
                                    required
                                    className="flex-grow mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                                    placeholder="Lien promotionnel de l'artiste"
                                />
                                <button
                                    type="button"
                                    onClick={() => handleRemoveLien(index)}
                                    className="bg-red-500 text-white py-2 px-4 rounded-lg w-28 h-10 flex justify-center items-center hover:bg-red-600 transition-colors"
                                >
                                    Supprimer
                                </button>
                            </div>
                        ))}

                        <div className="flex justify-center">
                            <button
                                type="button"
                                onClick={handleAddLien}
                                className="bg-green-500 text-white py-2 px-4 rounded-lg w-35 h-10 flex justify-center items-center hover:bg-green-600 transition-colors"
                            >
                                Ajouter lien
                            </button>
                        </div>
                    </div>
                    <ExtrasForm 
                        extrasData={formData.extras} 
                        onChange={handleExtrasChange}
                        // onRemove={handleRemoveExtras}
                    />
                    <div className="flex flex-col">
                        <label htmlFor="typeOffre" className="text-gray-700">Type d'Offre:</label>
                        <input
                            type="text"
                            id="typeOffre"
                            name="typeOffre"
                            value={formData.typeOffre}
                            onChange={handleChange}
                            required
                            placeholder="Type d'offre"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <ConditionsFinancieresForm
                        conditionsFinancieresData={formData.conditionsFinancieres}
                        onChange={handleConditionsFinancieresChange}
                    />
                    <div className="col-span-full flex flex-col mt-8">
                        <h3 className="text-xl font-semibold text-gray-800 mb-4">Budget Estimatif</h3>
                        <label htmlFor="cachetArtiste" className="text-gray-700">Cachet Artiste:</label>
                        <input
                            type="number"
                            id="cachetArtiste"
                            name="cachetArtiste"
                            value={formData.budgetEstimatif.cachetArtiste}
                            onChange={handleBudgetEstimatifChange}
                            required
                            placeholder="Cachet de l'artiste"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="fraisDeplacement" className="text-gray-700">Frais de Déplacement:</label>
                        <input
                            type="number"
                            id="fraisDeplacement"
                            name="fraisDeplacement"
                            value={formData.budgetEstimatif.fraisDeplacement}
                            onChange={handleBudgetEstimatifChange}
                            required
                            placeholder="Frais de déplacement"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="fraisHebergement" className="text-gray-700">Frais d'Hébergement:</label>
                        <input
                            type="number"
                            id="fraisHebergement"
                            name="fraisHebergement"
                            value={formData.budgetEstimatif.fraisHebergement}
                            onChange={handleBudgetEstimatifChange}
                            required
                            placeholder="Frais d'hébergement"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="fraisRestauration" className="text-gray-700">Frais de Restauration:</label>
                        <input
                            type="number"
                            id="fraisRestauration"
                            name="fraisRestauration"
                            value={formData.budgetEstimatif.fraisRestauration}
                            onChange={handleBudgetEstimatifChange}
                            required
                            placeholder="Frais de restauration"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>

                    <div className="col-span-full flex flex-col mt-8">
                        <h3 className="text-xl font-semibold text-gray-800 mb-4">Fiche Technique Artiste</h3>
                        <label htmlFor="besoinBackline" className="text-gray-700">Besoin Backline:</label>
                        <input
                            type="text"
                            id="besoinBackline"
                            name="besoinBackline"
                            value={formData.ficheTechniqueArtiste.besoinBackline}
                            onChange={handleFicheTechniqueChange}
                            required
                            placeholder="Besoins en backline"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="besoinEclairage" className="text-gray-700">Besoin Éclairage:</label>
                        <input
                            type="text"
                            id="besoinEclairage"
                            name="besoinEclairage"
                            value={formData.ficheTechniqueArtiste.besoinEclairage}
                            onChange={handleFicheTechniqueChange}
                            required
                            placeholder="Besoins en éclairage"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="besoinEquipements" className="text-gray-700">Besoin Équipements:</label>
                        <input
                            type="text"
                            id="besoinEquipements"
                            name="besoinEquipements"
                            value={formData.ficheTechniqueArtiste.besoinEquipements}
                            onChange={handleFicheTechniqueChange}
                            required
                            placeholder="Besoins en équipements"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="besoinScene" className="text-gray-700">Besoin Scène:</label>
                        <input
                            type="text"
                            id="besoinScene"
                            name="besoinScene"
                            value={formData.ficheTechniqueArtiste.besoinScene}
                            onChange={handleFicheTechniqueChange}
                            required
                            placeholder="Besoins en scène"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="besoinSonorisation" className="text-gray-700">Besoin Sonorisation:</label>
                        <input
                            type="text"
                            id="besoinSonorisation"
                            name="besoinSonorisation"
                            value={formData.ficheTechniqueArtiste.besoinSonorisation}
                            onChange={handleFicheTechniqueChange}
                            required
                            placeholder="Besoins en sonorisation"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="reseau" className="text-gray-700">Réseau:</label>
                        <input
                            type="text"
                            id="reseau"
                            name="reseau"
                            value={formData.reseau}
                            onChange={handleChange}
                            required
                            placeholder="Les réseaux sur lesquels vous posterez votre offre"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="genreMusical" className="text-gray-700">Genre Musical:</label>
                        <input
                            type="text"
                            id="genreMusical"
                            name="genreMusical"
                            value={formData.genreMusical}
                            onChange={handleChange}
                            required
                            placeholder="Le genre musical de l'offre"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div className="flex flex-col">
                        <label htmlFor="artiste" className="text-gray-700">Artiste:</label>
                        <input
                            type="text"
                            id="artiste"
                            name="artiste"
                            value={formData.artiste}
                            onChange={handleChange}
                            required
                            placeholder="L'artiste concerné par l'offre"
                            className="mt-1 px-3 py-2 border rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                </div>
                <button type="submit" className="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
                    Poster l'offre
                </button>
            </form>
        </div>
    );
};

export default OffreForm;