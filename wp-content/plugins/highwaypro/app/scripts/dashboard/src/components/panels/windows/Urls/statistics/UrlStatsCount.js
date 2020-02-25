import './UrlStatsCount.css';

import React, {Component} from 'react';
import classNames from 'classnames';

import { HighWayPro } from '../../../../../domain/highwaypro/HighWayPro';
import UrlStatsDailyChart from './UrlStatsDailyChart';

class UrlStatsCount extends Component {

    classes = {
        current: '--hp-current'
    };

    render() {
        return (
            <div className="hp-url-stats-count-container hp-stats-box">
                <div className="hp-box-heading">
                    <h1>{HighWayPro.text.analytics.clicksOverviewTitle}</h1>
                    <p>{HighWayPro.text.analytics.clicksOverviewMessage}</p>
                </div>
                {this.getData().map((stat, index) => (
                    <div key={stat.key} className={`hp-url-stats-count ${index === 0 && this.classes.current}`}>
                        <div className="hp-stat-count-type">
                            {stat.type}
                        </div>
                        <div className="hp-stat-count-number">
                            {stat.count}
                        </div>
                    </div>
                ))}
                <UrlStatsDailyChart data={this.props.data.dailyCount.past30days}/>
            </div>
        );
    }

    getData() 
    {
        const defaultStats = [
            {
                type: HighWayPro.text.analytics.allTimeLabel,
                key: 'allTime',
                count: 0,
            },
            {
                type: HighWayPro.text.analytics.todayLabel,
                key: 'today',
                count: 0
            },
            {
                type: HighWayPro.text.analytics.lastDayLabel,
                key: 'lastDay',
                count: 0
            },
            {
                type: HighWayPro.text.analytics.thisMonthLabel,
                key: 'thisMonth',
                count: 0
            }
        ];

        return defaultStats.map(defaultStat => (
            Object.assign(defaultStat, {
                count: this.props.data.count[defaultStat.key] || defaultStat.count
            })
        ));
    }
}

export default UrlStatsCount;