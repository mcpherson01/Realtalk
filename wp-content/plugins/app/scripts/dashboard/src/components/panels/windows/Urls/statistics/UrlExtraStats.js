import './UrlExtraStats.css';
import React, {Component} from 'react';

import CustomPieChart from './CustomPieChart';

class UrlExtraStats extends Component {
    render() {
        return (
            <div className="hp-url-extra-stats">
                <CustomPieChart />
            </div>
        );
    }
}

export default UrlExtraStats;