import BuscaApi from './BuscaApiG.js';

export default class MouseMovementTracker {
    constructor() {
        this.buscaApi = new BuscaApi(sessionStorage.getItem('token'));
        this.isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        this.screenSize = {
            width: window.innerWidth,
            height: window.innerHeight
        };
        this.mouseMovements = [];
        this.visitorId = this.generateUniqueId();
    }

    init() {
        document.addEventListener('DOMContentLoaded', () => {
            document.addEventListener('mousemove', this.handleMouseMove.bind(this));
            setInterval(() => this.sendDataToServer(), 33000);
        });
    }

    handleMouseMove(event) {
        this.mouseMovements.push({
            x: event.pageX,
            y: event.pageY,
            time: Date.now(),
            visitor_id: this.visitorId,
            isMobile: this.isMobile,
            screenSize: this.screenSize
        });

        if (this.mouseMovements.length >= 50) {
            this.mouseMovements.shift();
        }
    }

    async sendDataToServer() {
        if (this.mouseMovements.length > 0) {
            try {
                const response = await this.buscaApi.fetchApi('Analitico', 'POST', this.mouseMovements);
                console.log('Success:', response);
            } catch (error) {
                console.error('Error:', error);
            }
            this.mouseMovements = [];
        }
    }

    generateUniqueId() {
        return 'visitor-' + Math.random().toString(36).substr(2, 9);
    }
}

const mouseTracker = new MouseMovementTracker();
mouseTracker.init();
