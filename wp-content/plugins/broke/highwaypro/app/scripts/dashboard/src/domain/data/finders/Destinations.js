import { Destination } from '../Destination';
import { RemoteFinder } from './RemoteFinder';

export class Destinations extends RemoteFinder {
    static destinations = [
        {
            id: 1, 
            url_id: 8,
            position: 1,
            'condition': {
                'id': 30,
                'destination_id': 200,
                'type': 'HighwayPro.DeviceCondition',
                'parameters': '',
                'name': 'Country',
                'value': 'Mexico, Canada, United States'
            },
            'target': {
                'id': 90,
                'destination_id': 200,
                'type': 'HighwayPro.PostTarget',
                'parameters': '',
                'name': 'Post: How America got an impressive...',
                'value': 'http://neblabs.com/how-to-create-a-post'
            },
        },
        {
            id: 2, 
            url_id: 1,
            position: 2,
            condition: null,
            target: null
        },
    ];

    getByUrlId(urlId) 
    {
        return this.get({
            path: 'url/destinations',
            data: {
                url: {
                    id: urlId
                }
            }
        });    
    }

    saveNewWithUrlId(urlId) {
        return this.post({
            path: 'destinations/new',
            data: {
                url: {
                    id: urlId
                }
            }
        });   
    }

    deleteWithId(destinationId) {
        return this.post({
            path: 'destinations/delete',
            data: {
                destination: {
                    id: destinationId
                }
            }
        });   
    }

    returnOnSuccess(response) 
    {
        const responseObject = this.createObjectFrom(response);

        if (Array.isArray(responseObject.destinations)) {
            responseObject.destinations = responseObject.destinations.map(destination => new Destination(destination));            
        } 
        if (responseObject.destination) {
            responseObject.destination = new Destination(responseObject.destination);
        }

        return responseObject;
    } 
}