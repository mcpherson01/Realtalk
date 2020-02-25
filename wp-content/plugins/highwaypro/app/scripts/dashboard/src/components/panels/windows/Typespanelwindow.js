import './Typespanelwindow.css';

import Promise from 'promise';
import React, {Component} from 'react';
import TextField from '@material-ui/core/TextField';

import { Events } from '../../../domain/behaviour/events/events/Events';
import { HighWayPro } from '../../../domain/highwaypro/HighWayPro';
import { Observer } from '../../../domain/behaviour/events/observer/Observer';
import { UrlType } from '../../../domain/data/UrlType';
import { UrlTypes } from '../../../domain/data/finders/UrlTypes';
import { clone } from '../../../domain/utilities/clone';
import ListOfUrls from './UrlTypes/Content/ListOfUrls';
import ListPanel from './Urls/ListPanel';
import ListPanelContent from './Urls/ListPanelContent';
import Notifications from '../../notifications/Notifications';
import UrlTypeContentHeader from './UrlTypes/Content/UrlTypeContentHeader';
import Urlspanelwindow from './Urlspanelwindow';

class Typespanelwindow extends Component {
    initialState = {
        state: 'loaded',
        activeUrlType: {},
        urlTypes: [],
        urlsAssociatedWithThisType: [],
        sidebarIsOpened: true
    };

    state = clone(this.initialState);

    urlTypesFinder = new UrlTypes;

    loadUrlTypes() {
        this.setState(this.initialState);
        
        return this.urlTypesFinder.getAll().then(
            responseObject => {
                responseObject.urlTypes.forEach(urlType => {
                    urlType.add(new Observer(urlType => {
                        // only trigger re-render when there are changes and the active url is the same
                        if (this.state.activeUrlType === urlType) {
                            this.setState({
                                activeUrlType: urlType
                            });
                        }
                    }));
                });

                return new Promise(resolve => {
                    this.setState({
                        urlTypes: responseObject.urlTypes,
                        state: 'loaded'
                    }, resolve);
                });
            },
            responseObject => {
                Notifications.addFromResponse(responseObject);
            }
        );
    }

    static reloadUrlTypes = () => {
        return Typespanelwindow.instance.loadUrlTypes();
    }

    componentDidMount(properties)
    {
        Events.register({
            name: 'urls.afterUpdate',
            handler: Typespanelwindow.reloadUrlTypes
        });

        Typespanelwindow.instance = this;
        this.loadUrlTypes();
    }

    handleOpenRequest = (item: UrlType, then) => {
        this.setState({
            activeUrlType: this.state.urlTypes.find(stateUrlType => stateUrlType.id === item.id),
            sidebarIsOpened: false,
        }, then || (() => {}))
    }

    render() {
        return (
        <React.Fragment>
            <ListPanel 
                name="url types"
                nameSinglar={HighWayPro.text.urls.urlType.toUpperCase()}
                state={this.state.state} 
                activeItem={this.state.activeUrlType} 
                instanceType={UrlType}
                items={this.state.urlTypes} 
                handleOpenRequest={this.handleOpenRequest}
                handleReload={Typespanelwindow.reloadUrlTypes}
                isOpened={this.state.sidebarIsOpened}
                toggleVisibility={this.toggleVisibility.bind(this)}
                renderListItem={url => (
                        <React.Fragment>
                            <div className="hp-url-list-item--path">{url.name}</div>
                            <div className="hp-url-list-item--name">{url.base_path || '/'}</div>
                        </React.Fragment>
                    )}
                inputFields={{
                    name: createWindow => (
                        <TextField
                          className="MuiInput-underline"
                          FormHelperTextProps={{classes:{root: 'MuiFormHelperText'}}}
                          label="Name"
                          value={createWindow.state.name}
                          onChange={createWindow.handleInputChange('name')}
                          helperText="The name of the url type. Only letters, numbers and one or more spaces are accepted."
                          autoFocus={true}
                          margin="normal"
                          fullWidth={true}
                          inputProps={{
                            onKeyUp: createWindow.handleKeyPress
                          }}
                        />
                    ),
                    base_path: createWindow => (
                        <TextField
                          className="MuiInput-underline"
                          FormHelperTextProps={{classes:{root: 'MuiFormHelperText'}}}
                          label="Base Path"
                          value={createWindow.state.base_path}
                          onChange={createWindow.handleInputChange('base_path')}
                          helperText="The base path"
                          autoFocus={false}
                          margin="normal"
                          fullWidth={true}
                          inputProps={{
                            onKeyUp: createWindow.handleKeyPress
                          }}
                        />
                    )
                }}
            />
            <ListPanelContent 
                name="url types"
                item={this.state.activeUrlType}
                instanceType={UrlType}
                toggleVisibility={this.toggleVisibility.bind(this)}
                renderContent={(urlType: UrlType) => (
                    <React.Fragment>
                        <UrlTypeContentHeader urlType={urlType}/>
                        <ListOfUrls urlType={urlType}/>
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
}

export default Typespanelwindow;