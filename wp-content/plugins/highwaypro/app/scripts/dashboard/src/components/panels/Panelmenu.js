import React, {Component} from 'react';
import classnames from 'classnames';
import './Panelmenu.css';

class Panelmenu extends Component {
    render() {
        const panel = this.props.panel;
        const classes = classnames({
            'hp-panel-menu': true,
            '--active': this.props.activePanel.name === panel.name,
            [`panel--${this.props.panel.id}`]: true
        });

        return (
            <li key={panel} className={classes} onMouseDown={this.props.whenClicked.bind(this, panel)}>
                <div className="hp-panel-icon">
                    {panel.icon}    
                </div>
                <div className="hp-panel-name">
                    {panel.name}
                </div>
            </li>
        );
    }
}

export default Panelmenu;