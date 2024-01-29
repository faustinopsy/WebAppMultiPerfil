import BuscaApi from '../lib/BuscaApiG.js';

export default class GerenciadorSaloes {
    constructor() {
        this.buscaApi = new BuscaApi(sessionStorage.getItem('token'));
    }

    async init() {
        await this.buscaSaloes();
    }
    
    async deleteSaloes(id) {
        return await this.buscaApi.fetchApi(`Saloes`, 'DELETE', { id });
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

        saloes.forEach(salao => {
            const container = document.createElement("div");
            container.classList.add("w3-card-4");
            container.innerHTML = `
                <div class="w3-container">
                    <h3>Dados no banco</h3>
                    <p>Id: ${salao.id}</p>
                    <h3>Nome: ${salao.nome}</h3>
                </div>
                
            `;

            const removeBtn = document.createElement('button');
            removeBtn.textContent = "Remover";
            removeBtn.classList.add("w3-button", "w3-border", "w3-hover-black");
            removeBtn.addEventListener('click', async () => {
                const result = await this.deleteSaloes(salao.id);
                if (result.status) {
                    alert('Salao removido com sucesso!');
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

