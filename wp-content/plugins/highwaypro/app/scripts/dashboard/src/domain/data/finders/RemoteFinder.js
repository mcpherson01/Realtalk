import { clone } from '../../utilities/clone';
import { isJson } from '../../utilities/isJson';
import {throwErrorIfClassDoesNotImplement} from
  '../../utilities/interface/throwErrorIfClassDoesNotImplement';

export class RemoteFinder {
    Static = RemoteFinder;

    interface = [
        'validateResponse',
        'returnOnSuccess',
        'returnOnError'
    ];

    static defaultResponse = {
        status: 4000,
        statusText: 'Error performing request - Default Error',
        headers: {},
        config: {},
        request: {},
        data: '',
        config: {},
        'message': 'Error performing request - Default Error'
    };

    static defaultErrorType = 'default_client_error_message';

    static defaultErrorMessage = 'There seems to be a problem processing this request. Please view the details below or contact support for further assistance.';
    static defaultResponseObject = {
        state: 'error',
        type: RemoteFinder.defaultErrorType,
    };

    finder = window.jQuery.ajax;
    baseUrl = window.HighWayPro.urls.url;

    constructor() 
    {
        throwErrorIfClassDoesNotImplement(this.interface, this);
    }

    get(data) 
    {
        return this.makeRequest({
            method: 'get',
            path: data.path,
            data: data.data
        });
    }

    post(data) 
    {
        return this.makeRequest({
            method: 'post',
            path: data.path,
            data: data.data
        });
    }

    getResponseFromMessage(message) 
    {
        var response = this.Static.defaultResponse;

        if (message.response) {
            response = Object.assign(response, message);
        } 

        if (message.request) {
            response = Object.assign(response, message.request);
        }  

        if (message.message) {
            response = Object.assign(response, {message: message.message}); 
        }  

        if (message.config) {
            response = Object.assign(response, message.config); 
        }
        
        return response;
    }

    validateResponse(response) 
    {
        return this.is200Status(response) && isJson(response.responseText) && this.dataIsValid(response);    
    }

    is200Status(response) 
    {
        return (response.status > 199) && (response.status < 300)
    }

    dataIsValid(response) 
    {
        return this.createObjectFrom(response).state === 'success';
    }

    handleResponse(resolve, reject, requestData, response) 
    {
        const validationResult = this.validateResponse(response);

        if (validationResult) {
            return resolve(this.returnOnSuccess(response));
        } else {
            return reject(this.returnOnError(response, requestData));
        }
    }

    returnOnError(response, requestData)
    {
        return this.callCreateObjectFrom(response, requestData);
    }

    makeRequest(data) 
    {
        return new Promise((resolve, reject) => {
            const requestData = this.getData(data);

            this.finder({
                method: data.method.toUpperCase(),
                url: this.getAdminUrl(),
                data: requestData,
                dataType: 'text', // we'll interpret it ourselves,
                complete: this.handleResponse.bind(this, resolve, reject, requestData)
            })
        });
    }

    paramsOrData(data) 
    {
        return (data.method.toLowerCase() === 'get')? 'params' : 'data';    
    }

    getData(data) 
    {
        return {
            action: 'highwaypro_post',
            path: data.path,
            data: JSON.stringify(data.data)
        };
    }
    
    getAdminUrl() 
    {
        return `${this.baseUrl}/wp-admin/admin-post.php`    
    }

    callCreateObjectFrom(response, requestData) 
    {
        return this.createObjectFrom(response, requestData)
    }

    createObjectFrom(response, requestData) 
    {
        let dataIsJson = isJson(response.responseText);
        let object = dataIsJson? JSON.parse(response.responseText) : {};
        !dataIsJson? (this.Static.defaultResponseObject.message = this.Static.defaultErrorMessage) : null;

        return Object.assign(
            clone(this.Static.defaultResponseObject), 
            {_client: {
                data: response.responseText, 
                request: requestData,
                response: ((typeof response === 'object')? response : {})}
            }, 
            object
        );
    }
}