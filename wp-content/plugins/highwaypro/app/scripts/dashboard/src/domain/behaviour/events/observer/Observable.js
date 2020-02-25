import { Observer } from './Observer';

export class Observable {
    observers = [];
    observersWithKeys = {};
    updateParameters = [];

    static getProperties() 
    {
        return [
            'observers',
            'observersWithKeys',
            'updateParameters',
        ]
    }

    add(observer: Observer) 
    {
        this.observers.push(observer);
    }

    addOnce(key, observer)
    {
        if (!Object.keys(this.observersWithKeys).includes(key)) {
            this.observersWithKeys[key] = observer;
        }
    }

    update(callable) 
    {
        callable(this); 
        
        this.notify();       
    }
    
    notify() 
    {
        this.getAllObservers().forEach(observer => {
            observer.update(...this.updateParameters);
        });
    }

    getAllObservers() 
    {
        const observersWithKeys = [];

        for (let key in this.observersWithKeys) {
            observersWithKeys.push(this.observersWithKeys[key]);
        }

        return [].concat(this.observers).concat(observersWithKeys);
    }
}