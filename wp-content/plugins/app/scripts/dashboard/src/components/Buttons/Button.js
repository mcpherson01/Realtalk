import React, {Component} from 'react';
import './Button.css';

class Button extends Component {
    getOptionalIcon = () => {
        if (this.props.icon) {
            return (<span className="hp-icon">{this.props.icon}</span>);
        }
    }
    render() {
        let classes = [
            'hp-button',
            `--style-${this.props.style || 'default'}`,
            this.props.classes || ''
        ].join(' ');

        const width = (typeof this.props.width === 'number')? {
            width: `${this.props.width}%`
        } : {};
        
        return (
            <button className={classes} onClick={this.props.whenClicked} style={width}>
                {this.getOptionalIcon()}
                {this.props.children}
            </button>
        );
    }
}

export default Button;