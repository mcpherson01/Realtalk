import { Callable } from '../../utilities/Callable';
import { Events } from '../../behaviour/events/events/Events';
import { RemoteFinder } from './RemoteFinder';
import { Url } from '../Url';

export class Urls extends RemoteFinder {
    static urls = [];

    getFromMemoryWithId(urlId) 
    {
        return Urls.urls.filter(url => url.id === urlId)[0];
    }

    getAll() {
        return this.get({path: 'urls'});
    }

    getAllWithTypeId(typeId) 
    {
        return this.get({
            path: 'urls',
            data: {
                filters: {
                    urlType: {
                        id: typeId
                    }
                }
            }
        });
    }

    create(urlData) 
    {
        return this.post({
            path: 'urls/new',
            data: {
                url: urlData
            }
        })
    }

    update(data)
    {
        return this.post({
            path: 'urls/edit',
            data: {
                url: {
                    id: data.id,
                    [data.field.name]: data.field.value
                },
                fieldToUpdate: data.field.name
            }
        })
        .then(Callable.callAndReturnArgument((response) => {
            Events.call('urls.afterUpdate', response.urls)   
        }));
    }

    validateResponse(response) 
    {
        return super.validateResponse(response);
    }   

    returnOnSuccess(response) 
    {
        const responseObject = this.createObjectFrom(response);

        if (Array.isArray(responseObject.urls)) {
            responseObject.urls = responseObject.urls.map(url => new Url(url));            
            Urls.urls = responseObject.urls;
        }

        return responseObject;
    } 
}