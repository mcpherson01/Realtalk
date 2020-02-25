import { ArrayManager } from '../../utilities/array/ArrayManager';
import { clone } from '../../utilities/clone';
import { isJson } from '../../utilities/isJson';
import { isObject } from '../../utilities/isObject';
var _ = require('lodash');

export class BuiltInComponent {
    data = {}; 
    initialState = {};
    reactComponent;

    getType() 
    {
        return this.constructor.type;    
    }

    getTypePlural() 
    {
        return `${this.getType()}s`;
    }
    setReactComponent(reactComponent) 
    {
        this.reactComponent = reactComponent;  
    }

    setInitialState()
    {
        this.reactComponent.state = this.initialState;
    }

    constructor(data) {
        this.data = clone(data || {}) || {};

        let metaData = this.getMetaData();

        this.parametersMap = metaData.parametersMap || {};
        this.title = metaData.title;
        this.shortDescription = metaData.shortDescription;
        this.description = metaData.description;
        this.allowed = metaData.allowedValues;
        this.setParameters();
    }

    setParameters() 
    {
        const parametersData = clone(isJson(this.data.parameters)? JSON.parse(this.data.parameters) : (isObject(this.data.parameters)? this.data.parameters : {}));
        const parametersMap = clone(this.parametersMap);

        let validParameters = _.pick(parametersData, _.keys(parametersMap));
        validParameters =  Object.assign(parametersMap, validParameters);

        this.data.parameters = Object.assign({}, validParameters);
    }

    getFinalParameters() 
    {
        return Object.assign(this.data.parameters, this.reactComponent.state);
    }
    
    getMetaData()
    {
        return clone(window.HighWayPro.components[this.getId().toLowerCase()])
    }

    getText() 
    {
        return this.description || '';    
    }
    
    getContent() {}
    getValuesAsPreview() {}
    getParametersAsJson() 
    {
        return JSON.stringify(this.getFinalParameters());
    }

    convertArrayToStringByNewLines(elements: array) {
        return elements.join("\n");
    }

    converStringTotArrayByNewLines(stringElements: string) {
        return stringElements.trim().split("\n");
    }

}