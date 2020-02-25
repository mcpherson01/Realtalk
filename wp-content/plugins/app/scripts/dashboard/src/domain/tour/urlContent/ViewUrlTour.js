import $ from 'jquery';

import { DashboardTour } from '../DashboardTour';
import { HighWayPro } from '../../highwaypro/HighWayPro';

export class ViewUrlTour
{
    steps = [
        {
            element: ".hp-view",
            title: HighWayPro.text.tour.ViewUrlTour[1].title,
            content: HighWayPro.text.tour.ViewUrlTour[1].message,
            reflex: true,
            placement: 'bottom',
            backdrop: false,
            backdropPadding: 20,
            onShow: () => {
                $('.hp-url-content').scrollTop(0)
            },
            onHide: () => {
                //Events.register({
                //    name: DestinationComponentMenu.EVENTS.FINISHED_OPENING_ITEM_CONTENT,
                //    handler: this.handleComponentMenuHasBeenOpened.bind(this)
                //})
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

    start() 
    {
        this.tour.start(true);
    }
}