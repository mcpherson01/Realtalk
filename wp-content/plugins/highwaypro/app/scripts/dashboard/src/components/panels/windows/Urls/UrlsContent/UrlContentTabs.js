import './UrlContentTabs.css';

import React, {Component} from 'react';

import { Events } from '../../../../../domain/behaviour/events/events/Events';
import { HighWayPro } from '../../../../../domain/highwaypro/HighWayPro';

class UrlContentTabs extends Component {
    static TABS = {
        ANALYTICS: HighWayPro.text.urls.analytics,
        ROUTES: HighWayPro.text.urls.routes,
    };

    static EVENTS = {
        TAB_CHANGED: 'UrlContentTabs.events.tab_changed'
    };

    tabs = [
        UrlContentTabs.TABS.ANALYTICS, 
        UrlContentTabs.TABS.ROUTES
    ];

    classes = {
        active: 'hp--tab--active'
    };

    render() {
        return (
            <div class="hp-url-tabs">
                {this.tabs.map(tab => (
                    <div key={tab} class={`hp-tab ${this.props.activeTab === tab && this.classes.active}`}
                         onMouseDown={this.handleClick(tab)}
                    >
                        {tab}
                    </div>
                ))}
            </div>
        );
    }

    handleClick(tab) 
    {
        return event => Events.call(UrlContentTabs.EVENTS.TAB_CHANGED, {
            tab: tab,
            url: this.props.url
        });
    }
}

export default UrlContentTabs;