import { Domain } from '../domain/Domain';
import { Observer } from '../../behaviour/events/observer/Observer';
import { PreferencesFinder } from '../finders/PreferencesFinder';

export class PreferencesBase extends Domain
{
    getName = () => 'PreferencesBase';

    constructor(preferences: Preferences, data) 
    {
        super(data);

        this.preferences = preferences;
        this.preferencesFinder = new PreferencesFinder;

        this.add(new Observer(() => {
            preferences.notify();          
        }))
    }

    save(fieldName: string) 
    {
        return this.preferencesFinder.save({
            name: this.getFieldWithComponentName(fieldName),
            value: this[fieldName]
        });
    }

    getFieldWithComponentName(fieldName: string) 
    {
        return `${this.getComponentType()}.${fieldName}`;
    }
}