import './UrlDestinationsLoading.css';

import OfflineBoltRounded from '@material-ui/icons/OfflineBoltRounded';
import React, {Component} from 'react';

import { HighWayPro } from '../../../../../../domain/highwaypro/HighWayPro';
import IconWithText from '../../../../../icons/IconWithText';

class UrlDestinationsLoading extends Component {
    render() {
        return (
            <div className="hp-destinations-loading">
                <IconWithText icon={this.props.icon || <OfflineBoltRounded />} title={this.props.title || `${HighWayPro.text.destinations.loading}...`} />
            </div>
        );
    }
}

export default UrlDestinationsLoading;