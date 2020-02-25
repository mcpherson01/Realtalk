import React, {Component} from 'react';
import './CustomChartToolTip.css';

class CustomChartToolTip extends Component {
    render() {
        return (
            <div className="hp-custom-chart-tool-tip">
                <div className="hp-cc-day">
                    {this.props.day.date}
                </div>
                <div className="hp-cc-total">
                    {this.props.day.total}
                </div>
            </div>
        );
    }
}

export default CustomChartToolTip;