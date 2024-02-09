import BuscaApi from '../lib/BuscaApiG.js';

export default class ListaSaloes {
    constructor() {
        this.buscaApi = new BuscaApi(sessionStorage.getItem('token'));
        this.appElement = document.getElementById('app');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => this.buscaSaloesGEO(position));
          } else {
            console.log("Geolocation is not supported by this browser.");
          }
    }

    async init() {
        
    }
   
    async buscaSaloes(bairro) {
        let bairroCodificado = encodeURI(bairro);
        try {
            const data = await this.buscaApi.fetchApi(`Enderecos?bairro=${bairroCodificado}`, 'GET');
            this.renderSaloes(data);
        } catch (error) {
            console.error(error);
        }
    }
    async buscaSaloesGEO(position) {
        let lat = position.coords.latitude.toFixed(5);; 
        let long = position.coords.longitude.toFixed(5);; 
        let query = `Enderecos/geo?lat=${encodeURIComponent(lat)}&long=${encodeURIComponent(long)}`;

        try {
            const data = await this.buscaApi.fetchApi(query, 'GET');
               this.renderSaloes(data);
            } catch (error) {
                console.error(error);
            }
    }
    
    renderSaloes(salao2) {
        const divUser = document.querySelector('.main');
            salao2.forEach(salao => {
                const container = document.createElement("div");
                container.classList.add("w3-card");
                container.innerHTML = `
                    <div class="w3-panel">
                        <h3>${salao.nome}</h3>
                        <h4>Serviços</h4>
                        <hr>
                        <p>${salao.nome}</p>
                        <img src="assets/img/salao.png" style="width: 150px" alt="Produto">
                    </div> 
                `;
                
                divUser.appendChild(container);
            });
       
        this.appElement.appendChild(divUser);
    }

    render() {
        document.getElementById('titulo').innerHTML='Busca de salões';
        this.appElement.innerHTML='';
        const mainDiv = document.createElement('div');
        mainDiv.className = 'main';
        
        const searchDiv = document.createElement('div');
        searchDiv.innerHTML='';
        searchDiv.className = 'w3-bar';
        const inputBairro = document.createElement('input');
        inputBairro.className = "w3-input";
        inputBairro.style.width = "100%";
        // inputBairro.style.marginLeft= '20px';
        inputBairro.classList.add('w3-border', 'w3-bar-item');
        inputBairro.type = 'text';
        inputBairro.placeholder = 'Digite o bairro...';
        inputBairro.id = 'inputBairro';
        
        const searchButton = document.createElement('button');
        searchButton.className = "w3-button";
        searchButton.classList.add('w3-blue','w3-bar-item');
        searchButton.style.width = "100%";
        searchButton.textContent = 'Buscar';
        searchButton.addEventListener('click', () => {
            const bairro = document.getElementById('inputBairro').value;
            this.buscaSaloes(bairro);
        });

        searchDiv.appendChild(inputBairro);
        searchDiv.appendChild(searchButton);
        mainDiv.appendChild(searchDiv);
        this.appElement.appendChild(mainDiv);
        return {
            element: mainDiv,
            init: () => this.init()
        };
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const classe = new ListaSaloes();
    const app = document.getElementById('app');
    const { element, init } = classe.render();
    app.appendChild(element);
 });
 