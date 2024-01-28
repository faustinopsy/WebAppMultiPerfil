class MouseTrackerSDK {
    constructor(options) {
        this.options = options;
        this.mouseMovements = [];
        this.init();
    }

    init() {
        document.addEventListener('mousemove', this.trackMouseMovement.bind(this));
        setInterval(this.sendDataToServer.bind(this), this.options.sendInterval || 10000);
    }

    trackMouseMovement(event) {
        const movementData = {
            x: event.pageX,
            y: event.pageY,
            timestamp: Date.now()
        };

        if (this.options.elementSelector && !event.target.matches(this.options.elementSelector)) {
            return;
        }

        this.mouseMovements.push(movementData);

        if (this.mouseMovements.length > this.options.bufferSize) {
            this.mouseMovements.shift();
        }
    }

    sendDataToServer() {
        if (this.mouseMovements.length === 0) {
            return;
        }

        const dataToSend = {
            movements: this.mouseMovements,
            siteKey: this.options.siteKey 
        };

        fetch(this.options.endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${this.options.apiToken}` 
            },
            body: JSON.stringify(dataToSend)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Data sent successfully', data);
            this.mouseMovements = []; 
        })
        .catch(error => {
            console.error('Error sending data:', error);
        });
    }
}

window.MouseTrackerSDK = MouseTrackerSDK;
