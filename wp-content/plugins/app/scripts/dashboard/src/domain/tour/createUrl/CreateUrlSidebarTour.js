import { CreateUrlWindowInputTour } from './CreateUrlWindowInputTour';
import { DashboardTour } from '../DashboardTour';
import { Events } from '../../behaviour/events/events/Events';
import { HighWayPro } from '../../highwaypro/HighWayPro';
import CreateUrlWindow from
  '../../../components/panels/windows/Urls/CreateUrlWindow';

export class CreateUrlSidebarTour
{
    steps = [
        {
            element: ".hp-panel-window-urls .hp-add-url",
            title: HighWayPro.text.tour.CreateUrlSidebarTour[1].title,
            content: HighWayPro.text.tour.CreateUrlSidebarTour[1].message,
            reflex: true,
            template: `
            <div class='popover tour'>
                <div class='arrow'></div>
                <div class="popover-container">
                    <h3 class='popover-title'></h3>
                    <div class='popover-content'></div>
                    <div class='popover-navigation'>
                        <button class='btn btn-default btn-next' data-role='next'>Next »</button>
                    </div>
                </div>                
            </div>`,
            onHide: () => {
                Events.register({
                    name: CreateUrlWindow.EVENTS.AFTER_OPEN,
                    handler: this.handleWindowHasBeenOpened.bind(this)
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

    start() 
    {
        this.tour.start(true);
    }

    static start() 
    {
        // don't leave references
        (new CreateUrlSidebarTour).start();
    }

    handleWindowHasBeenOpened(data, eventName) 
    {
        if (!this.inputTourIsActive) {
            const createUrlWindowInputTour = new CreateUrlWindowInputTour;

            this.inputTourIsActive = true;

            createUrlWindowInputTour.start();

            Events.unregisterAllWithName(eventName);
        }
    }
}