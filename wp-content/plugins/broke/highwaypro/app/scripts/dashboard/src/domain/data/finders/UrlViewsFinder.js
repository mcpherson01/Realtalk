import { RemoteFinder } from './RemoteFinder';

export class UrlViewsFinder extends RemoteFinder {
    getStatsForAllUrls() 
    {
        return this.get({
            path: 'url/statistics'
        });  
    }

    getByUrlId(urlId) 
    {
        return this.get({
            path: 'url/statistics',
            data: {
                url: {
                    id: urlId
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