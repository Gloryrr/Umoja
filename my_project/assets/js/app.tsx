import React from 'react';
import ReactDOM from 'react-dom';
import '../styles/tailwind.css';  // Importer Tailwind

const App: React.FC = () => {
    return (
        <div className="text-center text-blue-500">
            <h1 className="text-4xl font-bold">Hello React + TypeScript + Tailwind + Symfony!</h1>
        </div>
    );
};

ReactDOM.render(<App />, document.getElementById('root'));