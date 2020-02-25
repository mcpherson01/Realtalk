import { Domain } from './domain/Domain';
import { UrlExtraFinder } from './finders/UrlExtraFinder';

export class UrlExtra extends Domain
{
    static getName = () => 'UrlExtra';

    static getAliasedName(fieldName) 
    {
        switch (fieldName) {
            case 'keyword_injection_keywords':
            case 'keyword_injection_context':
                return 'keyword_injection';
                break;
            default:
                return fieldName;
                break;
        }
    }

    constructor(data) 
    {
        super(data);

        UrlExtra.finder = new UrlExtraFinder();
    }

    get(fieldName) 
    {
        return this.getValue(fieldName);
    }

    set(fieldName, value) 
    {
        return this[this.getPropertynameforAliasedField(fieldName)] = value;
    }

    getExportedValue(fieldName) 
    {
        const value = this.getValue(fieldName);

        if (fieldName === 'keyword_injection_context') {
            return value.join(',');
        }

        return value;
    }

    getValue(fieldName) 
    {
        return this[this.getPropertynameforAliasedField(fieldName)];
    }

    getPropertynameforAliasedField(fieldName) 
    {
        return fieldName === 'keyword_injection_context'? 'context' : 'value';
    }
}