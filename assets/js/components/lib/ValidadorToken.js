import BuscaApi from './BuscaApiG.js';
import Navbar from '../Navbar.js';
export default class ValidadorToken {
    constructor(navigateCallback,userLanguage) {
        this.navigate = navigateCallback;
        this.buscaApi = new BuscaApi(sessionStorage.getItem('token'));
        this.token = sessionStorage.getItem('token');
        this.navbar = null;
        this.userLanguage = userLanguage;
    }

    async init() {
        if (!this.token) {
            this.redirecioneLogin();
        } else {
            await this.validaToken();
            setInterval(() => this.validaToken(), 10000);
        }
    }

    async validaToken() {
        if (this.navbar) {
            this.navbar.updatePermitidas(this.telasPermitidas);
        }
        try {
            const data = await this.buscaApi.fetchApi('token', 'GET');
            if(data.status) {
                this.telasPermitidas = data.telas; 
                this.initializeNavbar();
            } else {
                this.redirecioneLogin();
            }
            
        } catch (error) {
            console.error("Erro ao validar token:", error);
            this.redirecioneLogin();
        }
    }
    initializeNavbar() {
        if (!this.navbar) {
            this.navbar = new Navbar(this.navigate, this.telasPermitidas);
            const navbarElement = this.navbar.render();
            document.body.insertBefore(navbarElement, document.getElementById('app'));
            this.navbar.init();
        } else {
            this.navbar.updatePermitidas(this.telasPermitidas);
        }
    }
    redirecioneLogin() {
        this.navigate('login');
    }
}


