// const BASE_URL = 'http://localhost:8000/api/v1';
const BASE_URL = 'https://umoja.alexstevenslabs.io/api/v1';

const renvoieReponsePromise = async (response: Response) => {
    if (!response.ok) {
        const errorData = await response.json();
        console.error(errorData);
        return errorData;
    }
    return response.json();
};

// Fonction GET
export const apiGet = async (endpoint: string) => {
    const token = sessionStorage.getItem('token');
    const response = await fetch(`${BASE_URL}${endpoint}`, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
        },
    });
    return renvoieReponsePromise(response);
};

// Fonction POST
export const apiPost = async (endpoint: string, data: JSON) => {
    if (endpoint === '/login' || endpoint === '/register') {
        const response = await fetch(`${BASE_URL}${endpoint}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
        return renvoieReponsePromise(response);
    } else {
        const token = sessionStorage.getItem('token');
        const response = await fetch(`${BASE_URL}${endpoint}`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
        return renvoieReponsePromise(response);
    }
};

// Fonction POST
export const apiPostSFTP = async (endpoint: string, data: FormData) => {
    const token = sessionStorage.getItem('token');
    const options: RequestInit = {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${token}`,
        },
    };

    if (data instanceof FormData) {
        options.body = data;
    } else {
        options.headers = {
            ...options.headers,
            'Content-Type': 'application/json',
        };
        options.body = JSON.stringify(data);
    }

    const response = await fetch(`${BASE_URL}${endpoint}`, options);
    return renvoieReponsePromise(response);
};


// Fonction PATCH
export const apiPatch = async (endpoint: string, data: JSON) => {
    const token = sessionStorage.getItem('token');
    const response = await fetch(`${BASE_URL}${endpoint}`, {
        method: 'PATCH',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    });
    return renvoieReponsePromise(response);
};

// Fonction DELETE
export const apiDelete = async (endpoint: string) => {
    const token = sessionStorage.getItem('token');
    const response = await fetch(`${BASE_URL}${endpoint}`, {
        method: 'DELETE',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
        },
    });
    return renvoieReponsePromise(response);
};

export const apiDeleteWithParams = async (endpoint: string, data : JSON) => {
    const token = sessionStorage.getItem('token');
    const response = await fetch(`${BASE_URL}${endpoint}`, {
        method: 'DELETE',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    });
    return renvoieReponsePromise(response);
};
