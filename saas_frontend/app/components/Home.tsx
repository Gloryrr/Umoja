"use client";
import NavigationHandler from '../navigation/Router';

const Home = () => {
    return (
        <div>
            <NavigationHandler>
                {(handleNavigation: (path: string) => void) => (
                    <button
                        onClick={() => handleNavigation('/offre')}
                        className="text-white font-semibold hover:underline"
                    >
                        Créer une offre
                    </button>
                )}
            </NavigationHandler>
        </div>
    );
};

export default Home;