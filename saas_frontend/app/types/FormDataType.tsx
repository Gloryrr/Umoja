// type pour les détails de l'offre
export type DetailOffre = {
    id: number | null;
    titleOffre: string | null;
    deadLine: string | Date | null;
    descrTournee: string | null;
    dateMinProposee: string | Date | null;
    dateMaxProposee: string | Date | null;
    villeVisee: string | null;
    regionVisee: string | null;
    placesMin: number | null;
    placesMax: number | null;
    nbArtistesConcernes: number | null;
    nbInvitesConcernes: number | null;
};

// type pour les extras
export type Extras = {
    descrExtras: string | null;
    coutExtras: number | null;
    exclusivite: string | null;
    exception: string | null;
    clausesConfidentialites: string | null;
};

// type pour l'état de l'offre
export type EtatOffre = {
    nomEtatOffre: string | null;
};

// type pour le type de l'offre
export type TypeOffre = {
    nomTypeOffre: string | null;
};

// type pour les conditions financières
export type ConditionsFinancieres = {
    minimunGaranti: number | null;
    conditionsPaiement: string | null;
    pourcentageRecette: number | null;
};

// type pour le budget estimatif
export type BudgetEstimatif = {
    cachetArtiste: number | null;
    fraisDeplacement: number | null;
    fraisHebergement: number | null;
    fraisRestauration: number | null;
};

// type pour la fiche technique de l'artiste
export type FicheTechniqueArtiste = {
    besoinBackline: string | null;
    besoinEclairage: string | null;
    besoinEquipements: string | null;
    besoinScene: string | null;
    besoinSonorisation: string | null;
    ordrePassage: string | null;
    liensPromotionnels: string[];
    artiste: Artiste[];
    nbArtistes: number | null;
};

// type pour les données supplémentaires
export type DonneesSupplementaires = {
    reseau: Reseau[];
    nbReseaux: number | null;
    genreMusical: GenreMusical[];
    nbGenresMusicaux: number | null;
};

export type Reseau = {
    nomReseau: string;
}

export type GenreMusical = {
    nomGenreMusical: string;
}

export type Artiste = {
    nomArtiste: string;
}

// type pour l'utilisateur
export type Utilisateur = {
    username: string | null;
};

// type global pour formData
export type FormData = {
    detailOffre: DetailOffre;
    extras: Extras;
    etatOffre: EtatOffre;
    typeOffre: TypeOffre;
    conditionsFinancieres: ConditionsFinancieres;
    budgetEstimatif: BudgetEstimatif;
    ficheTechniqueArtiste: FicheTechniqueArtiste;
    donneesSupplementaires: DonneesSupplementaires;
    utilisateur: Utilisateur;
    image: {
        file: ArrayBuffer | null;
    };
};
