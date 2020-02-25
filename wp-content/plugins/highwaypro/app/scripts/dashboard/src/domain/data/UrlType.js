import { Callable } from '../utilities/Callable';
import { Domain } from './domain/Domain';
import { UrlTypes } from './finders/UrlTypes';
import { Urls } from './finders/urls';

export class UrlType extends Domain
{
    static getName = () => 'UrlType';

    urlsHaveBeenLoaded = false;
    loadedUrls = [];
    
    static getFinder() 
    {
        if (!(UrlType.finder instanceof UrlTypes)) {
            UrlType.finder = new UrlTypes;
        }

        return UrlType.finder;    
    }

    constructor(parameters)
    {
        super(parameters);

        UrlType.getFinder();
        UrlType.urlsFinder = new Urls;
    }

    hasNotLoadedUrls() 
    {
        return !this.urlsHaveBeenLoaded;       
    }

    setLoadedUrls = (response) => 
    {
        this.urlsHaveBeenLoaded = true;
        this.loadedUrls = response.urls || [];
    }

    getUrls() 
    {
        return this.constructor.urlsFinder.getAllWithTypeId(this.id)
                                          .then(Callable.callAndReturnArgument(this.setLoadedUrls));
    }
}