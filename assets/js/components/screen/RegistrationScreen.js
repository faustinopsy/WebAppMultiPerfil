import BuscaApi from '../lib/BuscaApiG.js';

export default class RegistrationScreen {
    constructor(navigateCallback) {
        this.navigate = navigateCallback;
        this.buscaApi = new BuscaApi();
    }

    async register(nome, email, senha) {
        try {
            const usuario = { nome, email, senha };
            const data = await this.buscaApi.fetchApi('Usuarios/Registrar', 'POST', usuario);

            if (data.status) {
                this.displayMessage('Usuário registrado com sucesso!');
            } else {
                this.displayMessage('Erro ao registrar o usuário.');
            }
        } catch (error) {
            console.error('Erro ao registrar:', error);
            this.displayMessage('Erro ao registrar o usuário.');
        }
    }

    displayMessage(message) {
        const messageElement = document.getElementById('message');
        messageElement.textContent = message;
    }

    render() {
        const registrationContainer = document.createElement('div');
        registrationContainer.className = 'registration-container';

        registrationContainer.innerHTML = `
        <div class="w3-container">
      
        <div id="id01" class="w3-modal" style="display:block">
          <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
            <form class="w3-container" id="registrationForm">
                <div class="w3-section">
                    <label for="nome">Nome</label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" id="nome" placeholder="Insira o Nome" required />
                </div>
                <div class="w3-section">
                    <label for="email">E-mail</label>
                    <input class="w3-input w3-border w3-margin-bottom" type="email" id="email" placeholder="Insira o E-mail" required />
                </div>
                <div class="w3-section">
                    <label for="senha">Senha</label>
                    <input class="w3-input w3-border w3-margin-bottom" type="password" id="senha" placeholder="Insira a senha" required />
                </div>
                <div class="w3-section">
                    <label for="resenha">Digite novamente a senha</label>
                    <input class="w3-input w3-border w3-margin-bottom" type="password" id="resenha" placeholder="Repita a senha" required />
                </div>
                <button type="submit" class="w3-button w3-block w3-green w3-section w3-padding">Registrar</button>
                <p id="message"></p>
            </form>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
              <button class="w3-button w3-right" id="loginButton">Login</button>
            </div>
            </div>
            </div>
            </div>
        `;

       
        registrationContainer.querySelector('#registrationForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const nome = registrationContainer.querySelector('#nome').value;
            const email = registrationContainer.querySelector('#email').value;
            const senha = registrationContainer.querySelector('#senha').value;
            const resenha = registrationContainer.querySelector('#resenha').value;

            if (senha !== resenha) {
                this.displayMessage("As senhas estão diferentes");
                return;
            }

            await this.register(nome, email, senha);
        });

         registrationContainer.querySelector('#loginButton').addEventListener('click', () => {
             this.navigate('login');
         });

        return {
            element: registrationContainer,
            init: () => {}
        };
    }
}

