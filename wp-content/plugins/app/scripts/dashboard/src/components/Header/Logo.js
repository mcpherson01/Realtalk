import './Logo.css';

import React, {Component} from 'react';

import { HighWayPro } from '../../domain/highwaypro/HighWayPro';

class Logo extends Component {
    render() {
        return (
            <div className="hp-logo">
                <img src={`${HighWayPro.urls.branding}/logo-main.png`} alt="HighWayPro"/>
            </div>
        );
    }
}

export default Logo;