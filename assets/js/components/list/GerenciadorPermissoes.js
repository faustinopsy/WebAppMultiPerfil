import BuscaApi from '../lib/BuscaApiG.js';

export default class GerenciadorPermissoes {
    constructor() {
        this.buscaApi = new BuscaApi(sessionStorage.getItem('token'));
        this.addPerfilModal = null;
        this.addPermissaoModal = null;
        this.novoPerfilNome = null;
        this.novaPermissaoNome = null;
        this.addPerfilNovaBtn = null;
        this.addPermissaoNovaBtn = null;
    }

    async init() {
        await this.populatePerfis();
        await this.populateDropdown();
        this.bindEvents();
    }
    async addPerfil() {
        const nome = this.novoPerfilNome.value;
        const data = await this.buscaApi.fetchApi('Perfil', 'POST', { nome: nome });

        if (data.status) {
            alert('Perfil adicionado com sucesso!');
            await this.populatePerfis(); 
            this.addPerfilModal.style.display = 'none';
        } else {
            alert('Erro ao adicionar perfil.');
        }
    }

    async addPermissao() {
        const nome = this.novaPermissaoNome.value;
        const data = await this.buscaApi.fetchApi('Permissoes', 'POST', { nome: nome });

        if (data.status) {
            alert('Permissão adicionada com sucesso!');
            await this.populateDropdown(); 
            this.addPermissaoModal.style.display = 'none';
        } else {
            alert('Erro ao adicionar permissão.');
        }
    }
    async getPerfis() {
        return await this.buscaApi.fetchApi('Perfil', 'GET');
    }
    
    async getListaPermissoes() {
        return await this.buscaApi.fetchApi('Permissoes', 'GET');
    }
    
    async getPermissoes(perfilId) {
        return await this.buscaApi.fetchApi(`Associar/${perfilId}`, 'GET');
    }
    async addAssociarPermissao(perfilId, permissaoId) {
        const result = await this.buscaApi.fetchApi('Associar', 'POST', { perfilId, permissao_id: permissaoId });
        if (result.status) {
            alert('Associação realizada com sucesso!');
        } else {
            alert('Erro ao remover permissão.');
        }
        return result;
    }
    
    async deleteAssociarPermissao(perfilId, permissaoId) {
        return await this.buscaApi.fetchApi(`Associar/${perfilId}`, 'DELETE', { permissao_id: permissaoId });
    }
        
    async populatePerfis() {
        const perfis = await this.getPerfis();
       
        const select = document.getElementById('perfilSelect');
        const permissoesList = document.getElementById('permissoesList');
    
        perfis.forEach(perfil => {
           
    
            const option = document.createElement('option');
            option.value = perfil.id;
            option.textContent = perfil.nome;
            select.appendChild(option);
        });
    
        select.addEventListener('change', async (event) => {
            while (permissoesList.firstChild) {
                permissoesList.removeChild(permissoesList.firstChild);
            }
    
            const perfilId = event.target.value;
            if (perfilId) {
                const permissoes = await this.getPermissoes(perfilId);
                if (permissoes && permissoes.length) {
                    permissoes.forEach(permis => {
                        permis.forEach(permissao => {
                        const li = document.createElement('li');
                        
                        const span = document.createElement('span');
                        span.textContent = permissao.nome + " ";
                        li.appendChild(span);
                    
                        const removeBtn = document.createElement('button');
                        removeBtn.textContent = "Remover";
                        removeBtn.classList.add("w3-button", "w3-round", "w3-border");
                        removeBtn.addEventListener('click', async () => {
                            const result = await this.deleteAssociarPermissao(perfilId, permissao.id);
                            if (result.status) {
                                alert('Permissão removida com sucesso!');
                                li.remove(); 
                            } else {
                                alert('Erro ao remover permissão.');
                            }
                        });
                        li.appendChild(removeBtn);
                    
                        permissoesList.appendChild(li);
                    });
                });
                } else {
                    const li = document.createElement('li');
                    li.textContent = "Sem permissões associadas";
                    permissoesList.appendChild(li);
                }
            }
        });
    }
    

    async populateDropdown() {
        const permissoes = await this.getListaPermissoes();
        const selectElem = document.getElementById("permissaoSelect");

        permissoes.forEach(permissao => {
            const optionElem = document.createElement("option");
            optionElem.value = permissao.id;
            optionElem.textContent = permissao.nome;
            selectElem.appendChild(optionElem);
        });
    }

