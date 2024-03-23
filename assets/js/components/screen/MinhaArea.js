import BuscaApi from '../lib/BuscaApiG.js';

export default class MinhaArea {
    constructor() {
        this.buscaApi = new BuscaApi(sessionStorage.getItem('token'));
        this.usuario_perfil = sessionStorage.getItem('user');
    }

    async init() {
        await this.buscaUser(this.usuario_perfil);
        this.iniciaTrocaSenha();
    }
    
    async buscaUser() {
        try {
            const data = await this.buscaApi.fetchApi(`Usuarios/${this.usuario_perfil}`, 'GET');
            this.renderUsers(data.Usuario);
        } catch (error) {
            console.error(error);
            
        }
    }
    async trocarSenha(email,senha, resenha){
        try {
            const data = await this.buscaApi.fetchApi(`Usuarios/trocasenha`,  'PUT', { email: email, senha: senha, resenha: resenha });
            return data;
        } catch (error) {
            console.error(error);
            
        }
    }
    renderUsers(usuario) {
        const divUser = document.querySelector('.main');
            this.usuario_perfil= usuario.perfilid;
            const container = document.createElement("div");
            container.classList.add("w3-card-4");
            container.innerHTML = `
                <div class="w3-container">
                    <h3>Dados no banco</h3>
                    <p>Id: ${usuario.id}</p>
                    <h3>Nome: ${usuario.nome}</h3>
                    <p id="emailcard" data-email="${usuario.email}">Email: ${usuario.email}</p>
                </div>
                <div class="w3-section">
                    <label for="senha">Senha antiga</label>
                    <input class="w3-input w3-border w3-margin-bottom" type="password" id="senha" placeholder="Digite a senha antiga" required />
                </div>
                <div class="w3-section">
                    <label for="resenha">Senha nova</label>
                    <input class="w3-input w3-border w3-margin-bottom" type="password" id="resenha" placeholder="Digite a nova senha" required />
                </div>
                <button type="submit" class="w3-button w3-block w3-green w3-section w3-padding">Alterar a senha</button>
                <p id="message"></p>
            `;
            
            divUser.appendChild(container);  
            
    }
    iniciaTrocaSenha(){
        const button = document.querySelector('.w3-button'); 
        button.addEventListener('click', async () => {
            const email = document.getElementById("emailcard").dataset.email; 
            const senha = document.getElementById('senha').value; 
            const resenha = document.getElementById('resenha').value; 
            const result = await this.trocarSenha(email, senha, resenha);
            if (result && result.status) { 
                Swal.fire("Sucesso!", `${result.message}`, "success"); 
            } else {
                Swal.fire("Erro!", `Não foi possível alterar a senha ${result.message}`, "error");
            }
        });
    }
    
    render() {
        document.getElementById('titulo').innerHTML='Meu espaço';
        const mainDiv = document.createElement('div');
        mainDiv.className = 'main';
        return {
            element: mainDiv,
            init: () => this.init()
        };
    }
}

