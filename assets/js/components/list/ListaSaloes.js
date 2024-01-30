import BuscaApi from '../lib/BuscaApiG.js';

export default class ListaSaloes {
    constructor() {
        this.buscaApi = new BuscaApi(sessionStorage.getItem('token'));
        this.appElement = document.getElementById('app');
        
    }

    async init() {
        await this.buscaSaloes();
    }

    async buscaSaloes() {
        try {
            const data = await this.buscaApi.fetchApi(`Saloes`, 'GET');
            this.renderSaloes(data);
        } catch (error) {
            console.error(error);
        }
    }
    
    renderSaloes(saloes) {
        const divUser = document.querySelector('.main');
        console.log(saloes)
        saloes.forEach(salao => {
            const container = document.createElement("div");
            container.classList.add("w3-card-4");
            container.innerHTML = `
                <div class="w3-container">
                    <h3>Salão: ${salao.nome}</h3>
                    <p>Serviços: ${salao.nome}</p>
                    <img src="assets/img/salao.png" style="width: 150px" alt="Produto">
                </div> 
            `;
            
            divUser.appendChild(container);
        });

        this.appElement.appendChild(divUser);
    }

    render() {
        const mainDiv = document.createElement('div');
        mainDiv.className = 'main';
        this.appElement.appendChild(mainDiv);
        return {
            element: mainDiv,
            init: () => this.init()
        };
    }
}
const saloes = new ListaSaloes();
saloes.render();
saloes.init();


