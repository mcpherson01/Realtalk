import './UrlDestination.css';

import ClickAwayListener from '@material-ui/core/ClickAwayListener';
import CloseRounded from '@material-ui/icons/CloseRounded';
import IconButton from '@material-ui/core/IconButton';
import KeyboardBackspaceRounded from '@material-ui/icons/KeyboardBackspaceRounded';
import LowPriorityRounded from '@material-ui/icons/LowPriorityRounded';
import React, {Component} from 'react';
import TripOriginRounded from '@material-ui/icons/TripOriginRounded';
import classnames from 'classnames';

import { HighWayPro } from '../../../../../domain/highwaypro/HighWayPro';
import {
  Observer,
} from '../../../../../domain/behaviour/events/observer/Observer';
import DestinationComponent from
  './Destinations/Components/DestinationComponent';
import Id from '../../../../icons/Id';
import Notifications from '../../../../notifications/Notifications';

class UrlDestination extends Component {
    state = {
        deleteConfirmationIsOpened: false,
        beingDragged: false
    }

    openDeleteConfirmation = (isOpened) => 
    {
        this.setState({
            deleteConfirmationIsOpened: isOpened
        });
    }

    showMessages = (response) => {
        Notifications.openLoadingNotification(false);
        Notifications.addFromResponse(response);    
        this.openDeleteConfirmation(false);
    }

    deleteDestination = () => {
        Notifications.openLoadingNotification(true, HighWayPro.text.other.deleting);
        // call to update state is managed by the url (updates observers)
        this.props.url.deleteDestination(this.props.destination)
                      .then(this.showMessages);
    }

    handleClickAway = () => {
        if (this.state.deleteConfirmationIsOpened) {
            this.openDeleteConfirmation.bind(this, false);
        }
    }

    componentDidMount()
    {
        this.props.destination.add(new Observer(destination => {
            this.forceUpdate();
        }))
    }

    render() {
        return (
            <div className={classnames({'hp-url-destination': true})}>
                <div className="hp-destination-id">
                    <Id id={`${this.props.url.id}-${this.props.index}`} />
                </div>
                <div className="hp-destination-separator">
                    <TripOriginRounded />
                    <div className="vertical-separator"> </div>
                </div>
                <div className="hp-destination-condition">
                    <DestinationComponent type="condition" destination={this.props.destination} component={this.props.destination.condition || {}} whenClosed={this.forceUpdate.bind(this)}/>
                </div>
                <div className="destination-conditon-to-target-icon">
                    <KeyboardBackspaceRounded />
                </div>
                <div className="hp-destination-target">
                    <DestinationComponent type="target" destination={this.props.destination} component={this.props.destination.target || {}} whenClosed={this.forceUpdate.bind(this)}/>
                </div>
                <div className="hp-destination-actions">
                    <div className="re-order">
                        {/*coming soon...*/false && (<IconButton>
                            <LowPriorityRounded />
                        </IconButton>)}
                        <IconButton onClick={this.openDeleteConfirmation.bind(this, true)}>
                            <CloseRounded />
                        </IconButton>
                        <ClickAwayListener onClickAway={this.handleClickAway}>
                            <div onClick={this.deleteDestination} className={classnames({'hp-delete-confirmation': true, '--active': this.state.deleteConfirmationIsOpened})}>
                                Delete
                            </div>
                        </ClickAwayListener>
                    </div>
                </div>
            </div>
        );
    }
}

export default UrlDestination;