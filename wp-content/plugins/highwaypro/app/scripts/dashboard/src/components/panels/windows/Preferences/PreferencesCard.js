import './UrlPreferencesCard.css';

import { Component } from 'react';

import { Callable } from '../../../../domain/utilities/Callable';
import { HighWayPro } from '../../../../domain/highwaypro/HighWayPro';
import Notifications from '../../../notifications/Notifications';
import Preferencespanelwindow from '../Preferencespanelwindow';

class PreferencesCard extends Component {
    static cardTitle = '';
    static cardText = '';

    preferencesType = '';

    updateLoadedPreferences = (response) => 
    {
        return Preferencespanelwindow.setPreferences(response.preferences);
    }

    getPreferences() 
    {
        return this.props.preferences[this.preferencesType]
    }

    handleChange = preferenceName => event => {
        this.getPreferences().setField({
            field: preferenceName,
            value: event.target.value
        });

        this.savePreference(preferenceName);
    }

    showNotification = (response: object) => 
    {
        Notifications.addFromResponse(response);
        Notifications.openLoadingNotification(false);
    }

    toggle = (preferenceName, then) => event =>
    {
        this.getPreferences().setField({
            field: preferenceName,
            value: (previousValue => !previousValue)
        });

        this.savePreference(preferenceName, then)
    }

    savePreference(preferenceName, then) 
    {
        Notifications.openLoadingNotification(true, HighWayPro.text.other.saving);

        this.getPreferences().save(preferenceName)
            .then(Callable.callAndReturnArgument(this.updateLoadedPreferences))
            .then(Callable.callAndReturnArgument(then || (() => {})))
            .catch(Callable.callAndReturnArgument(() => {
            }))
            .then(Callable.callAndReturnArgument(this.showNotification));
    }


    render() {
        return (
            ''
        );
    }
}

export default PreferencesCard;