import './DestinationComponent.css';

import React, {Component} from 'react';

import {
  DestinationComponentsManager,
} from '../../../../../../../domain/destinationcomponents/DestinationComponentsManager';
import {
  Observer,
} from '../../../../../../../domain/behaviour/events/observer/Observer';
import DestinationComponentButton from './DestinationComponentButton';
import DestinationComponentMenu from './DestinationComponentMenu';

class DestinationComponent extends Component {
    state = {
        isOpened: false,
        coordinates: {},
        selectedComponent: {}
    }

    constructor(properties) {
        super(properties);

        this.componentsManager = new DestinationComponentsManager(this.props.type);
    }

    getSelectedComponent() 
    {
        return this.componentsManager.getByType(this.props.component.type);
    }

    handleOpeningButtonClick = (coordinates) => {
        this.open(coordinates);
    }

    handleNotOpened = () => {
        
    }

    open = coordinates => {
        this.setState({
            isOpened: true,
            coordinates
        });
    }

    close = () => {
        this.setState({
            isOpened: false
        });

        this.props.whenClosed()
    }

    render() {
        let componentElements = this.componentsManager.getAll(this.props.component);
        return (
            <div className="destination-component">
                <DestinationComponentButton {...this.props} selectedComponent={this.props.component} whenClicked={this.handleOpeningButtonClick}/>
                <DestinationComponentMenu 
                    componentElement={this.props.component} 
                    destination={this.props.destination} 
                    type={this.props.type} 
                    isOpened={this.state.isOpened} 
                    coordinates={this.state.coordinates}
                    componentElements={componentElements} 
                    parent={this}
                />
            </div>
        );
    }
}

export default DestinationComponent;