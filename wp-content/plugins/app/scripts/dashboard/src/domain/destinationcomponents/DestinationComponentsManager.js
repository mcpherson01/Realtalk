import { BuiltInComponent } from './builtin/BuiltInComponent';
import { BuiltInComponents } from './BuiltInComponents';
import { EmptyBuiltInComponent } from './builtin/EmptyBuiltInComponent';
import { clone } from '../utilities/clone';
import { isObject } from '../utilities/isObject';

export class DestinationComponentsManager {
    type;
    Static = DestinationComponentsManager;

    static eventsFired = [];
    static registrationEventHasBeenFired = false;

    static components = {
        conditions: [],
        targets: []
    };

    instances = [];

    static() 
    {
        return DestinationComponentsManager;    
    }

    static createFromId(id, data)
    {
        let Component = DestinationComponentsManager.getComponentClassById(id);
        if (typeof Component !== 'function') {
            Component = EmptyBuiltInComponent;
        }
        
        return new Component(data);
    }

    constructor(type) {
        this.typeSingular = type;
        this.type = `${type}s`;

        this.callRegistrationEvent(); 
    }

    static getComponentClassById(id)
    {
        return DestinationComponentsManager.getComponentsAsList().filter(component => {
            return component.getIdStatic() === id;
        })[0];
    }

    static getComponentsAsList()
    {
        return clone(DestinationComponentsManager.components.conditions).concat(DestinationComponentsManager.components.targets);
    }

    get() {
        return DestinationComponentsManager.components[this.type];
    }

    getAll(component: BuiltInComponent) 
    {
        this.instances = this.get().map(componentElement => {
            if (componentElement !== component.constructor) {
                // We'll set the id to other components so that they can be updated
                // because the id of the current component is needed for the update 
                return new componentElement({id: isObject(component.data)? component.data.id : 0})
            }

            return component;
        });

        return this.instances;    
    }

    getByType(type) 
    {
        return this.instances.filter(componentElement => componentElement.getId() === type)[0];    
    }

    register = (component) => {
        this.static().components[`${component.type}s`].push(component);
    }

    callRegistrationEvent = () => {
        if (this.static().registrationEventHasBeenFired) {
            return;
        }

        BuiltInComponents();

        window.dispatchEvent(new CustomEvent('HighwayProRegisterComponent', {
            detail: {
                registrator: this
            }
        }));

        this.static().registrationEventHasBeenFired = true;
    }

    getTypeUpperCased = () => {
        return this.typeSingular.charAt(0).toUpperCase() + this.typeSingular.slice(1);
    }
}