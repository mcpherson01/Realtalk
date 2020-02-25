import React, {Component} from 'react';
import './IconWithText.css';

class IconWithText extends Component {
    render() {
        return (
            <div className={`hp-icon-with-text ${this.props.classes}`}>
                <div className="hp-icon">
                    {this.props.icon}
                </div>
                <div className="hp-text">
                    <span className="hp-icon-text-title">{this.props.title}</span>
                    {this.props.text && <p>{this.props.text}</p>}
                </div>
            </div>
        );
    }
}

export default IconWithText;