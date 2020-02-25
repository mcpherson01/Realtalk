export class Observer {
    handler;

    constructor(handler) { 
        this.handler = handler;
    }

    update(...parameters) {
        this.handler(...parameters);
    }
}