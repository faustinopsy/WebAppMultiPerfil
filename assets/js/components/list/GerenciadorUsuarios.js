import BuscaApi from '../lib/BuscaApiG.js';

export default class GerenciadorUsuarios {
    constructor() {
        this.buscaApi = new BuscaApi(sessionStorage.getItem('token'));
    }

    async init() {
        await this.buscaUsers();
    }
    async inativeUsuario(email,chk) {
        return await this.buscaApi.fetchApi(`Usuarios`, 'PUT', { email,chk });
    }
    async deleteUsuario(email) {
        return await this.buscaApi.fetchApi(`Usuarios`, 'DELETE', { email });
    }

    async buscaUsers() {
        try {
            const data = await this.buscaApi.fetchApi(`Usuarios`, 'GET');
            this.renderUsers(data.Usuarios);
        } catch (error) {
            console.error(error);
            
        }
    }
    
    renderUsers(usuarios) {
        const divUser = document.querySelector('.main');

        usuarios.forEach(usuario => {
            const container = document.createElement("div");
            container.classList.add("w3-card-4");
            container.innerHTML = `
                <div class="w3-container">
                    <h3>Dados no banco</h3>
                    <p>Id: ${usuario.id}</p>
                    <h3>Nome: ${usuario.nome}</h3>
                    <p>Email: ${usuario.email}</p>
                </div>
                
            `;
            const switchLabel = document.createElement('label');
            switchLabel.classList.add('switch');

            const ativeBtn = document.createElement('input');
            ativeBtn.id = "myCheck";
            ativeBtn.type = "checkbox";
            if(usuario.ativo===2){
                ativeBtn.checked = true
            }
            ativeBtn.addEventListener('click', async () => {
                if (ativeBtn.checked) {
                    const result = await this.inativeUsuario(usuario.email,2);
                    alert('Usuário bloqueado com sucesso!');
                } else {
                    const result = await this.inativeUsuario(usuario.email,1);
                    alert('Usuário Ativado.');
                }
            });

            const sliderSpan = document.createElement('span');
            sliderSpan.classList.add('slider', 'round');

            switchLabel.appendChild(ativeBtn);
            switchLabel.appendChild(sliderSpan);

            container.appendChild(switchLabel);

            const removeBtn = document.createElement('button');
            removeBtn.textContent = "Remover";
            removeBtn.classList.add("w3-button", "w3-border", "w3-hover-black");
            removeBtn.addEventListener('click', async () => {
                const result = await this.deleteUsuario(usuario.email);
                if (result.status) {
                    alert('Usuário removido com sucesso!');
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

