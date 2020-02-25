import './Notifications.css';

import React, {Component} from 'react';

import { HighWayPro } from '../../domain/highwaypro/HighWayPro';
import Notification from './Notification';

class Notifications extends Component {
    static instance;

    componentDidMount() { Notifications.instance = this; }

    state = {
        notifications: [],
        openedNotifications: [],
        loadingIsOpened: false,
        loadingText: HighWayPro.text.other.loading
    };

    static defaultNotification = {
        message: '',
        extraData: {},
        type: ''
    };

    static openLoadingNotification = (isOpened, text) => {
        Notifications.instance.setState({
            loadingIsOpened: isOpened,
            loadingText: text || HighWayPro.text.other.loading
        })
    }

    static closeLoadingNotification() 
    {
        Notifications.instance.setState({
            loadingIsOpened: false
        })
    }

    static addFromResponse = (response) => {
        Notifications.add({
            message: response.message,
            type: response.state,
            extraData: response
        });

        Notifications.openLoadingNotification(false);
    }

    static add = (notificationData) => 
    {
        Notifications.instance.setState(state => {
            [state.notifications, state.openedNotifications].forEach(notifications => {
                notifications.push(Object.assign(Notifications.defaultNotification, notificationData));
            });

            return state;
        })
    }

    close = (notification) => {
        this.setState(state => {            
            return {
                openedNotifications: state.notifications.filter(openedNotification => notification !== openedNotification)
            };
        })
    }

    isOpened = (notification) => 
    {
        return this.state.openedNotifications.filter(openedNotification => notification === openedNotification).length > 0;
    }

    render() {
        return (
            <React.Fragment>
                <Notification message={`${this.state.loadingText}...`} className="hp-loading" open={this.state.loadingIsOpened}/>
                {this.state.notifications.map((notification) => {
                    return <Notification message={notification.message} messageObject={notification.extraData} open={this.isOpened(notification)} whenClose={this.close.bind(this, notification)} type={notification.type}/>
                })}
            </React.Fragment>
        );
    }
}

export default Notifications;