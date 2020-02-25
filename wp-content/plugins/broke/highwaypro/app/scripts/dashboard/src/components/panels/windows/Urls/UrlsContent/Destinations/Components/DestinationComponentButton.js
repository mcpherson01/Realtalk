import './DestinationComponentButton.css';

import React, {Component} from 'react';

import {
  BuiltInComponent,
} from '../../../../../../../domain/destinationcomponents/builtin/BuiltInComponent';
import {
  EmptyBuiltInComponent,
} from '../../../../../../../domain/destinationcomponents/builtin/EmptyBuiltInComponent';

class DestinationComponentButton extends Component {

    getDefaultsFrom = component => {
        if (!(component instanceof BuiltInComponent)) {
            return new EmptyBuiltInComponent;
        }

        return component;
    }
    
    render() {
        const component = this.getDefaultsFrom(this.props.selectedComponent);
        return (
            <button className="hp-destination-component-button" onClick={event => event.button === 0 && this.callOpenHandler(event)}>
                <p className="hp-destination-component-button-type">
                    {this.props.type}
                </p>
                <p className="hp-destination-component-button-name">
                    {component.title}
                </p>
                <p className="hp-destination-component-button-value">
                    {component.getValuesAsPreview()}
                </p>
            </button>
        );
    }

    callOpenHandler(event) 
    {
        this.props.whenClicked(this.getButtonCoordinates(event.target));
    }

    getButtonCoordinates(targetButtonElement) 
    {
        const bodyRect = document.body.getBoundingClientRect();
        const targetButtonCoordinates = targetButtonElement.getBoundingClientRect();

        return {
            top: targetButtonCoordinates.top - bodyRect.top,
            left: targetButtonCoordinates.left - bodyRect.left,
            viewportTop: targetButtonCoordinates.top,
            viewportLeft: targetButtonCoordinates.left,
            width: targetButtonCoordinates.width,
            height: targetButtonCoordinates.height
        }
    }
}

export default DestinationComponentButton;