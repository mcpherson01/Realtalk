import './CreateUrlWindow.css';

import React, {Component} from 'react';
import classnames from 'classnames';
import delay from 'delay';

import { Events } from '../../../../domain/behaviour/events/events/Events';
import { HighWayPro } from '../../../../domain/highwaypro/HighWayPro';
import { Strings } from '../../../../domain/utilities/Strings';
import { clone } from '../../../../domain/utilities/clone';
import DualButton from '../../../Buttons/DualButton';
import Notifications from '../../../notifications/Notifications';
import $ from 'jquery';

class CreateUrlWindow extends Component {
    initialState = Object.assign(
        {
            hasError: false
        }
    );

    state = clone(this.initialState);
    finder = this.props.entityType.getFinder();

    elements = {
        form: React.createRef()
    }

    handleInputChange = field => event => {
        let value = event.target.value;

        if (['path', 'base_path'].includes(field)) {
            value = Strings.ensureLeadingPath((value || '').replace(' ', '-').replace(/[^a-z0-9-]/gi,''));
        }

        this.setState({
            [field]: value
        });
    }

    showMessages = (response, requestData) => {
        Notifications.openLoadingNotification(false);

        Notifications.addFromResponse(response, requestData);

        return response;
    }

    closeWindowAndOpenNewlyCreatedUrl = (response) => {
        this.close();

        this.props.handleReload().then(
            this.openUrl.bind(this, response[Strings.lcfirst(this.props.entityType.getName())].id)
        );
    }

    openUrl(urlId) 
    {
        const open  = this.props.handleOpenNewRequest || this.props.handleOpenRequest;
        
        return open(this.finder.getFromMemoryWithId(urlId));
    }

    handleKeyPress = (event) => {
        const enterKey = 13;

        if (event.which === enterKey) {
            this.handleCreation();
        }
    }

    handleCreation = () => {
        Notifications.openLoadingNotification(true, HighWayPro.text.other.saving);

        this.finder.create(this.state)
                       .then(((response) => {
                            this.closeWindowAndOpenNewlyCreatedUrl(response);                        
                            return response
                       }))
                       .catch((response) => {
                            this.setState({
                                hasError: true
                            });
                            return response;
                       })
                       .then(this.showMessages);
    }

    close = () => {
        this.setState(state => {
            const newState = {};

            for (let key in state) {
                newState[key] = '';
            }

            return Object.assign(
                {},
                newState,
                this.initialState
            );
        });

        this.props.whenClosing();
    }

    closeIfHasNoErrors = () =>
    {
        if (!this.state.hasError) {
            this.close();
        }
    }

    handleTransitionEnd(event) 
    {
        const {propertyName, target} = event;

        if (propertyName === 'transform' && $(event.target).hasClass('hp-content') && this.props.isOpened) {
            this.handleWindowFinishedOpening();
        }
    }

    handleWindowFinishedOpening() 
    {
        Events.call(CreateUrlWindow.EVENTS.AFTER_OPEN, {});

        $(this.elements.form.current).find('input').first().focus();
    }

    render() {
        const classes = classnames({
            'hp-create-url': true,
            '--active': this.props.isOpened
        });

        return (
            <div className={classes} style={this.props.dimensions} onTransitionEnd={this.handleTransitionEnd.bind(this)}>
                    <div className="hp-content">
                        <header>
                            <h1>{HighWayPro.text.urls.createNewType.replace('*', this.props.name)}</h1>
                        </header>
                        <form ref={this.elements.form}>
                            {Object.keys(this.props.inputFields).map(field => {
                                return this.props.inputFields[field](this);
                            })}
                        </form>
                        <DualButton 
                                classes="hp-create-url-buttons" 
                                style="line"
                                buttons={{
                                    left: {
                                        text: HighWayPro.text.other.cancel,
                                        whenClicked: this.close,
                                        classes: 'hp-cancel-button',
                                        width: 36
                                    },
                                    right: {
                                        text: HighWayPro.text.other.create,
                                        whenClicked: this.handleCreation,
                                        classes: 'hp-create-button',
                                        width: 64
                                    }
                                }}
                        />
                    </div>
            </div>
        );
    }
}

CreateUrlWindow.EVENTS = {
    AFTER_OPEN: 'CreateUrlWindow.events.after_open' 
}

export default CreateUrlWindow;