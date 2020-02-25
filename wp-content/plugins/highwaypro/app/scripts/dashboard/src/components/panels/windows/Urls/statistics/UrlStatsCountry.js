import './UrlStatsCountry.css';

import React, {Component} from 'react';

import { HighWayPro } from '../../../../../domain/highwaypro/HighWayPro';
import BarChart from './BarChart';
import CustomPieChart from './CustomPieChart';
import IconWithText from '../../../../icons/IconWithText';
import NotEnoughData from './NotEnoughData';

class UrlStatsCountry extends Component {
    data = [
            {
                "total": 3,
                "location_country": 'United States',
                "percentage": 92.3076923076923
            },
            {
                "total": 1,
                "location_country": 'Mexico',
                "percentage": 7.8757648648474
            },
            {
                "total": 1,
                "location_country": 'Canada',
                "percentage": 10
            },
            {
                "total": 1,
                "location_country": 'United kingdom',
                "percentage": 2
            },
            {
                "total": 1,
                "location_country": 'Andorra',
                "percentage": 2
            },
            {
                "total": 1,
                "location_country": 'Paraguay',
                "percentage": 2
            },
            {
                "total": 1,
                "location_country": 'Bulgaria',
                "percentage": 2
            },
            {
                "total": 1,
                "location_country": 'United Arab Emirates',
                "percentage": 2
            },
            {
                "total": 1,
                "location_country": '__na__',
                "percentage": 2
            },
            {
                "total": 1,
                "location_country": 'United Arab Emirates',
                "percentage": 2
            },
            {
                "total": 1,
                "location_country": 'United Arab Emirates',
                "percentage": 2
            },
            {
                "total": 1,
                "location_country": 'United Arab Emirates',
                "percentage": 2
            },
            {
                "total": 1,
                "location_country": 'United Arab Emirates',
                "percentage": 2
            },
        ];

    render() {
        if (!this.props.data || !this.props.data.length) {
            return <NotEnoughData statsType="country"/>
        }

        return (
            <div className="hp-url-stats-country-container hp-stats-box">
                <div className="hp-box-heading">
                    <h1>{HighWayPro.text.analytics.countryClicksTitle}</h1>
                    <p>{HighWayPro.text.analytics.countryClicksMessage}</p>
                </div>
                <BarChart data={this.props.data} field={{name: 'location_country', value: 'percentage'}}/>
            </div>
        );
    }
}

export default UrlStatsCountry;