import delay from 'delay';

import { Callable } from '../utilities/Callable';
import { CreateUrlSidebarTour } from './createUrl/CreateUrlSidebarTour';
import { HighWayPro } from '../highwaypro/HighWayPro';
import {Preferences} from '../data/Preferences';

export class DashboardTour
{
    static needsToBeShown() 
    {
        return HighWayPro.preferences.dashboard.tourIsEnabled;    
    }

    static createTour(options)
    {
        options = options || {};

        return new window.Tour(Object.assign({
            debug: true,
            steps: options.steps,
            storage: false,
            template: `
            <div class='popover tour'>
                <div class='arrow'></div>
                <div class="popover-container">
                    <h3 class='popover-title'></h3>
                    <div class='popover-content'></div>
                    <div class='popover-navigation'>
                        <button class='btn btn-default btn-next' data-role='next'>Next »</button>
                        <button class='btn btn-default btn-end' data-role='end'>End tour</button>
                    </div>
                </div>                
            </div>`,
        }, options));
    }

    steps = [
        {
            element: ".panel--overview",
            title: HighWayPro.text.tour.dashboard.tabs.overview.title,
            content: HighWayPro.text.tour.dashboard.tabs.overview.message
        },
        {
            element: ".panel--urls",
            title: HighWayPro.text.tour.dashboard.tabs.urls.title,
            content: HighWayPro.text.tour.dashboard.tabs.urls.message
        },
        {
            element: ".panel--types",
            title: HighWayPro.text.tour.dashboard.tabs.urlTypes.title,
            content: HighWayPro.text.tour.dashboard.tabs.urlTypes.message
        },
        {
            element: ".panel--preferences",
            title: HighWayPro.text.tour.dashboard.tabs.preferences.title,
            content: HighWayPro.text.tour.dashboard.tabs.preferences.message
        },
        {
            element: ".panel--urls",
            title: HighWayPro.text.tour.dashboard.startCreatingUrl.title,
            content: HighWayPro.text.tour.dashboard.startCreatingUrl.message,
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
            onHidden: async () => {
                await delay(450);
                this.tours.createUrl.sidebar.start();
            }
        },
    ];

    constructor() 
    {
        this.tour = DashboardTour.createTour({
            steps: this.steps,
            onEnd: this.handleTourHasEnded.bind(this)
        });

        this.tour.init();

        this.tours = {
            createUrl: {
                sidebar: CreateUrlSidebarTour
            }
        }
    }

    start() 
    {
        this.tour.start(true);
    }

    handleTourHasEnded() 
    {
        const dashboardPreferences = Preferences.createFromGlobals().dashboard;
        const preferenceName = 'tourIsEnabled';

        dashboardPreferences.setField({
            field: preferenceName,
            value: false
        })

        // silently update preferences
        dashboardPreferences.save(preferenceName)
                            .catch(Callable.callAndReturnArgument(() => {}))
    }
}