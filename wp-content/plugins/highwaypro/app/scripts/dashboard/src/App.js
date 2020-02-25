import './App.css';

import $ from 'jquery';
import React, {Component} from 'react';

import { DashboardTour } from './domain/tour/DashboardTour';
import {
  DestinationComponentsManager,
} from './domain/destinationcomponents/DestinationComponentsManager';
import { UrlTypes } from './domain/data/finders/UrlTypes';
import Notifications from './components/notifications/Notifications';
import Panels from './components/panels/Panels';
import './App.css';
import './domain/tour/tour.css';

class App extends Component {
    state = {
        height: '100vh', // initial values...
        width: 'auto' // initial values...
    };

    constructor(properties)
    {
        super(properties);
        this.initializeAplication();
    }

    initializeAplication() 
    {
        console.log('---------- INITIALIZING APPLICATION HIGHWAYPRO ----------');
        UrlTypes.loadFromDatabase();
        new DestinationComponentsManager('');

        console.log('---------- INITIALIZATION END ----------');
    }

    componentDidMount()
    {
        this.setDimensions();
        
        window.addEventListener('resize', this.setDimensions.bind(this))

        if (DashboardTour.needsToBeShown()) {
            const dashboardTour = new DashboardTour;

            dashboardTour.start();
        }
    }

    render() {
        return (
            <div className="highwaypro" style={{
                height: this.state.height, 
                width: this.state.width
            }}>
                <Notifications />
                <Panels />
            </div>
        );
    }

    setDimensions() 
    {
        const newHeight = window.innerHeight - ($('#wpadminbar').outerHeight() || 0);
        const newWidth = window.innerWidth - ($('#adminmenuwrap').outerWidth() || 160);
        const isMobile = window.innerWidth < 1000;

        let width = {};

        if (isMobile && (this.state.width != '100%')) {
             width = {
                width: '100%',
                maxWidth: '100%'
            }
        } else if (!isMobile && (this.state.width != newWidth)) {
            width = {
                width: newWidth,
                maxWidth: newWidth
            }
        }

        this.setState(
            Object.assign(
                {}, 
                this.state.height != newHeight? {
                    height: newHeight,
                    maxHeight: newHeight
                } : {},
                width
            )
        );
    }
}

export default App;