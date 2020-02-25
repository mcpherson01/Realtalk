import './UrlStatsOrigin.css';

import React, {Component} from 'react';

import { HighWayPro } from '../../../../../domain/highwaypro/HighWayPro';
import BarChart from './BarChart';
import CustomPieChart from './CustomPieChart';
import MultiBarChart from './MultiBarChart';
import NotEnoughData from './NotEnoughData';

class UrlStatsOrigin extends Component {
    data = [
            {
                "total": 3,
                "device_referer": 'https://app.bitly.com/Bc49l3kpdCW/bitlinks/2WJJvdb',
                "percentage": 39
            },
            {
                "total": 1,
                "device_referer": 'Desktop',
                "percentage": 28
            },
            {
                "total": 1,
                "device_referer": 'https://www.blackhatworld.com/seo/journey-road-to-500-day.1110656/',
                "percentage": 14
            },
            {
                "total": 1,
                "device_referer": 'https://www.google.com/search?q=how+to+do+redicetions+properly',
                "percentage": 7
            },
            {
                "total": 1,
                "device_referer": 'https://www.google.com/',
                "percentage": 7
            },
            {
                "total": 1,
                "device_referer": 'N/A',
                "percentage": 7
            },
        ];

    render() {
        if (!this.props.data || !this.props.data.length) {
            return <NotEnoughData statsType="origin" />
        }
        return (
            <div className="hp-url-stats-origin-container hp-stats-box --withDivisions">
                <div className="hp-box-heading">
                    <h1>{HighWayPro.text.analytics.originClicksTitle}</h1>
                    <p>{HighWayPro.text.analytics.originClicksMessage}</p>
                </div>
                <div className="stat-content">
                    <CustomPieChart data={this.props.data} 
                                    field={{name: 'device_referer'}} 
                                    innerRadius={1}
                                    width={250} 
                                    height={250}
                                    colors={['#bbbc3f', '#00b0f4', '#1368bb', '#31c5b9', '#ffcd26', '#b6d0e0']}
                    />
                </div>
            </div>
        );
    }
}

export default UrlStatsOrigin;