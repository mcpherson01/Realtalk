import './UrlDestinations.css';

import AddCircleRounded from '@material-ui/icons/AddCircleRounded';
import React, {Component} from 'react';
import SubdirectoryArrowRightRounded from '@material-ui/icons/SubdirectoryArrowRightRounded';

import { Callable } from '../../../../../domain/utilities/Callable';
import { Events } from '../../../../../domain/behaviour/events/events/Events';
import { HighWayPro } from '../../../../../domain/highwaypro/HighWayPro';
import { Url } from '../../../../../domain/data/Url';
import Button from '../../../../Buttons/Button';
import NoDestinations from './Destinations/NoDestinations';
import Notifications from '../../../../notifications/Notifications';
import UrlDestination from './UrlDestination';
import UrlDestinationsLoading from './Destinations/UrlDestinationsLoading';

class UrlDestinations extends Component {

    static = () => {
        return UrlDestinations;
    }

    handleAddNewDestinationClick = () => {
        Notifications.openLoadingNotification(true);
        this.props.url.saveNewDestination()
                      .catch(Callable.callAndReturnArgument(Notifications.addFromResponse))
                      .then(Callable.callAndReturnArgument(Notifications.closeLoadingNotification));
    }

    componentDidUpdate()
    {
        if (this.props.url.hasNotLoadedDestinations() || !this.props.url.loadedDestinations.length) {
            return;
        }

        Events.call(
            UrlDestinations.EVENTS.DESTINATIONS_RENDERED, 
            this.props.url.loadedDestinations
        )
    }

    render() {
        if (this.props.url.hasNotLoadedDestinations()) {
            return <UrlDestinationsLoading />
        }

        let index = 'A';

        const destinations = this.props.url.loadedDestinations;

        if (this.props.url instanceof Url) {
            return (
                <div className="hp-url-destinations">
                    <div className="hp-url-destinations-box">
                        <h1 className="hp-url-destinations-title">Destinations</h1>
                        <div className="hp-url-destinations-arrow">
                            <SubdirectoryArrowRightRounded />
                        </div>
                        {destinations.map(destination => {
                            let component = (<UrlDestination 
                                                key={destination.id}
                                                url={this.props.url} 
                                                destination={destination} 
                                                index={index}
                                            />);
                            index = String.fromCharCode(index.charCodeAt() + 1);
                            return component;
                        })}
                        {!destinations.length? (<NoDestinations />) : ''}                     
                        <div className="destination-last-point">
                        {HighWayPro.text.destinations.lastConditionMessage}
                         </div>
                    </div>
                    <div className="hp-add-new-destination">
                        <Button whenClicked={this.handleAddNewDestinationClick} icon={<AddCircleRounded />}>
                            {HighWayPro.text.destinations.newDestination}
                        </Button>
                    </div>
                </div>
            );
        }
        
        
    }
}

UrlDestinations.EVENTS = {
    DESTINATIONS_RENDERED: 'UrlDestinations.events.destinations_rendered'
}

export default UrlDestinations;