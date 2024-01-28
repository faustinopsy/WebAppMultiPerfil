import BuscaApi from './BuscaApiG.js';

export default class HeatmapComponent {
    constructor() {
        this.buscaApi = new BuscaApi(sessionStorage.getItem('token'));
        this.heatmapData = [];
        this.switchElement = null;
        this.heatmapContainerDesktop = null;
        this.heatmapContainerMobile = null;
        this.heatmapInstance = null;
    }

    init() {
        this.fetchHeatmapData();
        this.setupSwitchListener();
    }

    async fetchHeatmapData() {
        try {
            const data = await this.buscaApi.fetchApi('Analitico', 'GET');
            this.heatmapData = data;
            this.displayHeatmap(this.heatmapData, this.heatmapContainerDesktop, "0");
        } catch (error) {
            console.error('Error:', error);
        }
    }

    setupSwitchListener() {
        this.switchElement.addEventListener('change', this.toggleHeatmapDisplay.bind(this));
    }

    toggleHeatmapDisplay() {
        const isMobile = this.switchElement.checked;
        if (isMobile) {
            this.heatmapContainerMobile.style.display = 'block';
            this.heatmapContainerDesktop.style.display = 'none';
            this.displayHeatmap(this.heatmapData, this.heatmapContainerMobile, "1");
        } else {
            this.heatmapContainerDesktop.style.display = 'block';
            this.heatmapContainerMobile.style.display = 'none';
            this.displayHeatmap(this.heatmapData, this.heatmapContainerDesktop, "0");
        }
    }
    

    displayHeatmap(data, container, isMobile) {
        //if (!this.heatmapInstance) {
            this.heatmapInstance = h337.create({
                container: container,
                backgroundColor: 'rgba(0,0,0,.95)',
                maxOpacity: .9,
                minOpacity: .01
            });
       // }
    
        const filteredData = data.filter(item => String(item.isMobile) === String(isMobile));
        console.log(filteredData)
        const points = filteredData.map(item => {
            const containerWidth = container.offsetWidth;
            const containerHeight = container.offsetHeight;
            return {
                x: Math.round(item.x * (containerWidth / parseInt(item.screenWidth))),
                y: Math.round(item.y * (containerHeight / parseInt(item.screenHeight))),
                value: 1
            };
        });
    
        if (points.length === 0) {
            console.log("Nenhum ponto para exibir no heatmap.");
            return;
        }
    
        this.heatmapInstance.setData({ max: Math.max(...points.map(p => p.value)), data: points });
    }
    

    render() {
        const mainDiv = document.createElement('div');
        mainDiv.className = 'main';

        const toggleSwitchDiv = document.createElement('div');
        toggleSwitchDiv.className = 'toggle-switch';

        this.switchElement = document.createElement('input');
        this.switchElement.type = 'checkbox';
        this.switchElement.id = 'switch';
        this.switchElement.className = 'toggle-switch-checkbox';
        this.switchElement.name = 'switch';

        const label = document.createElement('label');
        label.className = 'toggle-switch-label';
        label.htmlFor = 'switch';

        const innerSpan = document.createElement('span');
        innerSpan.className = 'toggle-switch-inner';

        const switchSpan = document.createElement('span');
        switchSpan.className = 'toggle-switch-switch';

        label.appendChild(innerSpan);
        label.appendChild(switchSpan);

        toggleSwitchDiv.appendChild(this.switchElement);
        toggleSwitchDiv.appendChild(label);

        this.heatmapContainerDesktop = document.createElement('div');
        this.heatmapContainerDesktop.id = 'heatmapContainerDesktop';
        this.heatmapContainerDesktop.style.display = 'block';

        this.heatmapContainerMobile = document.createElement('div');
        this.heatmapContainerMobile.id = 'heatmapContainerMobile';
        this.heatmapContainerMobile.style.display = 'none';

        const container = document.createElement('div');
        container.appendChild(toggleSwitchDiv);
        container.appendChild(this.heatmapContainerDesktop);
        container.appendChild(this.heatmapContainerMobile);

        mainDiv.appendChild(container);
        return {
            element: mainDiv,
            init: () => this.init()
        };
    }
}


