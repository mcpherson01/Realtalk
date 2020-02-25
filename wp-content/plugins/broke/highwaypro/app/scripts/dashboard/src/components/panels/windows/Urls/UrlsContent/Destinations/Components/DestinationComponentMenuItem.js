import classnames from 'classnames';

import './DestinationComponentMenuItem.css';

import React, {Component} from 'react';

class DestinationComponentMenuItem extends Component {
    render() {
        const classes = classnames({
            'hp-destination-component-menu-item': true,
        });

        const componentElement = this.props.componentElement;
        const Icon = componentElement.icon;
        return (
            <div className={classes}>
                <button className={`hp-destination-component-menu-item-button ${componentElement.getId().replace('highwaypro.', '').toLowerCase()}`} onClick={() => {this.props.whenClicked(componentElement.getId())}}>
                    <div className="hp-icon">
                        {Icon && Icon}
                    </div>
                    <div className="hp-hp-destination-component-menu-item-button-text">
                        <h1>{componentElement.title}</h1>
                        <p>{componentElement.shortDescription}</p>
                    </div>
                </button>
            </div>
        );
    }
}

export default DestinationComponentMenuItem;