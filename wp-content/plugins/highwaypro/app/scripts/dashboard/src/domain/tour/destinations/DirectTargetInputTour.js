import $ from 'jquery';
import delay from 'delay';

import { DashboardTour } from '../DashboardTour';
import { Events } from '../../behaviour/events/events/Events';
import { HighWayPro } from '../../highwaypro/HighWayPro';
import { ViewUrlTour } from '../urlContent/ViewUrlTour';
import DestinationComponentMenu from
  '../../../components/panels/windows/Urls/UrlsContent/Destinations/Components/DestinationComponentMenu';

export class DirectTargetInputTour
{
    steps = [
        {
            element: ".hp-destination-component-menu-item-content.directtarget input",
            title: HighWayPro.text.tour.DirectTargetInputTour[1].title,
            content: HighWayPro.text.tour.DirectTargetInputTour[1].message,
            reflex: true,
            placement: 'top',
            backdrop: false,
            backdropPadding: 20,
            onShow: async () => {
                await delay(10);

                $('.hp-destination-component-menu-item-content.directtarget input').focus();
            },
            onHide: () => {
                //Events.register({
                //    name: DestinationComponentMenu.EVENTS.FINISHED_OPENING_ITEM_CONTENT,
                //    handler: this.handleComponentMenuHasBeenOpened.bind(this)
                //})
            }
        },
        {
            element: ".hp-destination-component-menu-item-content.directtarget .hp-ok",
            title: HighWayPro.text.tour.DirectTargetInputTour[2].title,
            content: HighWayPro.text.tour.DirectTargetInputTour[2].message,
            reflex: true,
            placement: 'top',
            backdrop: false,
            backdropPadding: 20,
            onHide: () => {
                Events.register({
                    name: DestinationComponentMenu.EVENTS.FINISHED_CLOSING,
                    handler: this.handleComponentMenuHasBeenClosed.bind(this)
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

    handleComponentMenuHasBeenClosed(data, eventName) 
    {
        if (!this.viewUrlTour) {
            this.viewUrlTour = new ViewUrlTour;

            this.viewUrlTour.start();

            Events.unregisterAllWithName(eventName);
        }
    }

    start() 
    {
        this.tour.start(true);
    }
}