import axios from 'axios';
import jQuery from 'jquery';

import {RemoteFinder} from '../RemoteFinder';
import {TestCase} from '../../../tests/TestCase';

class RemoteFinderTest extends TestCase
{
    setUpBeforeClass()
    {
        window.jQuery = jQuery;
        window.HighWayPro = {
            urls: {
                url: 'http://example.org'
            }
        };
    }

    setRemoteFinderMethods() {
        RemoteFinder.prototype.returnOnSuccess = () => {}
        RemoteFinder.prototype.returnOnError = () => {}
    }

    unsetRemoteFinderMethods() {
        RemoteFinder.prototype.returnOnSuccess = null;
        RemoteFinder.prototype.returnOnError = null;
    }

    test_throws_error_if_interface_not_implemented() 
    {
        this.unsetRemoteFinderMethods();
        expect(() => {
            new RemoteFinder;
        }).toThrow('Class must implement method');
    }

    test_throws_no_error_if_interface_is_implemented() 
    {
        this.setRemoteFinderMethods();
        expect(() => {
            new RemoteFinder;
        }).not.toThrow('Class must implement method');
    }

    test_finder_is_jquery() 
    {
        this.setRemoteFinderMethods();

        let remoteFinder = new RemoteFinder;

        expect(remoteFinder.finder).toBe(jQuery.ajax);
    }

    test_defult_validation_is_rejected_if_status_code_is_not_200() 
    {
        this.setRemoteFinderMethods();

        let remoteFinder = new RemoteFinder;
        let codes = [...Array(1100).keys()].map(number => {
            return {
                statusCode: number,
                result: (number > 100) && (number.toString().charAt(0) == '2')
            };
        });

        codes.forEach(code => {
            expect(remoteFinder.validateResponse(
                {
                    status: code.statusCode
                }
            )).toBe(code.result);
        })
    }

    test_returns_defaut_object_or_overrides_if_found() 
    {
        this.setRemoteFinderMethods();

        let remoteFinder = new RemoteFinder; 
        let responses = [
            {
                data: '',
                expectedResult: {
                    state: 'error',
                    type: RemoteFinder.defaultErrorType,
                    message: 'There seems to be a problem processing this request. Please view the details below or contact support for further assistance.',
                    _client: {data: undefined, response: {}}
                }
            },
            {
                data: 'a string',
                expectedResult: {
                    state: 'error',
                    type: RemoteFinder.defaultErrorType,
                    message: 'There seems to be a problem processing this request. Please view the details below or contact support for further assistance.',
                    _client: {data: undefined, response: {}}
                }
            },
            {
                data: 'non valid json {"state": "success"}',
                expectedResult: {
                    state: 'error',
                    type: RemoteFinder.defaultErrorType,
                    message: 'There seems to be a problem processing this request. Please view the details below or contact support for further assistance.',
                    _client: {data: undefined, response: {}}
                }
            },
            {
                data: JSON.stringify({
                    state: 'success',
                    type: 'success_type_title',
                    message: 'all ok'

                }),
                expectedResult: {
                    state: 'success',
                    type: 'success_type_title',
                    message: 'all ok',
                    _client: {data: undefined, response: {}}
                }
            }
        ];

        responses.forEach((response) => {
            let result = remoteFinder.createObjectFrom(response);

            //expect(result).to(response.expectedResult);   
        });
    }
}

new RemoteFinderTest().run();