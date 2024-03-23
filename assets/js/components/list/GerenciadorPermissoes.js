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
        if(nome ===''){
            Swal.fire("Alerta!", "Digite o nome para o perfil.", "info");
            return;
        }
        const data = await this.buscaApi.fetchApi('Perfil', 'POST', { nome: nome });

        if (data.status) {
            Swal.fire("Sucesso!", "Perfil adicionado com sucesso!", "sucess");
            await this.populatePerfis(); 
            this.addPerfilModal.style.display = 'none';
        } else {
            Swal.fire("Erro!", "Erro ao adicionar perfil!", "info");
        }
    }

    async addPermissao() {
        const nome = this.novaPermissaoNome.value;
        if(nome ===''){
            Swal.fire("Alerta!", "Digite o nome para a permissão.", "info");
            return;
        }
        const data = await this.buscaApi.fetchApi('Permissoes', 'POST', { nome: nome });

        if (data.status) {
            Swal.fire("Sucesso!", "Permissão adicionada com sucesso!", "sucess");
            await this.populateDropdown(); 
            this.addPermissaoModal.style.display = 'none';
        } else {
            Swal.fire("Alerta!", "Erro ao adicionar permissão!", "info");
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
            Swal.fire("Sucesso!", "Associação realizada com sucesso!", "sucess");
        } else {
            Swal.fire("Alerta!", "Erro ao associar permissão", "info");
        }
        return result;
    }
    
    async deleteAssociarPermissao(perfilId, permissaoId) {
        return await this.buscaApi.fetchApi(`Associar/${perfilId}`, 'DELETE', { permissao_id: permissaoId });
    }
    async deletePerfil(perfilId) {
        return await this.buscaApi.fetchApi(`Perfil/${perfilId}`, 'DELETE');
    }
    async deletePermissao(permissaoid) {
        return await this.buscaApi.fetchApi(`Permissoes/${permissaoid}`, 'DELETE');
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
                                Swal.fire("Sucesso!", "Permissão removida com sucesso!", "sucess");
                                li.remove(); 
                            } else {
                                Swal.fire("Alerta!", "Erro ao remover permissão", "info");
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

        const removePerfilBtn = document.getElementById('removeperfil'); 
        const removePermissaoBtn = document.getElementById('removepermissao'); 

        removePerfilBtn.addEventListener('click', async () => {
            const perfilId = document.getElementById('perfilSelect').value;
            if(perfilId ==='' ){
                Swal.fire("Alerta!", "Selecione um perfil", "info");
                return;
            }
            const result = await this.deletePerfil(perfilId);
            if(result.status){
                Swal.fire("Sucesso!", result.message, "sucess");
            }
        });
        removePermissaoBtn.addEventListener('click', async () => {
            const permissaoid = document.getElementById('permissaoSelect').value;
            if(permissaoid ==='' ){
                Swal.fire("Alerta!", "Selecione uma permissão", "info");
                return;
            }
            const result = await this.deletePermissao(permissaoid);
            if(result.status){
                Swal.fire("Sucesso!", result.message, "sucess");
                setInterval(this.atualizarPagina, 1500);
            }
        });


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
                Swal.fire("Alerta!", "Selecione um perfil e uma permissão!", "info");
                return;
            }
            await this.addAssociarPermissao(perfilId, permissaoId);
        });
        
        document.getElementById('perfilSelect').addEventListener('change', async (event) => {
            await this.populatePermissoesList(event.target.value);
        });
    }
    

    atualizarPagina() {
        location.reload();
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
        document.getElementById('titulo').innerHTML='Gerir Permissões';
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
            <button id="addPerfilNova" class="w3-btn w3-tiny w3-border w3-green" title="Novo perfil">+</button>
            <button id="removeperfil" class="w3-btn w3-tiny w3-border w3-red" title="Remover perfil">-</button>
            <br>
            <label for="permissaoSelect">Permissão:</label>
            <select id="permissaoSelect" class="w3-select" required>
                <option value="">Selecione</option>
            </select>
                <button id="addPermissaoNova" class="w3-btn w3-tiny w3-border w3-green" title="Nova Permissão">+</button>
                <button id="removepermissao" class="w3-btn w3-tiny w3-border w3-red" title="Remover Permissão">-</button>
                <br>
            <button id="addPermissaoBtn" class="w3-btn w3-tiny w3-border w3-green w3-block w3-hover-black",">Associar Permissão e Perfil</button>
            
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
                <label for="perfilSelect">Perfil:</label>
                <input id="novoPerfilNome" type="text" class="w3-input" placeholder="Nome do Perfil">
                <button id="savePerfilBtn" class="w3-button w3-block w3-green w3-hover-black">Salvar Perfil</button>
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
                <label for="perfilSelect">Permissão:</label>
                <input id="novaPermissaoNome" type="text" class="w3-input" placeholder="Nome da Permissão">
                <button id="savePermissaoBtn" class="w3-button w3-block w3-green w3-hover-black">Salvar Permissão</button>
            </div></div>
        </div>
    `;

        return {
            element: mainDiv,
            init: () => this.init()
        };
    }
}
