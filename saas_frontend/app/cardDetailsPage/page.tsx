"use client"

import React from 'react';
import { useSearchParams } from 'next/navigation';
import { FaHeart, FaCode, FaFacebookF, FaTwitter, FaLinkedinIn } from 'react-icons/fa';

type Project = {
    id: number
    title: string
    creator: string
    description: string
    contributions: number
    endDate: string
    amountRaised: number
    goal: number
    imageUrl: string
    videoUrl: string
}

const projects: Project[] = [
    {
        id: 1,
        title: "Tournée de Angele",
        creator: "Alex Stevens Lab",
        description: "La toute nouvelle tournée en France de Angele",
        contributions: 512,
        endDate: "25/02/22",
        amountRaised: 15600,
        goal: 15000,
        imageUrl: "/angele.jpeg",
        videoUrl: "https://www.youtube.com/embed/5TqetBMBTww?si=FZsGFzV7de6kyJI4"
    },
    {
        id: 2,
        title: "Tournée de Damso",
        creator: "Alex Stevens Lab",
        description: "La toute nouvelle tournée en France de Damso",
        contributions: 512,
        endDate: "28/02/24",
        amountRaised: 8000,
        goal: 15000,
        imageUrl: "/Damso.jpeg",
        videoUrl: "https://www.youtube.com/embed/GGhKPm18E48?si=Sd7LiYwV_ZA4z-B4"
    },
    // Add more projects as needed
];

export default function ProjectDetails() {
    const searchParams = useSearchParams();
    const id = searchParams.get('id');
    const project = projects.find(p => p.id === Number(id));

    if (!project) {
        return <div className="flex items-center justify-center h-screen bg-gray-900 text-white">Project not found</div>;
    }

    return (
        <div className="bg-gray-900 h-screen w-full text-white flex items-center justify-center">
            <div className="container mx-auto px-8 py-16 max-w-8xl">
                <h1 className="text-6xl font-bold mb-4 text-center">{project.title}</h1>
                <p className="text-xl mb-12 text-center">{project.description}</p>
                
                <div className="flex flex-col md:flex-row">
                    <div className="md:w-1/2 md:pr-4 mb-8 md:mb-0">
                        <div className="aspect-video">
                            <iframe 
                                className="w-full h-full"
                                src={project.videoUrl} 
                                title={project.title}
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowFullScreen
                            ></iframe>
                        </div>
                    </div>
                    <div className="md:w-1/2 md:pl-4">
                        <div className="mb-6">
                            <h2 className="text-2xl font-semibold">{project.creator}</h2>
                        </div>
                        <div className="bg-gray-800 rounded-lg p-6 mb-8">
                            
                            <div className="flex justify-between mb-4">
                                <div>
                                    <p className="text-3xl font-bold">{project.amountRaised.toLocaleString()} €</p>
                                    <p className="text-gray-400">sur {project.goal.toLocaleString()} €</p>
                                </div>
                                <div className="text-right">
                                    <p className="text-3xl font-bold">{project.contributions}</p>
                                    <p className="text-gray-400">Contributions</p>
                                </div>
                                <div className="text-right">
                                    <p className="text-3xl font-bold">{project.endDate}</p>
                                    <p className="text-gray-400">Date de fin</p>
                                </div>
                            </div>
                            <div className="w-full bg-gray-700 rounded-full h-2 mb-2">
                                <div
                                    className="h-2 rounded-full bg-green-500"
                                    style={{ width: `${Math.min((project.amountRaised / project.goal) * 100, 100)}%` }}
                                ></div>
                            </div>
                            <p className="text-right text-green-500 font-semibold mb-4">
                                {Math.round((project.amountRaised / project.goal) * 100)}%
                            </p>
                        </div>
                        <div className="flex justify-center space-x-4">
                            <button className="bg-white text-black px-8 py-4 rounded-full font-semibold hover:bg-gray-200 transition duration-300">
                                Contribuer
                            </button>
                            <button className="bg-gray-800 text-white px-6 py-4 rounded-full font-semibold hover:bg-gray-700 transition duration-300">
                                <FaFacebookF />
                            </button>
                            <button className="bg-gray-800 text-white px-6 py-4 rounded-full font-semibold hover:bg-gray-700 transition duration-300">
                                <FaTwitter />
                            </button>
                            <button className="bg-gray-800 text-white px-6 py-4 rounded-full font-semibold hover:bg-gray-700 transition duration-300">
                                <FaLinkedinIn />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}