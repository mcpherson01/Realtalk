import React, {Component} from 'react';
import PanelMenu from './Panelmenu';
import './Panelmenus.css';

class Panelmenus extends Component {
    render() {
        return (
            <ul className="hp-panel-menus">
                {this.props.panels.map(panel => {
                    return (<PanelMenu panel={panel} activePanel={this.props.activePanel} whenClicked={this.props.handleClick}/>)
                })}
            </ul>
        );
    }
}

export default Panelmenus;