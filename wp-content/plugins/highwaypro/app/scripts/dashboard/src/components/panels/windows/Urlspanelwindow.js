import { HighWayPro } from '../../../domain/highwaypro/HighWayPro';

import './Urlspanelwindow.css';

import InputAdornment from '@material-ui/core/InputAdornment';
import React, {Component} from 'react';
import TextField from '@material-ui/core/TextField';
import { Events } from '../../../domain/behaviour/events/events/Events';
import { Observer } from '../../../domain/behaviour/events/observer/Observer';
import { Url } from '../../../domain/data/Url';
import { UrlTypes } from '../../../domain/data/finders/UrlTypes';
import { Urls } from '../../../domain/data/finders/urls';
import { clone } from '../../../domain/utilities/clone';
import ListPanel from './Urls/ListPanel';
import ListPanelContent from './Urls/ListPanelContent';
import Notifications from '../../notifications/Notifications';
import Panels from '../Panels';
import UrlContentHeader from './Urls/UrlsContent/UrlContentHeader';
import UrlContentTabs from './Urls/UrlsContent/UrlContentTabs';
import UrlDestinations from './Urls/UrlsContent/UrlDestinations';
import UrlPreferences from './Urls/UrlsContent/UrlPreferences';
import UrlStatistics from './Urls/statistics/UrlStatistics';
import UrlTypeMenu from './Urls/UrlTypeMenu';

class Urlspanelwindow extends Component {
    static instance = Urlspanelwindow;

    initialState = {
        urls: [],
        activeUrl: null,
        state: 'loading',
        content: {
            urls: {
                //89: {...} // the id is the key
                __default: {
                    tab: UrlContentTabs.TABS.ANALYTICS
                }
            },
        },
        sidebarIsOpened: true
    };

    state = clone(this.initialState);

    urls = new Urls;

    static setActiveUrl(url: Url) 
    {
        Panels.openPanel('urls');

        Urlspanelwindow.instance.setState({
            activeUrl: Urlspanelwindow.instance.state.urls.filter(loadedUrl => loadedUrl.id === url.id)[0]
        });
    }

    loadUrls = () => {
        this.resetState();

        return this.urls.getAll().then(
            responseObject => {
                responseObject.urls.forEach(url => {
                    url.add(new Observer(url => {
                        if (this.state.activeUrl === url) {
                            // update the same url O-N-L-Y when it's active with the 
                            // goal of trigerring a re-render of the view...
                            this.setState({
                                activeUrl: url
                            });
                        }
                    }));
                });

                return new Promise(resolve => {
                    this.setState({
                        urls: responseObject.urls,
                        state: 'loaded'
                    }, resolve);
                });
            },
            responseObject => {
                console.trace();
                Notifications.addFromResponse(responseObject);
            }
        );
    }

    static reloadUrls = () => {
        return Urlspanelwindow.instance.loadUrls();
    }
    
    resetState() {
        this.setState(this.initialState);
    }

    componentDidMount()
    {
        UrlTypes.addGlobalObserver(new Observer(UrlTypes => {
            this.loadUrls();
        }));

        this.loadUrls();

        Urlspanelwindow.instance = this;

        Events.register({
            name: UrlContentTabs.EVENTS.TAB_CHANGED,
            handler: this.handleTabChangeEvent.bind(this)
        });
    }

    handleTabChangeEvent({tab, url}) 
    {
        this.setState(state => {
            return {
                content: {
                    urls: {
                        ...state.content.urls,
                        [url.id]: {
                            tab: tab
                        }
                    }
                }
            }
        })
    }

    handleOpenRequest = (url, extraState) => 
    {
        let then;

        this.setState(state => ({
            activeUrl: url,
            sidebarIsOpened: false,
            ...(typeof extraState === 'function'? extraState(state) : {})
        }), then = () => {
            Events.call(Urlspanelwindow.EVENTS.URL_CREATED_AND_OPENED)
        });
    }

    handleOpenNewRequest(url) 
    {
        this.handleOpenRequest(url, state => ({
            content: {
                urls: {
                    ...state.content.urls,
                    [url.id]: {
                        tab: UrlContentTabs.TABS.ROUTES
                    }
                },
            }
        }))
    }

