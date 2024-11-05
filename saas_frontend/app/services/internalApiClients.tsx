const BASE_URL = 'http://localhost:8000/api/v1';

const renvoieReponsePromise = async (response: Response) => {
    if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'Erreur de requête');
    }
    return response.json();
};

// Fonction GET
export const apiGet = async (endpoint: string) => {
    const response = await fetch(`${BASE_URL}${endpoint}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    });
    return renvoieReponsePromise(response);
};

// Fonction POST
export const apiPost = async (endpoint: string, data: JSON) => {
    const response = await fetch(`${BASE_URL}${endpoint}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    });
    return renvoieReponsePromise(response);
};

// Fonction PUT
export const apiPut = async (endpoint: string, data: JSON) => {
    const response = await fetch(`${BASE_URL}${endpoint}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    });
    return renvoieReponsePromise(response);
};

// Fonction DELETE
export const apiDelete = async (endpoint: string) => {
    const response = await fetch(`${BASE_URL}${endpoint}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
    });
    return renvoieReponsePromise(response);
};
