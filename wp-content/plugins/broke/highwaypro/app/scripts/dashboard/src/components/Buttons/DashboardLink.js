import React, {Component} from 'react';
import './DashboardLink.css';

class DashboardLink extends Component {
    render() {
        return (
            <a className={this.props.className} href={this.props.href} target="_blank">{this.props.children}</a>
        );
    }
}

export default DashboardLink;