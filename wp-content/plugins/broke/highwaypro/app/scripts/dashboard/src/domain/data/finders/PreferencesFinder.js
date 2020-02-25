import { Preferences } from '../Preferences';
import { RemoteFinder } from './RemoteFinder';
import { isJson } from '../../utilities/isJson';
import { isObject } from '../../utilities/isObject';

export class PreferencesFinder extends RemoteFinder {
    save(field: object)
    {
        return this.post({
            path: 'preferences/edit',
            data: {
                preferencesField: {
                    name: field.name,
                    value: field.value
                }
            }
        });
    }

    returnOnSuccess(response) 
    {
        const responseObject = this.createObjectFrom(response);

        const preferecesDataObject = isObject(responseObject.preferences)? responseObject.preferences : JSON.parse(response.preferences);

        responseObject.preferences = new Preferences(preferecesDataObject);

        return responseObject;
    } 
}