export default class BuscaApi {
    constructor(token) {
        this.token = token;
    }

    async fetchApi(endpoint, method = 'GET', body = null) {
        const headers = {
            'Authorization': this.token,
            'Content-Type': 'application/json'
        };

        const config = {
            method: method,
            headers: headers
        };

        if (body) {
            config.body = JSON.stringify(body);
        }

        const response = await fetch(`backend/Router/${endpoint}`, config);
        return response.json();
    }
    async fetchCEP(cep, method = 'GET') {
        const headers = {
            'Content-Type': 'application/json'
        };
        const config = {
            method: method,
            headers: headers
        };
        
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`, config);
        return response.json();
    }
    async fetchGEO(geo, method = 'GET') {
        const headers = {
            'Content-Type': 'application/json'
        };
        const config = {
            method: method,
            headers: headers
        };
        
        const response = await fetch(`https://nominatim.openstreetmap.org/search?q=${geo}&format=json&limit=1`, config);
        return response.json();
    }
}
