import {
  BuiltInComponent,
} from '../../destinationcomponents/builtin/BuiltInComponent';
import { RemoteFinder } from './RemoteFinder';

export class Components extends RemoteFinder {
    saveFromDestination(destination, component: BuiltInComponent) {
        return this.post({
            path: `destinations/${component.getTypePlural()}/set`,
            data: {
                url: {
                    id: destination.url_id
                },
                destination: {
                    id: destination.id,
                    [component.getType()]: {
                        id: component.data.id,
                        type: component.getId(),
                        parameters: component.getParametersAsJson()   
                    }
                }
            }
        });   
    }

    returnOnSuccess(response) 
    {
        const responseObject = this.createObjectFrom(response);


        return responseObject;
    } 
}