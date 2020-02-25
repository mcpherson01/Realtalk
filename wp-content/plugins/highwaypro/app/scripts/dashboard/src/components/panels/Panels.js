import './Panels.css';

import AccountCircleRounded from '@material-ui/icons/AccountCircleRounded';
import PublicRounded from '@material-ui/icons/PublicRounded';
import PollRounded from '@material-ui/icons/PollRounded';
import React, {Component} from 'react';
import TripOriginRounded from '@material-ui/icons/TripOriginRounded';

import { HighWayPro } from '../../domain/highwaypro/HighWayPro';
import Header from '../Header/Header';
import OverviewPanelWindow from './windows/OverviewPanelWindow';
import PanelMenus from './Panelmenus';
import PanelWindows from './windows/Panelwindows';
import PreferencesPanelWindow from './windows/Preferencespanelwindow';
import TypesPanelWindow from './windows/Typespanelwindow';
import UrlsPanelWindow from './windows/Urlspanelwindow';

class Panels extends Component {
    instance = Panels;

    state = {
        activePanel: {
            name: HighWayPro.text.dashboardSectionMenu.overview
        },
        headerHeight: 0
    };

    panels = [
        {
            name: HighWayPro.text.dashboardSectionMenu.overview,
            id: 'overview',
            icon: <PollRounded />,
            window: OverviewPanelWindow,
            marginBottom: true
        },
        {
            name: HighWayPro.text.dashboardSectionMenu.urls,
            id: 'urls',
            icon: <PublicRounded />,
            window: UrlsPanelWindow
        },
        {
            name: HighWayPro.text.dashboardSectionMenu.types,
            id: 'types',
            icon: <TripOriginRounded />,
            window: TypesPanelWindow
        },
        {
            name: HighWayPro.text.dashboardSectionMenu.preferences,
            id: 'preferences',
            icon: <AccountCircleRounded />,
            window: PreferencesPanelWindow,
            marginBottom: true
        }
    ];

    setHeaderHeight = header => {
        this.setState({
            headerHeight: header.offsetHeight
        });
    }

    static openPanel(name) 
    {
        if (Panels.instance.state.activePanel !== name) {
            Panels.instance.setState({
                activePanel: Panels.instance.panels.filter(panel => panel.name === name)[0]
            });
        }
    }

    constructor(properties) {
        super(properties);
        Panels.instance = this;
    }

    menuClickHandler = panel => {
        this.setState(state => {
            return {
                activePanel: panel
            }
        })
    }

    render() {
        return (
            <div className="hp-panel">
                <Header whenRendered={this.setHeaderHeight}/>
                <PanelMenus 
                    panels={this.panels} 
                    activePanel={this.state.activePanel} 
                    handleClick={this.menuClickHandler}
                />
                <PanelWindows panels={this.panels} activePanel={this.state.activePanel}/>
            </div>
        );
    }
}

export default Panels;