import $ from 'jquery';

import { DashboardTour } from '../DashboardTour';
import {
  DestinationOverViewTour,
} from '../destinations/DestinationOverViewTour';
import { Events } from '../../behaviour/events/events/Events';
import { HighWayPro } from '../../highwaypro/HighWayPro';
import UrlDestinations from
  '../../../components/panels/windows/Urls/UrlsContent/UrlDestinations';

export class UrlContentOverViewTour
{
    steps = [
        {
            element: ".hp-url-content-header",
            title: HighWayPro.text.tour.UrlContentOverViewTour[1].title,
            content: HighWayPro.text.tour.UrlContentOverViewTour[1].message,
            reflex: false,
            placement: 'bottom',
            backdrop: true,
            onShow: () => {}
        },
        {
            element: ".hp-url-tabs",
            title: HighWayPro.text.tour.UrlContentOverViewTour[2].title,
            content: HighWayPro.text.tour.UrlContentOverViewTour[2].message,
            reflex: false,
            placement: 'bottom',
            backdrop: true,
            onShow: () => {}
        },
        {
            element: ".hp-url-destinations",
            title: HighWayPro.text.tour.UrlContentOverViewTour[3].title,
            content: HighWayPro.text.tour.UrlContentOverViewTour[3].message,
            reflex: false,
            placement: 'top',
            backdrop: true,
            onShow: () => {}
        },
        {
            element: ".hp-url-preferences",
            title: HighWayPro.text.tour.UrlContentOverViewTour[4].title,
            content: HighWayPro.text.tour.UrlContentOverViewTour[4].message,
            reflex: false,
            placement: 'top',
            backdrop: true,
            onShow: () => {
                $(".hp-url-preferences").get(0).scrollIntoView();
            },
            onHide: () => $('.hp-url-content').scrollTop(0)
        },
        {
            element: ".hp-add-new-destination",
            title: HighWayPro.text.tour.UrlContentOverViewTour[5].title,
            content: HighWayPro.text.tour.UrlContentOverViewTour[5].message,
            reflex: true,
            placement: 'top',
            backdrop: false,
            onHide: () => {
                Events.register({
                    name: UrlDestinations.EVENTS.DESTINATIONS_RENDERED,
                    handler: this.handleDestinationsRendered.bind(this)
                })
            }
        },
    ];

    constructor() 
    {
        this.tour = DashboardTour.createTour({
            steps: this.steps
        });

        this.tour.init();
    }

    handleDestinationsRendered(data, eventName) 
    {
        if (!this.destinationOverViewTour) {
            this.destinationOverViewTour = new DestinationOverViewTour;

            this.destinationOverViewTour.start();

            Events.unregisterAllWithName(eventName);
        }
    }

    start() 
    {
        this.tour.start(true);
    }
}