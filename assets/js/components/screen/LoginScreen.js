import BuscaApi from '../lib/BuscaApiG.js';

export default class LoginScreen {
    constructor(navigateCallback) {
        this.navigate = navigateCallback;
        this.buscaApi = new BuscaApi();
    }

    async login(email, password, lembrar) {
        try {
            const data = await this.buscaApi.fetchApi('Usuarios/login', 'POST', { email, senha: password, lembrar });
            if (data.status) {
                data.email = email;
                this.navigate('confirmatoken',data); 
                //location.reload();
            } else {
                this.displayMessage("Login falhou:\n " + data.message);
            }
        } catch (error) {
            console.error('Erro durante o login:', error);
            this.displayMessage("Erro durante o login: " + error.message);
        }
    }

    displayMessage(message) {
        const messageElement = document.getElementById('mensagem');
        if (messageElement) {
            messageElement.innerText = message;
            document.getElementById('id02').style.display = 'block';
        } else {
            Swal.fire("Sucesso!", message, "sucess");
        }
    }

    render() {
        const loginContainer = document.createElement('div');
        loginContainer.className = 'login-container';

        loginContainer.innerHTML = `
        <div class="w3-container">
        <div id="id01" class="w3-modal" style="display:block">
          <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
            <form class="w3-container" id="loginForm">
                <div class="w3-section">
                    <label for="email">E-mail</label>
                    <input class="w3-input w3-border w3-margin-bottom" type="email" id="email" placeholder="Insira o E-mail" required />
                </div>
                <div class="w3-section">
                    <label for="senha">Senha</label>
                    <input class="w3-input w3-border w3-margin-bottom" type="password" id="senha" placeholder="Insira a senha" required />
                </div>
                <div class="w3-section">
                    <input class="w3-check w3-margin-top" type="checkbox" id="lembrar" />
                    <label for="lembrar">Lembrar-me</label>
                </div>
                <button type="submit" class="w3-button w3-block w3-green w3-section w3-padding" id="login">Entrar</button>
            </form>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button class="w3-button w3-right" id="cadastrar">Cadastrar-se</button>
                <button class="w3-button w3-right" id="esqueciSenha">Esqueci a senha</button>
             </div>
            <div id="id02" class="w3-modal">
                <div class="w3-modal-content w3-animate-zoom w3-card-4">
                <header class="w3-container w3-teal"> 
                    <span onclick="document.getElementById('id02').style.display='none'" 
                    class="w3-button w3-display-topright">&times;</span>
                    <h4>System X</h4>
                </header>
                <div class="w3-container">
                    <p id="mensagem"></p>
                </div>
                
                </div>
            </div>
            </div>
            </div>
            </div>
            
          
        `;

        
        loginContainer.querySelector('#loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = loginContainer.querySelector('#email').value;
            const password = loginContainer.querySelector('#senha').value;
            const lembrar = loginContainer.querySelector('#lembrar').checked;
            await this.login(email, password, lembrar);
        });

        loginContainer.querySelector('#cadastrar').addEventListener('click', () => {
            this.navigate('cadastro'); 
        });

        loginContainer.querySelector('#esqueciSenha').addEventListener('click', () => {
            this.navigate('recuperarSenha'); 
        });

        return {
            element: loginContainer,
            init: () => {}
        };
    }
}
