import { RemoteFinder } from './RemoteFinder';
import { UrlExtra } from '../UrlExtra';
import { UrlExtraRepository } from '../UrlExtraRepository';

export class UrlExtraFinder extends RemoteFinder {
    constructor(url: Url) 
    {
        super();

        this.url = url;
    }

    getForUrl() 
    {
        return this.get({
            path: 'url/extra',
            data: {
                url: {
                    id: this.url.id
                }
            }
        });    
    }

    update({extraId, field, entity}) 
    {
        return this.post({
            path: 'urls/extra/edit',
            data: {
                url: {
                    id: entity.url_id
                },
                'urlExtra': { 
                    'value': entity.getExportedValue(field.name)
                },
                fieldToUpdate: field.name
            }
        });
    }

    returnOnSuccess(response) 
    {
        const responseObject = this.createObjectFrom(response);

        if (Array.isArray(responseObject.urlExtras)) {
            return new UrlExtraRepository(responseObject.urlExtras, this.url);
        } else {
            responseObject.urlExtra = new UrlExtra(responseObject.urlExtra);

            return responseObject;
        }
    } 
}