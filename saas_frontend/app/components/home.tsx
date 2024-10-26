"use client"
import NavigationHandler from './router';

const Home = () => {
    return (
        <div>
            <button>
                <NavigationHandler>
                    {(handleNavigation: (path: string) => void) => (
                        <a onClick={() => handleNavigation('/offre')} className="text-white no-underline font-semibold hover:underline">Créer une offre</a>
                    )}
                </NavigationHandler>
            </button>
        </div>
    );
};

export default Home;