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
    const response = await fetch(`${endpoint}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    });
    return renvoieReponsePromise(response);
};

// Fonction POST
export const apiPost = async (endpoint: string, data: string) => {
    const response = await fetch(`${endpoint}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: data,
    });
    return renvoieReponsePromise(response);
};

// Fonction PUT
export const apiPut = async (endpoint: string, data: JSON) => {
    const response = await fetch(`${endpoint}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    });
    return renvoieReponsePromise(response);
};

// Fonction DELETE
export const apiDelete = async (endpoint: string) => {
    const response = await fetch(`${endpoint}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
    });
    return renvoieReponsePromise(response);
};
