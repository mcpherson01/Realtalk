import { Events } from './events';
import { UrlPostMetaBoxManager } from './metabox/UrlPostMetaBoxManager';
import { HighWayProApp } from './HighWayProApp';

const ClassicAddShortUrlButton = require('./components/classic/AddShortUrlButton').default;

const GutenbergAddShortUrlButton = HighWayProApp.gutenbergIsEnabled()? require('./components/gutenberg/AddShortUrlButton').default : {};

const { ReactDOM } = window;

export class HighWayPro
{
    state = {
        urlPickerReceiver: null
    };

    static EVENTS = {
        CHANGE: {
            URLPICKERRECEIVER: 'HighWayPro.state.change.urlPickerReceiver'
        }
    };

    constructor() 
    {
        jQuery(document).ready(this.initialize.bind(this));
    }

    initialize() 
    {
        HighWayPro.instance = this;

        if (window.tinymce) {
            ClassicAddShortUrlButton.register();
        }

        if (HighWayProApp.gutenbergIsEnabled()) {
            GutenbergAddShortUrlButton.register();
        }

        new UrlPostMetaBoxManager;
    }

    changeState(newState) 
    {
        let propertiesChanged = [];

        for (let name in newState) {
            propertiesChanged.push(name);
            this.state[name] = newState[name];
        }

        this.callChangeEvents(propertiesChanged);
    }

    callChangeEvents(propertiesChanged) 
    {
        let event = {
            newState: this.state,
            propertiesChanged: propertiesChanged
        };

        for (let property of propertiesChanged) {
            let eventName = HighWayPro.EVENTS.CHANGE[property.toUpperCase()];

            eventName && Events.call(eventName, event);
        }

        Events.call(
            HighWayPro.STATE_CHANGE_EVENT,
            event
        );
    }
}