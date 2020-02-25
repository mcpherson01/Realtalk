import './Panelwindows.css';

import React, {Component} from 'react';
import classnames from 'classnames';

import Header from '../../Header/Header';
import $ from 'jquery';

class Panelwindows extends Component {
    getWindowStyles = () => {
        return {
            //marginTop: this.state.headerHeight,
            height: window.innerHeight - ((60 * 2) + ($('#wpadminbar').outerHeight() || 0)),
            maxHeight: window.innerHeight - ((60 * 2) + ($('#wpadminbar').outerHeight() || 0)),
            overflow: this.props.overflow || 'auto',
            marginBottom: (this.props.activePanel && this.props.activePanel.marginBottom)? 20 : 0
        };
    }

    render() {
        return (
            <div className="hp-panel-windows">
                <div className="hp-panel-window-content" style={this.getWindowStyles()}>
                    {this.props.panels.map(panel => {
                        const isActive = this.props.activePanel.name === panel.name;
                        const classes = classnames({
                            'hp-panel-window': true,
                            [`hp-panel-window-${panel.name}`]: true,
                            '--active': isActive,
                        });
                        const Window = panel.window;

                        return <div className={classes}>{<Window isActive={isActive}/>}</div>
                    })}
                </div>
            </div>
        );
    }
}

export default Panelwindows;