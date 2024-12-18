type User = {
  id: number;
  emailUtilisateur: string;
  username: string;
  numTelUtilisateur?: string;
  nomUtilisateur?: string;
  prenomUtilisateur?: string;
  role_utilisateur?: string;
};

type Reseaux = {
  id: number;
  nomReseau: string;
  utilisateurs: User[];
};

type Reseaux1 = {
  id: number;
  nomReseau: string;
  id_utilisateur: string;
  id_genre_musique: string;
  offrets: string[];
};

type Reseaux2 = {
  nomReseau: string;
};



export type { User, Reseaux, Reseaux1, Reseaux2 };