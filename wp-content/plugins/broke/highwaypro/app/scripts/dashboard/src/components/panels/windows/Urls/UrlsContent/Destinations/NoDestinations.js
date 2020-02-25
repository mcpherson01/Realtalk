import './NoDestinations.css';

import EvStationRounded from '@material-ui/icons/EvStationRounded';
import React, {Component} from 'react';

import { HighWayPro } from '../../../../../../domain/highwaypro/HighWayPro';
import IconWithText from '../../../../../icons/IconWithText';

class NoDestinations extends Component {
    render() {
        return (
            <div className="hp-url-destination --no-destinations">
                <div className="hp-content">
                    <IconWithText 
                        icon={<EvStationRounded />}
                        title={HighWayPro.text.destinations.noDestinationsTitle} 
                        text={HighWayPro.text.destinations.noDestinationsMessage}
                    />
                </div>
            </div>
        );
    }
}

export default NoDestinations;