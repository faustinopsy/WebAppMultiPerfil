import BuscaApi from '../lib/BuscaApiG.js';

export default class ListaProdutos {
    constructor() {
        this.buscaApi = new BuscaApi(sessionStorage.getItem('token'));
        this.appElement = document.getElementById('app');
        
    }

    async init() {
        await this.buscaProdutos();
    }

    async buscaProdutos() {
        try {
            const data = await this.buscaApi.fetchApi(`Produtos`, 'GET');
            this.renderProdutos(data.Produtos);
        } catch (error) {
            console.error(error);
        }
    }
    
    renderProdutos(produtos) {
        const divUser = document.querySelector('.main');

        produtos.forEach(produto => {
            const container = document.createElement("div");
            container.classList.add("w3-card-4");
            container.innerHTML = `
                <div class="w3-container">
                    <h3>Nome: ${produto.nome}</h3>
                    <img src="assets/img/combina.png" alt="Produto">
                    <p>Preço: ${produto.preco}</p>
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
const produtos = new ListaProdutos();
produtos.render();
produtos.init();


