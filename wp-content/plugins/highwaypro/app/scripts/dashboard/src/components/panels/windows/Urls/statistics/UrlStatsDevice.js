import './UrlStatsDevice.css';

import React, {Component} from 'react';

import { HighWayPro } from '../../../../../domain/highwaypro/HighWayPro';
import BarChart from './BarChart';
import CustomPieChart from './CustomPieChart';
import NotEnoughData from './NotEnoughData';

class UrlStatsDevice extends Component {
    data = [
            {
                "total": 3,
                "device_type": 'Mobile',
                "percentage": 39
            },
            {
                "total": 1,
                "device_type": 'Desktop',
                "percentage": 28
            },
            {
                "total": 1,
                "device_type": 'Tablet',
                "percentage": 14
            },
            {
                "total": 1,
                "device_type": 'N/A',
                "percentage": 7
            },
        ];

    render() {
        if (!this.props.data || !this.props.data.length) {
            return <NotEnoughData statsType="device"/>
        }
        return (
            <div className="hp-url-stats-device-container hp-stats-box --withDivisions">
                <div className="hp-box-heading">
                    <h1>{HighWayPro.text.analytics.deviceClicksTitle}</h1>
                    <p>{HighWayPro.text.analytics.deviceClicksMessage}</p>
                </div>
                <div className="stat-content">
                    <CustomPieChart data={this.props.data} field={{name: 'device_type'}} width={250} height={250}/>
                </div>
            </div>
        );
    }
}

export default UrlStatsDevice;