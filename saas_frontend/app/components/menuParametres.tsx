"use client";

import React, { useState } from "react";
import { ListGroup } from "flowbite-react";
import { HiInbox, HiOutlineAdjustments, HiUserCircle } from "react-icons/hi";

export function MenuParametres() {
    const [domain, setDomain] = useState("profil");

    function domainActive(): string {
        return domain;
    }

    function setDomainActuel(domain: string): void {
        setDomain(domain);
        if (typeof window !== 'undefined') {
            window.location.href = `/${domain}`;
        }
    }

    return (
        <div className="flex justify-center mt-10">
        <ListGroup className="w-48 h-40">
            <ListGroup.Item 
                icon={HiUserCircle} 
                onClick={() => setDomainActuel("profil")} 
                active={domainActive() === "profil"}
            >
                Profile
            </ListGroup.Item>
            <ListGroup.Item 
                icon={HiOutlineAdjustments} 
                onClick={() => setDomainActuel("preferences")} 
                active={domainActive() === "preferences-notifications"}
            >
                Préférences
            </ListGroup.Item>
            <ListGroup.Item 
                icon={HiInbox} 
                onClick={() => setDomainActuel("tableau-de-bord")} 
                active={domainActive() === "tableau-de-bord"}
            >
                Tableau de bord
            </ListGroup.Item>
        </ListGroup>
        </div>
    );
}

export default MenuParametres;