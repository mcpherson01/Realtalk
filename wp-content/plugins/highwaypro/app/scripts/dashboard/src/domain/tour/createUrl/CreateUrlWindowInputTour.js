import $ from 'jquery';
import delay from 'delay';

import { DashboardTour } from '../DashboardTour';
import { Events } from '../../behaviour/events/events/Events';
import { HighWayPro } from '../../highwaypro/HighWayPro';
import { UrlContentOverViewTour } from '../urlContent/UrlContentOverViewTour';
import Urlspanelwindow from
  '../../../components/panels/windows/Urlspanelwindow';

export class CreateUrlWindowInputTour
{
    steps = [
        {
            element: ".hp-create-url .create-url-field--name",
            title: HighWayPro.text.tour.CreateUrlWindowInputTour[1].title,
            content: HighWayPro.text.tour.CreateUrlWindowInputTour[1].message,
            reflex: false,
            onShow: () => $('.create-url-field--name input').focus()
        },
        {
            element: ".hp-create-url .create-url-field--path",
            title: HighWayPro.text.tour.CreateUrlWindowInputTour[2].title,
            content: HighWayPro.text.tour.CreateUrlWindowInputTour[2].message,
            reflex: false,
            onShow: () => $('.create-url-field--path input').focus()
        },
        {
            element: ".hp-create-url .hp-url-type-menu",
            title: HighWayPro.text.tour.CreateUrlWindowInputTour[3].title,
            content: HighWayPro.text.tour.CreateUrlWindowInputTour[3].message,
            reflex: false,
        },
        {
            element: ".hp-panel-window-urls .hp-create-button",
            title: HighWayPro.text.tour.CreateUrlWindowInputTour[4].title,
            content: HighWayPro.text.tour.CreateUrlWindowInputTour[4].message,
            placement: 'top',
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
            onHide: () => Events.register({
                name: Urlspanelwindow.EVENTS.URL_CREATED_AND_OPENED,
                handler: this.handleURLNewURLHasBeenOpened.bind(this)
            })
        },
    ];

    constructor() 
    {
        this.tour = DashboardTour.createTour({
            steps: this.steps
        });

        this.tour.init();
    }

    async handleURLNewURLHasBeenOpened(data, eventName) 
    {
        await delay(450);
        
        Events.unregisterAllWithName(eventName);

        (new UrlContentOverViewTour).start();
    }

    start() 
    {
        this.tour.start(true);
    }

    static start() 
    {
        const tour = new CreateUrlWindowInputTour;

        tour.start()
    }
}