"use client";

import { useCallback,useState, useEffect } from "react";
import { MegaMenu, Navbar, Dropdown, Avatar } from "flowbite-react";
import NavigationHandler from "../navigation/Router";
import Image from "next/image";
import { HiSearch } from "react-icons/hi";
import { IoIosTime } from "react-icons/io";
import { apiGet, apiPost } from "@/app/services/internalApiClients";
import { DarkThemeToggle } from "flowbite-react";

interface SearchResult {
  id: number;
  titleOffre: string;
  villeVisee: string;
  regionVisee: string;
  etatOffreDetail: string;
}

const NavbarApp = () => {
  const [navItems] = useState([
    { id: 1, text: "Accueil", href: "/accueil" },
    { id: 2, text: "Mes réseaux", href: "/networks" },
    { id: 3, text: "Créer un projet", href: "/offre" },
  ]);

  const [username, setUsername] = useState<string | null>(null);
  const [email, setEmail] = useState<string | null>(null);
  const [searchQuery, setSearchQuery] = useState("");
  const [searchResults, setSearchResults] = useState<SearchResult[]>([]);
  const [isLoading, setIsLoading] = useState(false);

  const fetchSearchResults = useCallback(async (query: string) => {
    if (query.length < 1) {
      setSearchResults([]);
      return;
    }
  
    setIsLoading(true);
  
    try {
      const data = {
        "username": username,
        "title": query,
      };
  
      const response = await apiPost("/offres/title", JSON.parse(JSON.stringify(data)));
  
      if (response) {
        const offres = JSON.parse(response.offres).slice(0, 3);
        const offresAvecEtat = await Promise.all(
          offres.map(async (offre: { id: number; etatOffre: { id: number } }) => {
            try {
              const etatResponse = await apiGet(`/etat-offre/${offre.etatOffre.id}`);
              return {
                ...offre,
                etatOffreDetail: JSON.parse(etatResponse.etat_offre)[0].nomEtat || "Inconnu",
              };
            } catch (error) {
              console.error(
                `Erreur lors de la récupération de l'état de l'offre ${offre.id}`,
                error
              );
              return {
                ...offre,
                etatOffreDetail: "Erreur",
              };
            }
          })
        );
        setSearchResults(offresAvecEtat);
      } else {
        setSearchResults([]);
      }
    } catch (error) {
      console.error("Une erreur est survenue durant la récupération des offres", error);
      setSearchResults([]);
    } finally {
      setIsLoading(false);
    }
  }, [username]);

  useEffect(() => {
    const fetchUtilisateur = async () => {
      await apiGet("/me").then((response) => {
          setUsername(response.utilisateur || "");
          setEmail(response.email || "");
      })
    }

    fetchUtilisateur();
  }, []);
  
  useEffect(() => {
    const delayDebounceFn = setTimeout(() => {
      fetchSearchResults(searchQuery);
    }, 300);
  
    return () => clearTimeout(delayDebounceFn);
  }, [searchQuery, fetchSearchResults]);

  const deconnexion = () => {
    sessionStorage.setItem('token', '');
    window.location.href = '/';
  };

  if (username == "") {
    if (typeof window !== "undefined" && window.location.pathname != "/") {
      window.location.href = "/";
    }
  }

    return (
      <MegaMenu className="w-full">
        <div className="flex items-center justify-between w-full py-4 border-b border-gray-300 dark:border-gray-500 px-4">
          {/* Logo à gauche */}
          <Navbar.Brand href="/accueil" className="flex items-center space-x-2">
            <Image
              width={28}
              height={28}
              src="/favicon.ico"
              alt="Flowbite React Logo"
            />
            <span className="text-xl font-semibold whitespace-nowrap dark:text-white">
              UmoDJA
            </span>
          </Navbar.Brand>

          {/* Navigation Links au centre */}
          <NavigationHandler>
            {(handleNavigation) => (
              <nav className="flex items-center space-x-10 font-medium">
                {navItems.map((item) => (
                  <a
                    key={item.id}
                    href="#"
                    onClick={() => handleNavigation(item.href)}
                    className="hover:text-primary-600 dark:hover:text-primary-500 text-center whitespace-nowrap"
                  >
                    {item.text}
                  </a>
                ))}
                <MegaMenu.Dropdown toggle={<span className="cursor-pointer">Services</span>}>
                  <ul className="grid grid-cols-3">
                    <div className="space-y-4 p-4">
                      <li>
                        <a
                          href="/contact"
                          className="hover:text-primary-600 dark:hover:text-primary-500"
                        >
                          Contactez-nous
                        </a>
                      </li>
                    </div>
                    <div className="space-y-4 p-4">
                      <li>
                        <a
                          href="/fonctionnement-projet"
                          className="hover:text-primary-600 dark:hover:text-primary-500"
                        >
                          Le fonctionnement
                        </a>
                      </li>
                    </div>
                    <div className="space-y-4 p-4">
                      <li>
                        <a
                          href="/participations"
                          className="hover:text-primary-600 dark:hover:text-primary-500"
                        >
                          Les Contributions
                        </a>
                      </li>
                    </div>
                    <div className="space-y-4 p-4">
                      <li>
                        <a
                          href="/umodja"
                          className="hover:text-primary-600 dark:hover:text-primary-500"
                        >
                          Umodja
                        </a>
                      </li>
                    </div>
                    <div className="space-y-4 p-4">
                      <li>
                        <a
                          href="/comprendre-les-preferences-de-notifications"
                          className="hover:text-primary-600 dark:hover:text-primary-500"
                        >
                          Les préférences
                        </a>
                      </li>
                    </div>
                  </ul>
                </MegaMenu.Dropdown>
              </nav>
            )}
          </NavigationHandler>

          {/* Barre de recherche */}
          <div className="relative w-1/3">
            <form
              onSubmit={(e) => e.preventDefault()}
              className="relative flex items-center"
            >
              <input
                type="text"
                placeholder="Rechercher un projet dans vos réseaux..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="bg-white dark:bg-gray-800 dark:text-gray-100 w-full px-4 py-2 text-sm border border-gray-300 rounded-full focus:outline-none"
              />
              <HiSearch className="absolute right-4 text-gray-500 bg-white dark:bg-gray-800 dark:text-gray-100" />
            </form>

            {/* Résultats de recherche dynamiques */}
            {searchQuery.length >= 1 && (
              <div className="absolute z-10 w-full mt-2 border border-gray-300 rounded-md shadow-lg">
                {isLoading ? (
                  <p className="bg-white dark:bg-gray-800 p-2 text-sm">Chargement...</p>
                ) : searchResults.length > 0 ? (
                  <>
                    <ul>
                      {searchResults.map((result: SearchResult, index) => (
                        <li
                          key={index}
                          className="bg-white dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-gray-100 p-4 text-sm border-b hover:bg-gray-100 flex flex-col space-y-1"
                          onClick={() => window.location.href = `/cardDetailsPage?id=${result.id}`}
                        >
                          {/* Titre de l'offre */}
                          <h3 className="text-base font-bold">{result.titleOffre}</h3>

                          {/* Ville et région */}
                          <p className="text-gray-600">
                            {result.villeVisee}, {result.regionVisee}
                          </p>

                          {/* État de l'offre */}
                          <div className="flex items-center space-x-2">
                            <IoIosTime color="blue" />
                            <p>{result.etatOffreDetail}</p>
                          </div>
                        </li>
                      ))}
                    </ul>
                    <button
                      onClick={() => window.location.href = "/offres/resultats"}
                      className="bg-white dark:bg-gray-800 dark:text-gray-100 block w-full p-2 text-sm text-center rounded-b-md text-primary-600"
                    >
                      Voir tous les résultats
                    </button>
                  </>
                ) : (
                  <p className="bg-white dark:bg-gray-800 p-2 text-sm text-gray-500">
                    Aucun résultat trouvé.
                  </p>
                )}
              </div>
            )}
          </div>

          <div className="flex">
            <div className="mr-5">
              <DarkThemeToggle/>
            </div>

            {/* Avatar à droite */}
            <Dropdown
              arrowIcon={false}
              inline
              label={
                <Avatar
                  alt="User settings"
                  img="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                  rounded
                  className="h-10 w-10"
                />
              }
            >
              <Dropdown.Header>
                <span className="block text-sm font-medium text-black dark:text-gray-100">
                  {username}
                </span>
                <span className="block truncate text-sm text-gray">
                  {email ? email.slice(0, email.indexOf("@")) : ""}
                </span>
              </Dropdown.Header>
              <Dropdown.Item>
                <NavigationHandler>
                  {(handleNavigation: (path: string) => void) => (
                    <p onClick={() => handleNavigation(`/profil`)}>Mon profil</p>
                  )}
                </NavigationHandler>
              </Dropdown.Item>
              <Dropdown.Item>
                <NavigationHandler>
                  {(handleNavigation: (path: string) => void) => (
                    <p onClick={() => handleNavigation(`/tableau-de-bord`)}>
                      Mon tableau de bord
                    </p>
                  )}
                </NavigationHandler>
              </Dropdown.Item>
              <Dropdown.Item>
                <NavigationHandler>
                  {(handleNavigation: (path: string) => void) => (
                    <p onClick={() => handleNavigation(`/preferences-notifications`)}>
                      Mes préférences
                    </p>
                  )}
                </NavigationHandler>
              </Dropdown.Item>
              <Dropdown.Divider />
              <Dropdown.Item>
                <p onClick={() => { deconnexion() } }>
                  Se déconnecter
                </p>
              </Dropdown.Item>
            </Dropdown>
          </div>
        </div>
      </MegaMenu>
    );
};

export default NavbarApp;
