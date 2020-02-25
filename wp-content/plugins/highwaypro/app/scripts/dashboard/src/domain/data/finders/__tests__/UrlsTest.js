import {TestCase} from '../../../tests/TestCase';
import { Urls } from '../urls';
import jQuery from 'jquery';

class UrlsTest extends TestCase
{
    setUpBeforeClass()
    {
        window.jQuery = jQuery;
        window.HighWayPro = {
            urls: {
                url: 'http://localhost:80/highwaypro'
            }
        };
    }

    test_makes_get_requests(done) 
    {
        let urlsFinder = new Urls;

        urlsFinder.getAll().then((object) => {
            expect(typeof object).toBe('object');
            expect(object.state).toBe('success');
            expect(object.type).toBe('urls_read_success');
            expect(Array.isArray(object.urls)).toBe(true);
            expect(typeof object._client).toBe('object');
            expect(object._client.data).toBe('{"state":"success","type":"urls_read_success","urls":[]}');

            done();

            /* 
             { 
                state: 'success',
                type: 'urls_read_success',
                urls: [],
                _client:
                 { data: '{"state":"success","type":"urls_read_success","urls":[]}',
                   response:
                    { status: 200,
                      statusText: 'OK',
                      headers: [Object],
                      config: [Object],
                      request: [Object],
                      data: '{"state":"success","type":"urls_read_success","urls":[]}' } },
            }*/
        }).catch((error) => {
            console.log(error);
        });
    }

    test_fails_if_response_is_not_200_or_is_not_json()
    {
        let urlsFinder = new Urls;
        let responses = [
            {
                response: {
                    status: 400,
                    responseText: '{"key": "value"}'
                },
                expectedResult: false
            },
            {
                response: {
                    status: 200,
                    responseText: ''
                },
                expectedResult: false
            },
            {
                response: {
                    status: 200,
                    responseText: '{"state":"success", "key": "value"}'
                },
                expectedResult: true
            },
            {
                response: {
                    status: 200,
                    responseText: '{"state":"error", "key": "value"}'
                },
                expectedResult: false
            },
            {
                response: {
                    status: 200,
                    responseText: '{"key": "value"}'
                },
                expectedResult: false
            }
        ];

        responses.forEach((response) => {
            let result = urlsFinder.validateResponse(response.response);

            expect(result).toBe(response.expectedResult);   
        })
    }
}

(new UrlsTest).run();