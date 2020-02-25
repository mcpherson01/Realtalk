import { DashboardTour } from '../DashboardTour';
import { DirectTargetInputTour } from './DirectTargetInputTour';
import { Events } from '../../behaviour/events/events/Events';
import { HighWayPro } from '../../highwaypro/HighWayPro';
import DestinationComponentMenu from
  '../../../components/panels/windows/Urls/UrlsContent/Destinations/Components/DestinationComponentMenu';

export class TargetMenuListTour
{
    steps = [
        {
            element: ".hp-destination-component-menu-item-button.directtarget",
            title: HighWayPro.text.tour.TargetMenuListTour[1].title,
            content: HighWayPro.text.tour.TargetMenuListTour[1].message,
            reflex: true,
            placement: 'left',
            backdrop: true,
            backdropPadding: 20,
            onHide: () => {
                Events.register({
                    name: DestinationComponentMenu.EVENTS.FINISHED_OPENING_ITEM_CONTENT,
                    handler: this.handleComponentMenuHasBeenOpened.bind(this)
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

    handleComponentMenuHasBeenOpened(data, eventName) 
    {
        (new DirectTargetInputTour).start();

        Events.unregisterAllWithName(eventName);
    }

    start() 
    {
        this.tour.start(true);
    }
}