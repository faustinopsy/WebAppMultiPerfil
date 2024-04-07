import BuscaApi from '../lib/BuscaApiG.js';

export default class ConfirmTOken {
    constructor(navigateCallback,data) {
        this.navigate = navigateCallback;
        this.buscaApi = new BuscaApi();
        this.token =  data.token;
        this.user =  data.user;
        this.email = data.email;
    }

    async verificacodigo(cod) {
        const email = this.email;
        try {
            const data = await this.buscaApi.fetchApi('Usuarios/verificacodigo', 'POST', { email: email, codigo: cod });

            if (data.status) {
                Swal.fire("Alerta!","Confirmado", "info");
                sessionStorage.setItem('token', this.token);
                sessionStorage.setItem('user', this.user);
                this.navigate('admin'); 
                location.reload();
            } else {
                this.displayMessage("Falhou: " + data.message);
            }
        } catch (error) {
            console.error('Erro durante a recuperação:', error);
            this.displayMessage("Falhou: " + error.message);
        }
    }

    displayMessage(message) {
        const messageElement = document.getElementById('mensagem');
        if (messageElement) {
            messageElement.innerText = message;
            document.getElementById('id02').style.display = 'block';
        } else {
            Swal.fire("Alerta!",message, "info");
        }
    }

    render() {
        const recoveryContainer = document.createElement('div');
        recoveryContainer.className = 'recovery-container';

        recoveryContainer.innerHTML = `
        <div class="w3-container">
        <div id="id01" class="w3-modal" style="display:block">
          <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
            <form class="w3-container" id="confirmtoken">
                <div class="w3-section">
                    <label for="codigo">Código</label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" id="codigo" placeholder="Insira o Token enviado por email" required />
                </div>
                <div class="w3-section">
                    <button type="submit" class="w3-button w3-block w3-green w3-section w3-padding" id="oonfirmarcodigo">Confirmar Código</button>
                </div>
                <div id="mensagem" class="modal"></div>
            </form>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
              <button class="w3-button w3-right" id="loginButton">Login</button>
            </div>
            </div>
            </div>
            </div>
        `;

        recoveryContainer.querySelector('#confirmtoken').addEventListener('submit', async (e) => {
            e.preventDefault();
            const codigo = recoveryContainer.querySelector('#codigo').value;
            await this.verificacodigo(codigo);
        });
        recoveryContainer.querySelector('#loginButton').addEventListener('click', () => {
            this.navigate('login');
        });
        return {
            element: recoveryContainer,
            init: () => {}
        };
    }
}


