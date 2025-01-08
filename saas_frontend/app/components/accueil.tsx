"use client"

import React, { useEffect, useState } from 'react';
import { apiGet } from '../services/internalApiClients'; // Assurez-vous que le chemin est correct
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from './ui/card';
import Link from 'next/link';
import Image from 'next/image';
import { FaCheck } from 'react-icons/fa';
import { GrInProgress } from 'react-icons/gr';

interface BudgetEstimatif {
    cachetArtiste: number;
    fraisDeplacement: number;
    fraisHebergement: number;
    fraisRestauration: number;
}

export default function Accueil() {
    const [projects, setProjects] = useState<any[]>([]);
    const [nbContributions, setNbContributions] = useState<{ [key: number]: { compteurNbContributeur: number, ContributionGlobale: number } }>({});

    function calculBudgetTotal(budgetEstimatif: BudgetEstimatif) {
        return budgetEstimatif.cachetArtiste + 
            budgetEstimatif.fraisDeplacement + 
            budgetEstimatif.fraisHebergement + 
            budgetEstimatif.fraisRestauration;
    }

    const fetchProjects = async () => {
        try {
            const response = await apiGet('/offres');
            // console.log('API response:', response); // Log the response
            if (response && response.offres && Array.isArray(response.offres)) {
                setProjects(response.offres);
                await fetchAllProjectsNbContributeur(response.offres);
            } else {
                console.error('Response does not contain offres array:', response);
            }
        } catch (error) {
            console.error('Erreur lors de la récupération des offres:', error);
        }
    };

    const fetchProjectsNbContributeur = async (id: number) => {
        try {
            const response = await apiGet(`/reponses/offre/${id}`);
            let compteurNbContributeur = 0;
            let ContributionGlobale = 0;
            const reponses = JSON.parse(response.reponses);
            for (const reponse of reponses) {
                if ((reponse as any).etatReponse.nomEtatReponse === "Validée") {
                    compteurNbContributeur++;
                    ContributionGlobale += (reponse as any).prixParticipation;
                }
            }
            return { compteurNbContributeur, ContributionGlobale };
        } catch (error) {
            console.error('Erreur lors de la récupération des offres:', error);
            return { compteurNbContributeur: 0, ContributionGlobale: 0 };
        }
    };

    const fetchAllProjectsNbContributeur = async (projects: any[]) => {
        const contributions = await Promise.all(
            projects.map(async (project) => {
                const { compteurNbContributeur, ContributionGlobale } = await fetchProjectsNbContributeur(project.id);
                return { id: project.id, compteurNbContributeur, ContributionGlobale };
            })
        );
        const contributionsMap = contributions.reduce((acc, { id, compteurNbContributeur, ContributionGlobale }) => {
            acc[id] = { compteurNbContributeur, ContributionGlobale };
            return acc;
        }, {} as { [key: number]: { compteurNbContributeur: number, ContributionGlobale: number } });
        setNbContributions(contributionsMap);
    };

    useEffect(() => {
        fetchProjects();
    }, []);

    if (projects.length === 0) {
        return (
            <div className="flex items-center justify-center h-screen w-screen bg-gray-800">
                <p className="text-2xl font-semibold text-white">Vous n&apos;avez pas d&apos;offre en cours</p>
            </div>
        );
    }
    
    return (
        <div className="pl-[10rem] pt-[2rem] pb-[4rem] bg-gray-800 w-screen min-h-screen">
            <h1 className="text-3xl font-bold mb-6 text-white">Projets en cours</h1>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {projects.map((project) => (
                    <Link key={project.id} href={`cardDetailsPage?id=${project.id}`}>
                        <Card className="w-full max-w-sm cursor-pointer">
                            <CardHeader>
                                <Image width={480} height={480} src={`data:image/jpeg;base64,${project.image}`} alt={project.titleOffre} className="w-full h-full object-cover" />
                                <div className={`absolute top-2 left-2 text-xs font-semibold px-2 py-2 rounded ${nbContributions[project.id]?.ContributionGlobale >= calculBudgetTotal(project.budgetEstimatif) ? 'bg-green-500' : 'bg-orange-500'}`}>
                                    {nbContributions[project.id]?.ContributionGlobale >= calculBudgetTotal(project.budgetEstimatif) ? <FaCheck /> : <GrInProgress />}
                                </div>
                            </CardHeader>
                            <CardContent>
                                <CardTitle>{project.titleOffre}</CardTitle>
                                <div className="flex justify-between text-sm mb-2 font-fredoka">
                                    <span>{nbContributions[project.id]?.compteurNbContributeur || 0} contributions</span>
                                    <span>{new Date(project.deadLine).toLocaleDateString()}</span>
                                </div>
                                <p className="text-sm text-gray-400 mb-4 font-fredoka">{project.descrTournee}</p>
                            </CardContent>
                            <CardFooter>
                                <div className="w-full">
                                    <div className="flex justify-between text-sm mb-2 font-fredoka">
                                        <span>{nbContributions[project.id]?.ContributionGlobale?.toLocaleString()} €</span>
                                        <span>sur {calculBudgetTotal(project.budgetEstimatif)} €</span>
                                    </div>
                                    <div className="w-full bg-gray-700 rounded-full h-2 mb-2">
                                        <div className={`h-2 rounded-full ${nbContributions[project.id]?.ContributionGlobale >= calculBudgetTotal(project.budgetEstimatif) ? 'bg-green-500' : 'bg-orange-500'}`} style={{ width: `${Math.min((nbContributions[project.id]?.ContributionGlobale / calculBudgetTotal(project.budgetEstimatif)) * 100, 100)}%` }}></div>
                                    </div>
                                    <div className={`text-right text-sm font-semibold font-fredoka ${nbContributions[project.id]?.ContributionGlobale >= calculBudgetTotal(project.budgetEstimatif) ? 'text-green-500' : 'text-orange-500'}`}>
                                        {Math.round((nbContributions[project.id]?.ContributionGlobale / calculBudgetTotal(project.budgetEstimatif)) * 100)}%
                                    </div>
                                </div>
                            </CardFooter>
                        </Card>
                    </Link>
                ))}
            </div>
        </div>
    );
}