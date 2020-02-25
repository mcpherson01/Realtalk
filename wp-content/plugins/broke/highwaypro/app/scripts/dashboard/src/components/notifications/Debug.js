import 'highlight.js/styles/github-gist.css';

import './Debug.css';

import React, {Component} from 'react';
import hljs from 'highlight.js/lib/highlight';
import json from 'highlight.js/lib/languages/json';

import { isJson } from '../../domain/utilities/isJson';
import { isObject } from '../../domain/utilities/isObject';

class Debug extends Component {
    elements = {
        code: React.createRef()
    };

    componentDidMount() 
    {
        hljs.registerLanguage('json', json);
    }

    componentDidUpdate() 
    {
        this.elements.code.current && hljs.highlightBlock(this.elements.code.current);
    }

    render() {
        const isObject = (this.props.object !== null)  && (typeof this.props.object === 'object');

        return (
            <pre className="hp-debug">
                <code class="json" ref={this.elements.code}>
                    {isObject && (this.formatResponse(this.props.object))}
                </code>
            </pre>
        );
    }

    formatResponse(JSONObject) 
    {
        const convertToJsonDeep = json => {
            for (let key in json) {
                const value = json[key];
                if (isJson(value)) {
                    json[key] = convertToJsonDeep(JSON.parse(value));
                } else if (isObject(value)) {
                    json[key] = convertToJsonDeep(value);
                }
            }

            return json;
        }

        return JSON.stringify(convertToJsonDeep(JSONObject), null, 4);
    }
}

export default Debug;