import React, {Component} from 'react';
import './ContentHeaderTitle.css';

class ContentHeaderTitle extends Component {
    render() {
        return (
            <h1 className="hp-url-content-header-title">{this.props.title}</h1>
        );
    }
}

export default ContentHeaderTitle;