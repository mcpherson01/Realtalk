import { Destination } from '../Destination';
import { RemoteFinder } from './RemoteFinder';

export class PostsFinder extends RemoteFinder {
    getByKeyword(keyword) 
    {
        return this.get({
            path: 'posts',
            data: keyword
        });    
    }

    returnOnSuccess(response) 
    {
        const responseObject = this.createObjectFrom(response);

        if (Array.isArray(responseObject.posts)) {

            return responseObject.posts;
        } 

        return [];
    } 
}