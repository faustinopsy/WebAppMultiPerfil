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
}