    render() {
        return (
            <React.Fragment>
                <ListPanel 
                    name={HighWayPro.text.urls.urls}
                    nameSinglar={HighWayPro.text.urls.url.toUpperCase()}
                    state={this.state.state} 
                    activeItem={this.state.activeUrl} 
                    items={this.state.urls} 
                    instanceType={Url}
                    handleOpenRequest={this.handleOpenRequest}
                    handleOpenNewRequest={this.handleOpenNewRequest.bind(this)}
                    handleReload={Urlspanelwindow.reloadUrls}
                    isOpened={this.state.sidebarIsOpened}
                    toggleVisibility={this.toggleVisibility.bind(this)}
                    renderListItem={url => (
                        <React.Fragment>
                            <div className="hp-url-list-item--path">{url.name}</div>
                            <div className="hp-url-list-item--name">{url.path}</div>
                        </React.Fragment>
                    )}
                    inputFields={{
                        name: createWindow => (
                            <TextField
                              className="MuiInput-underline create-url-field--name"
                              FormHelperTextProps={{classes:{root: 'MuiFormHelperText'}}}
                              label="Name"
                              value={createWindow.state.name}
                              onChange={createWindow.handleInputChange('name')}
                              helperText={HighWayPro.text.urls.urlNameHelper}
                              autoFocus={true}
                              margin="normal"
                              fullWidth={true}
                              inputProps={{
                                onKeyUp: createWindow.handleKeyPress
                              }}
                            />
                        ),
                        path: createWindow => (
                            <TextField
                              className="MuiInput-underline create-url-field--path"
                              FormHelperTextProps={{classes:{root: 'MuiFormHelperText'}}}
                              label="Path"
                              value={createWindow.state.path}
                              onChange={createWindow.handleInputChange('path')}
                              helperText={HighWayPro.text.urls.urlPathHelper}
                              margin="normal"
                              fullWidth={true}
                              InputProps={{
                                startAdornment: (<InputAdornment position="start" className="hp-domainbase">{HighWayPro.urls.domainAndBase}</InputAdornment>),
                                onKeyUp: createWindow.handleKeyPress
                              }}
                            />
                        ),
                        type_id: createWindow => (
                            <UrlTypeMenu 
                                className="create-url-field--type"
                                typeId={createWindow.state.type_id} 
                                whenChanged={createWindow.handleInputChange('type_id')}
                                defaultText="Base Path (optional)" 
                                label="Base Path (Type)" 
                                fullWidth={true}
                            />                    
                        )
                    }}
                />
                <ListPanelContent 
                    name="urls"
                    item={this.state.activeUrl}
                    instanceType={Url}
                    noItemSelectedContent={''}
                    toggleVisibility={this.toggleVisibility.bind(this)}
                    renderContent={(url: Url) => (
                        <React.Fragment>
                            <UrlContentHeader url={url}/>
                            <UrlContentTabs url={url} activeTab={this.getDefaultTab()}/>
                            {this.getCurrentContent(url)}
                        </React.Fragment>
                    )}
                />
            </React.Fragment>
        );
    }

    toggleVisibility() 
    {
        this.setState(state => ({
            sidebarIsOpened: !state.sidebarIsOpened
        }))
    }

    getCurrentContent(url: Object) 
    {
        url.loadUrlMetaIfItsNotInMemory();

        switch (this.getDefaultTab()) {
            case UrlContentTabs.TABS.ANALYTICS:
                return (<UrlStatistics layout="compact" hasLoaded={url.hasLoadedAnalytics()} getData={() => url.loaded.analytics}/>)
            break;
            case UrlContentTabs.TABS.ROUTES:
                return (
                    <div className="hp-routes-section">
                        <UrlDestinations url={url} />
                        <UrlPreferences url={url}/>
                    </div>
                )
            break;
        }
    }

    getDefaultTab() 
    {
        const urlsContentState = this.state.content.urls;

        let urlState = {};

        if (this.state.activeUrl && (typeof urlsContentState[this.state.activeUrl.id] !== 'undefined')) {
            urlState = urlsContentState[this.state.activeUrl.id];
        } else {
            urlState = urlsContentState.__default;
        }

        return urlState.tab
    }
}

Urlspanelwindow.EVENTS = {
    URL_CREATED_AND_OPENED: 'UrlsPanelWindow.events.url_created_and_opened'
};

export default Urlspanelwindow;