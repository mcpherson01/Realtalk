import { DashboardTour } from '../DashboardTour';
import { Events } from '../../behaviour/events/events/Events';
import { HighWayPro } from '../../highwaypro/HighWayPro';
import { TargetMenuListTour } from './TargetMenuListTour';
import DestinationComponentMenu from
  '../../../components/panels/windows/Urls/UrlsContent/Destinations/Components/DestinationComponentMenu';

export class DestinationOverViewTour
{
    steps = [
        {
            element: ".hp-url-destination",
            title: HighWayPro.text.tour.DestinationOverViewTour[1].title,
            content: HighWayPro.text.tour.DestinationOverViewTour[1].message,
            reflex: false,
            placement: 'left',
            backdrop: true,
            backdropPadding: 20,
            onShow: () => {}
        },
        {
            element: ".hp-destination-target",
            title: HighWayPro.text.tour.DestinationOverViewTour[2].title,
            content: HighWayPro.text.tour.DestinationOverViewTour[2].message,
            reflex: true,
            placement: 'top',
            backdrop: false,
            onHide: () => {
                Events.register({
                    name: DestinationComponentMenu.EVENTS.FINISHED_OPENING,
                    handler: this.handleComponentMenuHasBeenOpened.bind(this)
                })
            }
        }
    ];

    constructor() 
    {
        this.tour = DashboardTour.createTour({
            steps: this.steps
        });

        this.tour.init();
    }

    handleComponentMenuHasBeenOpened(eventData, eventName) 
    {
        const type = typeof eventData === 'object'? eventData.type : '';

        if (type === 'target') {
            (new TargetMenuListTour).start();

            Events.unregisterAllWithName(eventName);
        }
    }

    start() 
    {
        this.tour.start(true);
    }
}