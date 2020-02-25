import './SocialPreferencesCard.css';

import FormControlLabel from '@material-ui/core/FormControlLabel';
import FormHelperText from '@material-ui/core/FormHelperText';
import React from 'react';

import { DashboardTour } from '../../../../domain/tour/DashboardTour';
import { HighWayPro } from '../../../../domain/highwaypro/HighWayPro';
import PreferencesCard from './PreferencesCard';

class DashboardPreferencesCard extends PreferencesCard {
    static cardTitle = 'Dashboard';
    static cardText = '';

    preferencesType = 'dashboard';

    render() {
        return (
        <React.Fragment>
            <FormControlLabel
              control={
                 <button className="hp-button hp-button-in-card" onClick={this.startTour.bind(this)}>
                    {HighWayPro.text.preferences.dashboard.tourIsEnabled.button}
                 </button>
              }
              label={HighWayPro.text.preferences.dashboard.tourIsEnabled.label}
              labelPlacement="start"
              classes={{label: 'hp-hf-description'}}
            />
            <FormHelperText classes={{root: 'MuiFormHelperText'}}>{HighWayPro.text.preferences.dashboard.tourIsEnabled.description}</FormHelperText>
        </React.Fragment>
        );
    }

    startTour(updatedPreferences) 
    {
        const dashboardTour = new DashboardTour;

        dashboardTour.start();
    }
}

export default DashboardPreferencesCard;