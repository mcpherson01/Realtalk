import { Callable } from '../../utilities/Callable';
import { Observer } from '../../behaviour/events/observer/Observer';
import { RemoteFinder } from './RemoteFinder';
import { UrlType } from '../UrlType';
import { isObject } from '../../utilities/isObject';

export class UrlTypes extends RemoteFinder {
    static all = [];
    static staticObservers = [];

    static getFromMemoryWithId = (id) => {
        return UrlTypes.all.filter(urlType => urlType.id === id)[0];
    }

    static addGlobalObserver = (observer: Observer) => {
        UrlTypes.staticObservers.push(observer);
    }

    static notifyGlobalObservers = () => {
        UrlTypes.staticObservers.forEach(observer => {
            observer.update();   
        });
    }

    Static() 
    {
        return UrlTypes;
    }

    getFromMemoryWithId(id)
    {
        return UrlTypes.getFromMemoryWithId(id);
    }

    create(urlTypeData) 
    {
        return this.post({
            path: 'urls/types/new',
            data: {
                urlType: urlTypeData
            }
        })
        .then(Callable.callAndReturnArgument(this.setLoadedType))
    }

    update(data)
    {
        return this.post({
            path: 'urls/types/edit',
            data: {
                urlType: {
                    id: data.id,
                    [data.field.name]: data.field.value
                },
                fieldToUpdate: data.field.name
            }
        }).then(Callable.callAndReturnArgument(this.setLoadedType));
    }

    static loadFromDatabase() 
    {
        return new UrlTypes().getAll().then(Callable.callAndReturnArgument(UrlTypes.setLoadedTypes));       
    }

    static setLoadedTypes = (response) => {
        UrlTypes.all = response.urlTypes;
    }

    setLoadedType = (response) => {
        if (UrlTypes.all.filter(urlType => urlType.id === response.urlType.id).length === 0) {
            UrlTypes.all.push(response.urlType);
        }

        UrlTypes.all.forEach((urlType, index) => {
            let entity;

            if (urlType.id === response.urlType.id) {
                entity = response.urlType;
            } else {
                entity = urlType;
            } 
            UrlTypes.all[index] = entity;

        });
        this.constructor.notifyGlobalObservers();
    }

    getAll() 
    {
        return this.get({path: 'url/types'});    
    }

    validateResponse(response) 
    {
        return super.validateResponse(response);
    }   

    returnOnSuccess(response) 
    {
        const responseObject = this.createObjectFrom(response);

        if (Array.isArray(responseObject.urlTypes)) {
            responseObject.urlTypes = responseObject.urlTypes.map(urlType => new UrlType(urlType));            
        }

        if (isObject(responseObject.urlType)) {
            responseObject.urlType = new UrlType(responseObject.urlType);
        }

        return responseObject;
    } 
}