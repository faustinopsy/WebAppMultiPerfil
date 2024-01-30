import BuscaApi from '../lib/BuscaApiG.js';
import Mensagem from '../lib/Mensagens.js';

export default class GerenciadorSaloes {
    constructor(navigateCallback) {
        this.navigate = navigateCallback;
        this.buscaApi = new BuscaApi(sessionStorage.getItem('token'));
        this.mensagem = new Mensagem();
    }

    async init() {
        await this.buscaSaloes();
    }
    
    async deleteSaloes(id) {
        return await this.buscaApi.fetchApi(`Saloes`, 'DELETE', { id });
    }

    async buscaSaloes() {
        try {
            const data = await this.buscaApi.fetchApi(`Saloes/MeuSalao`, 'GET');
            this.renderSaloes(data);
        } catch (error) {
            console.error(error);
            
        }
    }
    
    renderSaloes(saloes='') {
        const divUser = document.querySelector('.main');
        const container1 = document.createElement("div");
        const salaoBtn = document.createElement('button');
        salaoBtn.textContent = "Cadastrar salão";
        salaoBtn.classList.add("w3-button", "w3-border","w3-green", "w3-hover-black");
        salaoBtn.addEventListener('click', async () => {
            this.navigate('cadsalao');
        });
        if(saloes.length<1){
            container1.appendChild(salaoBtn);
            divUser.appendChild(container1);
        }
        
        if(saloes!=''){
            saloes.forEach(salao => {
                const container = document.createElement("div");
                container.classList.add("w3-card-4");
                container.innerHTML = `
                    <div class="w3-container">
                        <h3>Meu Salão</h3>
                        <p hidden>Id: ${salao.id}</p>
                        <h3>Nome: ${salao.nome}</h3>
                    </div>
                    
                `;
                const idSalao = salao.id;
                const enderecoBtn = document.createElement('button');
                enderecoBtn.textContent = "Cadastrar Endereço";
                enderecoBtn.classList.add("w3-button","w3-green", "w3-border", "w3-hover-black");
                enderecoBtn.addEventListener('click', async () => {
                    this.navigate('cadendereco',  idSalao );
                });
                container.appendChild(enderecoBtn);
    
    
                const removeBtn = document.createElement('button');
                removeBtn.textContent = "Remover Salão";
                removeBtn.classList.add("w3-button","w3-red", "w3-border", "w3-hover-black");
                removeBtn.addEventListener('click', async () => {
                    const isConfirmed = await this.mensagem.confirmAction('delete');
                    if (isConfirmed) {
                        const result = await this.deleteSaloes(salao.id);
                        if (result) {
                            Swal.fire("Excluído!", "O salão foi excluído com sucesso.", "success");
                            container.remove();
                            container1.appendChild(salaoBtn);
                            divUser.appendChild(container1);
                        }
                    }
                });
                container.appendChild(removeBtn);
                
                divUser.appendChild(container);
            });
        }
        
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

