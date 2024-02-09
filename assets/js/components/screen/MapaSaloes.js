import BuscaApi from '../lib/BuscaApiG.js';
export default class MapaSaloes {
    constructor(navigateCallback) {
        this.navigate = navigateCallback;
        this.buscaApi = new BuscaApi(sessionStorage.getItem('token'));
        this.mapa = null; 
        this.navbar = null;
        this.init();
    }

    async init() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => this.showPosition(position),
                error => this.showError(error)
            );
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    async showPosition(position) {
        this.mapa = L.map('mapid').setView(
            [position.coords.latitude, position.coords.longitude],
            15  
        );
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(this.mapa);

        L.marker([position.coords.latitude, position.coords.longitude]).
        addTo(this.mapa).bindPopup(`<b>Estou</b><br>Aqui`);
        L.circle([position.coords.latitude, position.coords.longitude], {
            color: "green",
            fillColor: "#eeff",
            fillOpacity: 0.5,
            radius: 3000,
          }).addTo(this.mapa).bindPopup(`<b> raio 3 km</b>`);
          L.circle([position.coords.latitude, position.coords.longitude], {
            color: "red",
            fillColor: "#f03",
            fillOpacity: 0.5,
            radius: 1000,
          }).addTo(this.mapa).bindPopup(`<b> raio 1 km</b>`);
        
        await this.buscaSaloesGEO(position);
    }

    async buscaSaloesGEO(position) {
        let lat = position.coords.latitude.toFixed(5);
        let long = position.coords.longitude.toFixed(5);
        let query = `Enderecos/geo?lat=${encodeURIComponent(lat)}&long=${encodeURIComponent(long)}`;
    
        try {
            const data = await this.buscaApi.fetchApi(query, 'GET');
            this.renderSaloes(data);
        } catch (error) {
            console.error(error);
        }
    }
    
    renderSaloes(grupoSalao) {
        if (!grupoSalao || !grupoSalao.length) return;
            grupoSalao.forEach(salao => {
                L.marker([salao.latitude, salao.longitude]).addTo(this.mapa).bindPopup(`<b>${salao.nome}</b><br>${salao.cidade}`);
            });
        
    }
    
    showError(error) {
        alert(`Geolocation error: ${error.message}`);
    }

    render() {
        document.getElementById('titulo').innerHTML='Salões próximos a você';
        const menuContainer = document.createElement('div');
        menuContainer.className = 'main';

        const mapid = document.createElement('div');
        mapid.id = 'mapid';
        mapid.style.zIndex = '99999'
        mapid.style.height= '400px'; 
        mapid.style.width= '400px'; 
        mapid.style.position= 'absolute';
        mapid.style.marginLeft= "15px"

 
        menuContainer.appendChild(mapid); 
        return {
            element: menuContainer,
            init: () => {}
        };
    }
}


