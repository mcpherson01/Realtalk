import './UrlStatistics.css';

import InsertChartRounded from '@material-ui/icons/InsertChartRounded';
import React, {Component} from 'react';

import { HighWayPro } from '../../../../../domain/highwaypro/HighWayPro';
import { Strings } from '../../../../../domain/utilities/Strings';
import IconWithText from '../../../../icons/IconWithText';
import UrlDestinationsLoading from
  '../UrlsContent/Destinations/UrlDestinationsLoading';
import UrlExtraStats from './UrlExtraStats';
import UrlStatsCount from './UrlStatsCount';
import UrlStatsCountry from './UrlStatsCountry';
import UrlStatsDailyChart from './UrlStatsDailyChart';
import UrlStatsDevice from './UrlStatsDevice';
import UrlStatsOrigin from './UrlStatsOrigin';

class UrlStatistics extends Component {
    render() {
        return (
            <React.Fragment>
                <div className={`hp-url-statistics ${this.isCompact() ? '--compact' : '--default'}`}>
                    {this.getLayout()}
                </div>
            </React.Fragment>
        );
    }

    getLayout() 
    {
        if (!this.props.hasLoaded) {
            return <UrlDestinationsLoading icon={(<InsertChartRounded />)} title={HighWayPro.text.analytics.loadingMessage}/>;
        }

        const data = this.props.getData();

        if (this.isCompact()) {
            return (
                <React.Fragment>
                    <div className="hp-row">
                        <UrlStatsCount data={data.statistics}/>
                    </div>
                    <div className="hp-row">
                        <div className="hp-col hp-col--countries">
                            <UrlStatsCountry data={data.statistics.countByField.countries} />
                        </div>
                        <div className="hp-col hp-col--wide">
                            <UrlStatsDevice data={data.statistics.countByField.devices} />
                            <UrlStatsOrigin data={data.statistics.countByField.origin}/>
                        </div>
                    </div>
                </React.Fragment>
            )
        } else {
            return (
                <React.Fragment>
                    <div className="hp-row">
                        <UrlStatsCount data={data.statistics}/>
                        <UrlStatsCountry data={data.statistics.countByField.countries} />
                    </div>
                    <div className="hp-row">
                        <UrlStatsDevice data={data.statistics.countByField.devices} />
                        <UrlStatsOrigin data={data.statistics.countByField.origin}/>
                    </div>
                </React.Fragment>
            )
        }
    }
    isCompact() 
    {
        return this.props.layout === 'compact'
    }
}

UrlStatistics.getFormattedName = function(name)
{
    if (name === HighWayPro.analytics.NA_KEY) {
        return HighWayPro.text.analytics.NA;
    }

    name = name || '';

    // capitalize name except for urls, not bullet proof but useful for now, YAGNI.
    return `${name}`.trim().indexOf('http') !== 0? Strings.ucfirst(name) : name;
}

UrlStatistics.getShortFormattedName = function(name)
{
    if (name === HighWayPro.analytics.NA_KEY) {
        return HighWayPro.text.analytics.NA_SHORT;
    }

    return name;
}
export default UrlStatistics;