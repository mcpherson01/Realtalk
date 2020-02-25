import {
  BuiltInComponent,
} from '../destinationcomponents/builtin/BuiltInComponent';
import { Callable } from '../utilities/Callable';
import { Components } from './finders/Components';
import {
  DestinationComponentsManager,
} from '../destinationcomponents/DestinationComponentsManager';
import { Domain } from './domain/Domain';
import { isObject } from '../utilities/isObject';

export class Destination extends Domain
{
    constructor(data)
    {
        super(data);
        this.instantiateComponentsIfAny(data);
    }

    instantiateComponentsIfAny(data) 
    {
        this.condition = isObject(data.condition)? DestinationComponentsManager.createFromId(data.condition.type, data.condition) : {}; 
        this.target = isObject(data.target)? DestinationComponentsManager.createFromId(data.target.type, data.target) : {};    
    }

    saveComponent(destinationComponent: BuiltInComponent) 
    {
        return (new Components()).saveFromDestination(this, destinationComponent)
                                 .then(Callable.callAndReturnArgument(
                                    response => this.setComponent(destinationComponent, response)
                                  ))
    }

    setComponent = (previousDestinationComponent, response) => {
        this.update(destination => {

            destination.id = response.destination.id;
            destination[previousDestinationComponent.getType()] = DestinationComponentsManager.createFromId(
                                                                        previousDestinationComponent.getId(),
                                                                        response.destination[previousDestinationComponent.getType()]
                                                                    );

        })
        // we'll set the coponent to the destination 
        // then the destination will call update on observers, so the dom will refresh
    }
}