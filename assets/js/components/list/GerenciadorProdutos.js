import BuscaApi from '../lib/BuscaApiG.js';

export default class GerenciadorProdutos {
    constructor() {
        this.buscaApi = new BuscaApi(sessionStorage.getItem('token'));
    }

    async init() {
        await this.buscaProdutos();
    }
    
    async deleteProdutos(id) {
        return await this.buscaApi.fetchApi(`Produtos`, 'DELETE', { id });
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
                    <h3>Dados no banco</h3>
                    <p>Id: ${produto.id}</p>
                    <h3>Nome: ${produto.nome}</h3>
                    <p>Email: ${produto.preco}</p>
                </div>
                
            `;

            const removeBtn = document.createElement('button');
            removeBtn.textContent = "Remover";
            removeBtn.classList.add("w3-button", "w3-border", "w3-hover-black");
            removeBtn.addEventListener('click', async () => {
                const result = await this.deleteProdutos(produto.id);
                if (result.status) {
                    alert('Produto removido com sucesso!');
                    container.remove();
                } else {
                    alert('Erro ao remover usuário.');
                }
            });
            container.appendChild(removeBtn);
            
            divUser.appendChild(container);
        });
    }

    render() {
        const mainDiv = document.createElement('div');
        mainDiv.className = 'main';
        return {
            element: mainDiv,
            init: () => this.init()
        };
    }
}

