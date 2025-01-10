"use client";

import React, { useEffect, useState, useCallback } from 'react';
import { apiGet } from '../services/internalApiClients';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from './ui/card';
import { Button, Carousel } from 'flowbite-react';
import Link from 'next/link';
import Image from 'next/image';
import { FaCheck } from 'react-icons/fa';
import { GrInProgress } from 'react-icons/gr';
import { IoIosArrowDown, IoIosArrowUp  } from "react-icons/io";
import { BsBoxArrowDownRight } from "react-icons/bs";
import { PiArrowCircleRightFill, PiArrowCircleLeftFill } from "react-icons/pi";

interface BudgetEstimatif {
    cachetArtiste: number;
    fraisDeplacement: number;
    fraisHebergement: number;
    fraisRestauration: number;
}

interface Project {
    id: number;
    titleOffre: string;
    image: string;
    descrTournee: string;
    deadLine: string;
    budgetEstimatif: BudgetEstimatif;
}

interface Reponse {
    etatReponse: { nomEtatReponse: string };
    prixParticipation: number;
}

interface GenreMusical {
    nomGenreMusical: string;
}

export default function Accueil() {
    const [projects, setProjects] = useState<Project[]>([]);
    const [displayedProjects, setDisplayedProjects] = useState<Project[]>([]);
    const [nbContributions, setNbContributions] = useState<{ [key: number]: { compteurNbContributeur: number, ContributionGlobale: number } }>({});
    const [projectsToShow, setProjectsToShow] = useState(6);
    const [projectIsLoading, setProjectIsLoading] = useState(true);
    const [genresMusicaux, setGenresMusicaux] = useState<GenreMusical[]>([]);

    function fetchAllGenresMusicaux() {
        apiGet('/genres-musicaux').then((response) => {
            setGenresMusicaux(JSON.parse(response.genres_musicaux));
        }).catch((error) => {
            console.error('Erreur lors de la récupération des genres musicaux:', error);
        });
    }

    useEffect(() => {
        fetchAllGenresMusicaux();
    }, []);

    function calculBudgetTotal(budgetEstimatif: BudgetEstimatif) {
        if (!budgetEstimatif) return 0;

        return budgetEstimatif.cachetArtiste + 
            budgetEstimatif.fraisDeplacement + 
            budgetEstimatif.fraisHebergement + 
            budgetEstimatif.fraisRestauration;
    }

    const fetchProjectsNbContributeur = useCallback(async (id: number) => {
        try {
            const response = await apiGet(`/reponses/offre/${id}`);
            let compteurNbContributeur = 0;
            let ContributionGlobale = 0;
            const reponses: Reponse[] = JSON.parse(response.reponses);
            for (const reponse of reponses) {
                if (reponse.etatReponse.nomEtatReponse === "Validée") {
                    compteurNbContributeur++;
                    ContributionGlobale += reponse.prixParticipation;
                }
            }
            return { compteurNbContributeur, ContributionGlobale };
        } catch (error) {
            console.error('Erreur lors de la récupération des offres:', error);
            return { compteurNbContributeur: 0, ContributionGlobale: 0 };
        }
    }, []);

    const fetchAllProjectsNbContributeur = useCallback(async (projects: Project[]) => {
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
    }, [fetchProjectsNbContributeur]);

    const fetchProjects = useCallback(async () => {
        try {
            const response = await apiGet('/offres');
            if (response && response.offres && Array.isArray(response.offres)) {
                setProjects(response.offres);
                setDisplayedProjects(response.offres.slice(0, projectsToShow));
                await fetchAllProjectsNbContributeur(response.offres).then(() => setProjectIsLoading(false));
            } else {
                console.error('Response does not contain offres array:', response);
            }
        } catch (error) {
            console.error('Erreur lors de la récupération des offres:', error);
        }
    }, [fetchAllProjectsNbContributeur, projectsToShow]);

    const loadMoreProjects = () => {
        setProjectsToShow((prev) => prev + 6);
    };

    const showLessProjects = () => {
        setProjectsToShow((prev) => Math.max(prev - 6, 6));
    };

    function randomChoiceBetweenOneAndSix() {
        return Math.floor(Math.random() * 6) + 1;
    }

    useEffect(() => {
        fetchProjects();
    }, [fetchProjects]);

    useEffect(() => {
        setDisplayedProjects(projects.slice(0, projectsToShow));
    }, [projects, projectsToShow]);

    return (
        <div className="w-full pb-[2rem] min-h-screen">
            <Card className='mb-20 relative overflow-hidden rounded-none shadow-lg'>
            <Image 
                width={0} 
                height={0} 
                sizes="100vw"
                src="/concert-page-accueil.jpg" 
                alt="Image de concert" 
                className="w-full object-cover h-64"
            />
            <div className="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-50 text-white">
                <h1 className="text-4xl font-bold mb-4 text-center mb-10">UMODJA</h1>
                <p className="text-center text-white text-lg mb-6">
                Rejoignez notre plateforme de collaboration pour vos projet musicaux et contribuez à des projets au sein de vos réseaux !
                </p>
            </div>
            </Card>
            <div className='ml-[15%] mr-[15%]'>
            <h2 className="text-2xl font-bold mb-6 text-center">Projets en cours dans vos réseaux</h2>
            <p className="text-center text-lg text-gray-700 mb-4">Découvrez les projets en cours et contribuez à leur succès !</p>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {projectIsLoading == false && displayedProjects.map((project) => (
                <Link key={project.id} href={`cardDetailsPage?id=${project.id}`}>
                    <Card className="w-full max-w-sm cursor-pointer shadow-lg hover:shadow-xl transition-shadow">
                    <CardHeader className="relative">
                        <Image width={480} height={480} src={`data:image/jpeg;base64,${project.image}` || '/image-default-offre.jpg'} alt="image du projet" className="w-full h-48 object-cover rounded-t-lg" />
                        <div className={`absolute top-2 left-2 text-xs font-semibold px-2 py-2 rounded ${nbContributions[project.id]?.ContributionGlobale >= calculBudgetTotal(project.budgetEstimatif) ? 'bg-green-500' : 'bg-orange-500'}`}>
                        {nbContributions[project.id]?.ContributionGlobale >= calculBudgetTotal(project.budgetEstimatif) ? <FaCheck /> : <GrInProgress />}
                        </div>
                    </CardHeader>
                    <CardContent className="p-4">
                        <CardTitle>{project.titleOffre}</CardTitle>
                        <div className="flex justify-between text-sm mb-2 font-fredoka">
                        <span>{nbContributions[project.id]?.compteurNbContributeur || 0} contributions</span>
                        <span>{new Date(project.deadLine).toLocaleDateString()}</span>
                        </div>
                        <p className="text-sm text-gray-500 mb-4 font-fredoka">{project.descrTournee}</p>
                    </CardContent>
                    <CardFooter className="p-4">
                        <div className="w-full">
                        <div className="flex justify-between text-sm mb-2 font-fredoka">
                            <span>{nbContributions[project.id]?.ContributionGlobale?.toLocaleString()} €</span>
                            <span>sur {calculBudgetTotal(project.budgetEstimatif)} €</span>
                        </div>
                        <div className="w-full rounded-full h-2 mb-2">
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
            {projectIsLoading == false ? (
            <div className="text-center mt-8 flex flex-col gap-4">
                <div className='flex'>
                <div className='flex gap-2 ml-auto mr-auto'>
                    {projectsToShow < projects.length && (
                    <Button
                        color="light"
                        onClick={loadMoreProjects}
                        className='flex items-center'
                    >
                        Voir plus
                        <IoIosArrowDown className="ml-2 mb-auto mt-auto" />
                    </Button>
                    )}
                    {projectsToShow > 6 && (
                    <Button
                        className='flex items-center'
                        onClick={showLessProjects}
                        color="light"
                    >
                        Voir moins
                        <IoIosArrowUp className="ml-2 mt-auto mb-auto" />
                    </Button>
                    )}
                </div>
                <Link href="/networks">
                    <Button color="info" className="flex items-center">
                    Voir tous les projets
                    <BsBoxArrowDownRight className="ml-2 mt-auto mb-auto" />
                    </Button>
                </Link>
                </div>
            </div>) : null}
            </div>

            <Card className='mt-20 mb-20 relative overflow-hidden rounded-none shadow-lg'>
                <Image 
                    width={0} 
                    height={0} 
                    sizes="100vw"
                    src="/concert-2page-accueil.jpg" 
                    alt="Image de concert" 
                    className="w-full object-cover h-64 object-center"
                />
                <div className="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-50 text-white">
                    <p className="text-center text-white text-lg">
                    Découvrez et rejoignez des réseaux de collaboration musicale pour contribuer à des projets passionnants !
                    </p>
                </div>
            </Card>

            {genresMusicaux && (
            <div className="ml-[25%] mr-[25%] h-64 mb-10">
                <h2 className="text-2xl font-bold text-center">Découvrez les genres de musiques</h2>
                <p className="text-center mt-5">Les genres de musiques courament trouvées dans les projets UMODJA !</p>
                <Carousel 
                    slideInterval={2000} 
                    indicators={false} 
                    className="mb-10" 
                    leftControl={
                        <PiArrowCircleLeftFill className="text-4xl" />
                    } 
                    rightControl={
                        <PiArrowCircleRightFill className="text-4xl" />
                    }>
                {genresMusicaux.map((genreMusical) => (
                    <div key={genreMusical.nomGenreMusical} className="relative pl-[10%] pr-[10%]">
                        <Image
                            width={0}
                            height={0}
                            sizes="100vw"
                            src={`/genre-music-caroussel-${randomChoiceBetweenOneAndSix()}.jpg`}
                            alt="Image de genre musical"
                            className="w-full object-cover h-48 object-center rounded-lg"
                        />
                        <div className="absolute inset-0 flex items-center justify-center">
                            <p className="text-xl font-bold text-center text-white">{genreMusical.nomGenreMusical}</p>
                        </div>
                    </div>
                ))}
                </Carousel>
            </div>
            )}
        </div>
    );
}
