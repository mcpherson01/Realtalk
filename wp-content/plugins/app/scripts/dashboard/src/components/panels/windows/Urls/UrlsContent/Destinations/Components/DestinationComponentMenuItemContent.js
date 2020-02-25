import './DestinationComponentMenuItemContent.css';

import ArrowBackRounded from '@material-ui/icons/ArrowBackRounded';
import React, {Component} from 'react';
import _ from 'lodash';
import classnames from 'classnames';

import { Callable } from '../../../../../../../domain/utilities/Callable';
import { HighWayPro } from '../../../../../../../domain/highwaypro/HighWayPro';
import Button from '../../../../../../Buttons/Button';
import Header from '../../../../../../Header/Header';
import Notifications from '../../../../../../notifications/Notifications';
import TrafficRounded from '@material-ui/icons/TrafficRounded';
import SendRounded from '@material-ui/icons/SendRounded';

class DestinationComponentMenuItemContent extends Component {
    element = React.createRef();
    callActiveEvent = false;

    constructor(properties)
    {
        super(properties);
        this.props.componentElement.setReactComponent(this);
        this.props.componentElement.setInitialState();
    }

    showMessages = (response) => {
        Notifications.openLoadingNotification(false);
        Notifications.addFromResponse(response);
    }

    handleConfirmationButton = action => {
        let originalAction = action;

        if (['ok', 'cancel'].indexOf(action.toLowerCase()) > -1) {
            action = 'close';    
        }

        let close = (argument) => this.props.whenContentClosed(action);

        if (originalAction === 'ok') {
            Notifications.openLoadingNotification(true, HighWayPro.text.other.saving);

            this.props.destination.saveComponent(this.props.componentElement)
                              .then(Callable.callAndReturnArgument(close))
                              .catch((response) => response)
                              .then(this.showMessages);
        } else {
            close('');
        }
    }

    isActive = () => {
        return this.props.componentElement.getId() === this.props.selectedItemId;
    }

    componentDidUpdate = () => {
        
        if (this.isActive() && !this.callActiveEvent) {
            this.props.whenElementBecomesActive(this.element.current);
        }
    }

    getMaxHeight = () => 
    {
        const header = Header.element;
        const windowHeight = document.body.clientHeight;
        const headerHeight = header.clientHeight;
        const wordpressAdminBarHeight = 30;
        return windowHeight - headerHeight - wordpressAdminBarHeight;
    }

    render() {
        this.props.componentElement.setReactComponent(this);
        let classes = classnames({
            '--active': this.isActive(),
            [this.props.componentElement.getId().replace('highwaypro.', '').toLowerCase()]: true
        });
        return (
            <div className={`hp-destination-component-menu-item-content ${classes}`} ref={this.element} style={{maxHeight: this.getMaxHeight()}}>
                <header>
                    <div className="hp-image">
                        <Button classes="hp-back" icon={<ArrowBackRounded />} whenClicked={this.handleConfirmationButton.bind(this, 'back')}>
                            {HighWayPro.text.other.goBack}
                        </Button>
                        {this.props.type.toLowerCase() === 'condition'? (<TrafficRounded />) : <SendRounded />}
                    </div>
                    <h1>{this.props.componentElement.title} {_.startCase(this.props.type)}</h1>
                </header>
                <div className="content">
                    <div className="hp-help-text">
                        {this.props.componentElement.getText().split("\n").map(text => <p>{text}</p>)}
                    </div>
                    <div className="hp-inputs">
                        {this.props.componentElement.getContent()}
                    </div>
                </div>
                <footer>
                    <Button classes="hp-cancel" whenClicked={this.handleConfirmationButton.bind(this, 'cancel')}>
                        {HighWayPro.text.other.cancel}
                    </Button>
                    <Button classes="hp-ok" whenClicked={this.handleConfirmationButton.bind(this, 'ok')}>
                        {HighWayPro.text.other.ok}
                    </Button>
                </footer>
            </div>
        );
    }
}

export default DestinationComponentMenuItemContent;