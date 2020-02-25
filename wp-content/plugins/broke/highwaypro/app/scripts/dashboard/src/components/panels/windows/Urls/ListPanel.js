import './ListPanel.css';

import $ from 'jquery';
import AddRounded from '@material-ui/icons/AddRounded';
import Button from '@material-ui/core/Button';
import NewReleasesRounded from '@material-ui/icons/NewReleasesRounded';
import React, {Component} from 'react';
import SettingsInputAntennaRounded from '@material-ui/icons/SettingsInputAntennaRounded';
import _ from 'lodash';
import classnames from 'classnames';
import milliseconds from 'delay';

import { Events } from '../../../../domain/behaviour/events/events/Events';
import { HighWayPro } from '../../../../domain/highwaypro/HighWayPro';
import App from '../../../../App';
import CreateUrlWindow from './CreateUrlWindow';
import IconWithText from '../../../icons/IconWithText';

class ListPanel extends Component {
    state = {
        createUrlIsOpened: false,
        bottomButton: {
            width: '',
            left: ''
        },
        sidebar: {
            width: 0,
            left: 0,
            top: 0
        },
        bottomButton: {
            width: 0,
            left: 0
        },
        elementsList: {
            height: 'auto' // intial values..
        }
    }

    loadedEventHasNotBeenCalled = true;

    sidebarElement = React.createRef();
    elements = {
        header: React.createRef(),
        button: React.createRef()
    };

    listElements = [];

    async componentDidMount()
    {
        await milliseconds(200);

        this.setDimensions();
    }

    componentDidUpdate()
    {
        this.setDimensions();
        this.callLoadedEventOnce();
    }

    callLoadedEventOnce() 
    {
        if (this.props.state === 'loaded' && this.loadedEventHasNotBeenCalled) {
            Events.call(ListPanel.EVENTS.HAS_LOADED_ONCE, this.props);
            this.loadedEventHasNotBeenCalled = false;
        }
    }

    setDimensions() 
    {
        ListPanel.element = this.sidebarElement.current;

        const paddingLeft = parseInt(window.getComputedStyle(this.sidebarElement.current).paddingLeft);
        const sidebarWidth = this.sidebarElement.current.clientWidth;
        const sidebarHeight = this.sidebarElement.current.offsetHeight;
        const sidebarContentX = this.sidebarElement.current.getBoundingClientRect().left + paddingLeft;
        const listMarginTop = 24;

        if (this.state.sidebar.width !== sidebarWidth) {
            this.setState({
                sidebar: {
                    width: sidebarWidth,
                    left: sidebarContentX,
                    top: this.sidebarElement.current.getBoundingClientRect().top
                },
                bottomButton: {
                    width: sidebarWidth - (paddingLeft * 2) - (8 * 2),
                    left: 0,//sidebarContentX,
                    bottom: 0
                },
                elementsList: {
                    height: $('.hp-side-bar-footer-button').length?
                        (
                            parseInt(sidebarHeight) -
                            (
                                44 +
                                listMarginTop +
                                $('.hp-side-bar-header-container').outerHeight() +
                                ($('.hp-side-bar-footer-button').outerHeight())
                            )
                        ) : 'auto'
                }
            });    
        }
    }

    setCreateWindowIsOpened = (isOpened) => {
        this.setState({
            createUrlIsOpened: isOpened
        });
    }

    handleOpenRequest = item => {
        this.props.handleOpenRequest(item);
    }

    render() {
        const state = this.props.state || 'loading';
        let content;

        if (state === 'loading') {
            content = (
                <div className="hp-loading hp--self-centered">
                    <IconWithText title={HighWayPro.text.other.loading} icon={<SettingsInputAntennaRounded />}/>
                </div>
            );
        } else if (state === 'loaded') {
            content = (
            <React.Fragment>
                <header ref={this.elements.header} className="hp-side-bar-header-container">
                    <div className="hp-title">
                        {HighWayPro.text.urls[this.props.name.toLowerCase()] || this.props.name} <span className="hp-title-contrast">{this.props.items.length}</span>
                    </div>
                    <div className="hp-add-url">
                        <Button variant="extendedFab" aria-label="new" onClick={this.setCreateWindowIsOpened.bind(this, true)}>
                            <AddRounded />
                            <span className="hp-button-text">{HighWayPro.text.urls.new}</span>
                        </Button>
                    </div>
                </header>
                <ul className="hp-urls-list" style={{height: this.state.elementsList.height}}>
                    {this.getUrlsList()}
                </ul>
                <Button style={this.state.bottomButton} 
                        className="hp-side-bar-footer-button"
                        ref={this.elements.button}
                        variant="contained" 
                        color="default" 
                        onClick={this.setCreateWindowIsOpened.bind(this, true)
                }>
                    {HighWayPro.text.urls.createNew} + 
                </Button>
                <CreateUrlWindow 
                    name={this.props.nameSinglar}
                    fields={this.props.fields || {}}
                    entityType={this.props.instanceType}
                    inputFields={this.props.inputFields} 
                    dimensions={this.state.sidebar} 
                    isOpened={this.state.createUrlIsOpened} 
                    whenClosing={this.setCreateWindowIsOpened.bind(this, false)} 
                    handleOpenRequest={this.handleOpenRequest}
                    handleOpenNewRequest={this.props.handleOpenNewRequest}
                    handleReload={this.props.handleReload}
                />
            </React.Fragment>
            );
        }

        const noUrls = this.props.items.length > 0? '--with-urls' : '--with-no-urls';

        return (
            <div ref={this.sidebarElement} className={`hp-url-sidebar --${this.props.state} ${noUrls} ${classnames({
                '--isOpened': this.props.isOpened,
                '--hasSelectedItem': this.props.activeItem && this.props.activeItem.id
            })}`}>
                {content}

            </div>
        );
    }

    getUrlsList() {
        if (this.props.items.length < 1) {
            return (
                <div className="hp-no-urls">
                    <IconWithText title={HighWayPro.text.urls.noItemsTitle.replace('*', _.startCase(this.props.name))} text={HighWayPro.text.urls.noItemsMessage.replace('*', this.props.name)} icon={<NewReleasesRounded />}/>
                </div>
            );
        }

        return this.props.items.map(item => {
            const isActive = (this.props.activeItem && this.props.activeItem.id === item.id);
            const classes = classnames({
                'hp-url-list-item': true,
                '--active': isActive
            });

            if (!this.listElements[item.id]) {
                this.listElements[item.id] = React.createRef();
            }

            return (<li ref={this.listElements[item.id]} className={classes} key={item.id} onClick={this.handleOpenRequest.bind(this, item)}>
                        {this.props.renderListItem(item)}
                    </li>);
        })
    }

    getBottom() 
    {
        return $('#wpfooter').outerHeight();
    }
}

ListPanel.EVENTS = {
    HAS_LOADED_ONCE: 'ListPanel.events.has_loaded_once'
};

export default ListPanel;