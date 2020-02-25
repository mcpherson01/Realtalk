import './NotEnoughData.css';

import React, {Component} from 'react';
import ScoreRounded from '@material-ui/icons/ScoreRounded';

import { HighWayPro } from '../../../../../domain/highwaypro/HighWayPro';
import { Strings } from '../../../../../domain/utilities/Strings';
import IconWithText from '../../../../icons/IconWithText';

class NotEnoughData extends Component {
    render() {
        return (
            <div className="hp-not-enough-data">
                <IconWithText 
                    icon={<ScoreRounded />} 
                    title={HighWayPro.text.analytics.notEnoughDataTitle} 
                    text={HighWayPro.text.analytics[`notEnoughDataMessage${Strings.ucfirst(this.props.statsType)}`]}
                />
            </div>
        );
    }
}

export default NotEnoughData;