    bindEvents() {
        this.addPerfilModal = document.getElementById('addPerfilModal');
        this.addPermissaoModal = document.getElementById('addPermissaoModal');
    
        this.novoPerfilNome = document.getElementById('novoPerfilNome');
        this.novaPermissaoNome = document.getElementById('novaPermissaoNome');

        const addPerfilBtn = document.getElementById('addPerfilNova');
        const addPermissaoBtn = document.getElementById('addPermissaoNova');

        const savePerfilBtn = document.getElementById('savePerfilBtn'); 
        const savePermissaoBtn = document.getElementById('savePermissaoBtn'); 

    addPerfilBtn.addEventListener('click', () => {
        this.addPerfilModal.style.display = 'block';
    });

    addPermissaoBtn.addEventListener('click', () => {
        this.addPermissaoModal.style.display = 'block';
    });

    savePerfilBtn.addEventListener('click', async () => {
        await this.addPerfil();
    });

    savePermissaoBtn.addEventListener('click', async () => {
        await this.addPermissao();
    });

        document.getElementById('addPermissaoBtn').addEventListener('click', async () => {
            const perfilId = document.getElementById('perfilSelect').value;
            const permissaoId = document.getElementById('permissaoSelect').value;
            if(perfilId ==='' || permissaoId===''){
                alert('Selecione um perfil e uma permissão')
                return;
            }
            await this.addAssociarPermissao(perfilId, permissaoId);
        });
        
        document.getElementById('perfilSelect').addEventListener('change', async (event) => {
            await this.populatePermissoesList(event.target.value);
        });
    }


    showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
        }
    }

    async populatePermissoesList(perfilId) {
        
    }
    
    render() {
        const mainDiv = document.createElement('div');
        mainDiv.className = 'main';
        const perfilCard = document.createElement('div');
        perfilCard.className = 'w3-card-4';
        
        const permissaoCard = document.createElement('div');
        permissaoCard.className = 'w3-card-4';
        permissaoCard.classList.add('w3-margin-bottom');
        permissaoCard.innerHTML = `
            <h2>Gerenciar Permissões</h2>
            <label for="perfilSelect">Perfil:</label>
            <select id="perfilSelect" class="w3-select" required>
                <option value="">Selecione</option>
            </select>
            <button id="addPerfilNova" class="w3-btn w3-tiny w3-border w3-border-green">+</button>
            <br>
            <label for="permissaoSelect">Permissão:</label>
            <select id="permissaoSelect" class="w3-select" required>
                <option value="">Selecione</option>
            </select>
                <button id="addPermissaoNova" class="w3-btn w3-tiny w3-border w3-border-green">+</button>
            <br>
            <button id="addPermissaoBtn" class="w3-button w3-round w3-border w3-border-green">Associar Permissão e Perfil</button>
            
            `;
        const ulx = document.createElement('ul');
        ulx.id = 'permissoesList';
        ulx.className = 'w3-ul';

     
        mainDiv.appendChild(perfilCard);
        permissaoCard.appendChild(ulx);
        mainDiv.appendChild(permissaoCard);

        mainDiv.innerHTML += `
        <div id="addPerfilModal" class="w3-modal">
            <div class="w3-modal-content w3-animate-zoom w3-card-4">
            <header class="w3-container w3-teal"> 
                <span onclick="document.getElementById('addPerfilModal').style.display='none'" 
                class="w3-button w3-display-topright">&times;</span>
                <h4>System X</h4>
            </header>
            <div class="w3-container">
                <input id="novoPerfilNome" type="text" placeholder="Nome do Perfil">
                <button id="savePerfilBtn" class="w3-button">Salvar Perfil</button>
            </div></div>
        </div>
        <div id="addPermissaoModal" class="w3-modal">
            <div class="w3-modal-content w3-animate-zoom w3-card-4">
            <header class="w3-container w3-teal"> 
                <span onclick="document.getElementById('addPermissaoModal').style.display='none'" 
                class="w3-button w3-display-topright">&times;</span>
                <h4>System X</h4>
            </header>
            <div class="w3-container">
                <input id="novaPermissaoNome" type="text" placeholder="Nome da Permissão">
                <button id="savePermissaoBtn" class="w3-button">Salvar Permissão</button>
            </div></div>
        </div>
    `;

        return {
            element: mainDiv,
            init: () => this.init()
        };
    }
}
