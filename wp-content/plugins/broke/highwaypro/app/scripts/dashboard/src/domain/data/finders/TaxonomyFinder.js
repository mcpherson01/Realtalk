import { Destination } from '../Destination';
import { RemoteFinder } from './RemoteFinder';

export class TaxonomyFinder extends RemoteFinder {
    getByKeyword(keyword) 
    {
        return this.get({
            path: 'terms',
            data: keyword
        });    
    }

    returnOnSuccess(response) 
    {
        const responseObject = this.createObjectFrom(response);

        if (Array.isArray(responseObject.terms)) {

            return responseObject.terms;
        } 

        return [];
    } 
}