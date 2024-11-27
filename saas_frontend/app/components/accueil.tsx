import { Card, CardContent, CardFooter, CardHeader, CardTitle } from './ui/card'
import React from 'react'
import { FaCheck } from "react-icons/fa";
import { GrInProgress } from "react-icons/gr";
import Link from 'next/link';
import Image from 'next/image';

type Project = {
    id: number
    title: string
    creator: string
    contributions: number
    endDate: string
    amountRaised: number
    goal: number
    imageUrl: string
}

export default function Accueil({ projects = [] }: { projects: Project[] }) {
    if (projects.length === 0) {
        return (
        <div className="flex items-center justify-center h-screen bg-gray-800">
            <p className="text-2xl font-semibold text-white">Vous n&apos;avez pas d&apos;offre en cours</p>
        </div>
        )
    }
    return (
        <div className="container mx-auto p-4 bg-gray-800 min-h-screen">
            <h1 className="text-3xl font-bold mb-6 text-white ">Projets en cours</h1>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {projects.map((project) => (
                <Link key={project.id} href={`cardDetailsPage?id=${project.id}`}>
                    <Card className="w-full max-w-sm cursor-pointer">
                        <CardHeader>
                            {project.amountRaised >= project.goal ? (
                            <>
                                <Image width={480} height={480} src={project.imageUrl} alt={project.title} className="w-full h-full object-cover" />
                                <div className="absolute top-2 left-2 bg-green-500 text-xs font-semibold px-2 py-2 rounded">
                                    <FaCheck />
                                </div>
                            </>
                            ) : (
                            <>
                                <Image width={480} height={480} src={project.imageUrl} alt={project.title} className="w-full h-full object-cover" />
                                <div className="absolute top-2 left-2 bg-orange-500 text-xs font-semibold px-2 py-2 rounded">
                                    <GrInProgress />
                                </div>
                            </>
                            )}
                        </CardHeader>
                        <CardContent>
                            <CardTitle>{project.title}</CardTitle>
                            <p className="text-sm text-gray-400 mb-4 font-fredoka">par {project.creator}</p>
                            <div className="flex justify-between text-sm mb-2 font-fredoka">
                                <span>{project.contributions} contributions</span>
                                <span>{project.endDate}</span>
                            </div>
                        </CardContent>
                        <CardFooter>
                            <div className="w-full">
                            <div className="flex justify-between text-sm mb-2 font-fredoka">
                                <span>{project.amountRaised.toLocaleString()} €</span>
                                <span>sur {project.goal.toLocaleString()} €</span>
                            </div>
                            <div className="w-full bg-gray-700 rounded-full h-2 mb-2">
                            <div
                                className={`h-2 rounded-full ${project.amountRaised >= project.goal ? 'bg-green-500' : 'bg-orange-500'}`}
                                style={{ width: `${Math.min((project.amountRaised / project.goal) * 100, 100)}%` }}
                            ></div>
                            </div>
                            <div className={`text-right text-sm font-semibold font-fredoka ${project.amountRaised >= project.goal ? 'text-green-500' : 'text-orange-500'}`}>
                                {Math.round((project.amountRaised / project.goal) * 100)}%
                            </div>
                            </div>
                        </CardFooter>
                    </Card>
                </Link>
            ))}
            </div>
        </div>
    )
}