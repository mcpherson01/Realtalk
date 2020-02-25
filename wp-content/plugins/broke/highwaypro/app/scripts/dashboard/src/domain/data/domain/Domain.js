import { Observable } from '../../behaviour/events/observer/Observable';

export class Domain extends Observable
{
    static getEntityName()
    {
        return Domain.prototype.constructor.name;
    }

    constructor(object: object)
    {
        super(object);
        this.setFieldsFromObject(object);
    }

    setFieldsFromObject(object) 
    {
        for(let property in object) {
            if (Observable.getProperties().includes(property)) {
                continue;
            }
            
            this[property] = object[property];
            this.updateParameters = [this];
        }    
    }

    get(fieldName) 
    {
        return this[fieldName];
    }

    set(fieldName, value) 
    {
        return this[fieldName] = value;
    }

    setField(fieldData)
    {
        let value = fieldData.value;

        if (typeof fieldData.value == 'function') {
            value = fieldData.value(this[fieldData.field]);
        }

        this[fieldData.field] = value;
        this.notify();
    }

    updateField(fieldName) 
    {
        return this.constructor.finder.update({
            id: this.id,
            field: {
                name: fieldName,
                value: this[fieldName]
            },
            entity: this
        });
    }
}