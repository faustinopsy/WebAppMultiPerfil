import BuscaApi from '../lib/BuscaApiG.js';

export default class MinhaArea {
    constructor() {
        this.token = sessionStorage.getItem('token')
        this.buscaApi = new BuscaApi(this.token);
        const payload = JSON.parse(atob(this.token.split('.')[1]));
        this.usuario_perfil = payload.sub;
    }

    async init() {
        await this.buscaUser();
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
    async twofaUsuario(email,chk) {
        return await this.buscaApi.fetchApi(`Usuarios/twofaUsuario`, 'PUT', { email, chk });
    }
    renderUsers(usuario) {
        const divUser = document.querySelector('.main');
            this.usuario_perfil= usuario.perfilid;
            const container = document.createElement("div");
            container.classList.add("w3-card-4");
            container.innerHTML = `
                <div class="w3-container">
                    <h3>Dados no banco</h3>
                    <h4>Nome: ${usuario.nome}</h4>
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
            const switchLabel = document.createElement('label');
            switchLabel.classList.add('switch');
            const ativeBtn = document.createElement('input');
            ativeBtn.id = "myCheck";
            ativeBtn.type = "checkbox";
            if(usuario.twofactor===1){
                ativeBtn.checked = true
            }
            ativeBtn.addEventListener('click', async () => {
                if (ativeBtn.checked) {
                    const result = await this.twofaUsuario(usuario.email, 1);
                    Swal.fire("Sucesso!", "2fa-email Ativado!", "sucess");
                } else {
                    const result = await this.twofaUsuario(usuario.email, 0);
                    Swal.fire("Sucesso!", "2fa-email Desativado ", "sucess");
                }
            });
            const hr = document.createElement('hr');
            const span = document.createElement('span');
            span.innerText = "2fa-email"
            const sliderSpan = document.createElement('span');
            sliderSpan.classList.add('slider', 'round');
            switchLabel.appendChild(ativeBtn);
            switchLabel.appendChild(sliderSpan);
            container.appendChild(hr);
            container.appendChild(span);
            container.appendChild(switchLabel);
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

