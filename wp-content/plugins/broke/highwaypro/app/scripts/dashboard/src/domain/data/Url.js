import { Callable } from '../utilities/Callable';
import { Destinations } from './finders/Destinations';
import { Domain } from './domain/Domain';
import { Events } from '../behaviour/events/events/Events';
import { UrlExtraFinder } from './finders/UrlExtraFinder';
import { UrlTypes } from './finders/UrlTypes';
import { UrlViewsFinder } from './finders/UrlViewsFinder';
import { Urls } from './finders/urls';
import Notifications from '../../components/notifications/Notifications';

export class Url extends Domain {
    static getName = () => 'Url';

    loadedDestinations = [];
    destinationsHaveBeenLoaded = false;
    loaded = {
        analytics: {},
        extra: {}
    };

    state = {
        analytics: {
            areLoading: false,
            haveBeenLoaded: false,
            failedLoading: false
        },
        extra: {
            areLoading: false,
            haveBeenLoaded: false,
        }
    }

    static() 
    {
        return Url;    
    }

    static getFinder() 
    {
        if (!(Url.finder instanceof Urls)) {
            Url.finder = new Urls;
        }

        return Url.finder;    
    }

    constructor(url: object) {
        super(url);

        Url.destinationsFinder = new Destinations;
        Url.urlViewsFinder = new UrlViewsFinder;
        this.urlExtraFinder = new UrlExtraFinder(this);
        
    }

    getPath() {
        return this.path.replace('/', '');
    }

    getType() {
        
        const type = UrlTypes.getFromMemoryWithId(this.type_id);

        return type? type : {
            id: -1,
            name: '',
            base_path: '',
            color: null
        };
    }

    loadUrlMetaIfItsNotInMemory() 
    {
        this.loadAnalyticsIfItHasNotAlready();
        this.loadDestinationsIfItHasNotAlready();
        this.loadExtraIfItHasNotAlready();
    }

    loadExtraIfItHasNotAlready() 
    {
        if (!this.hasLoadedExtra() && !this.isLoadingExtra()) {
            return this.urlExtraFinder.getForUrl()
                                            .then(Callable.callAndReturnArgument(
                                                response => this.setLoadedExtra(response)
                                            )).catch(exception => {
                                                // update triggers a rerender from the view
                                                this.update(url => {
                                                    url.state.extra.areLoading = false;
                                                    url.state.extra.haveBeenLoaded = false;
                                                    url.state.extra.failedLoading = true;
                                                });

                                                throw exception;
                                            });
        }
    }

    setLoadedExtra(extra) {
        this.update(url => {
            url.loaded.extra = extra;

            url.state.extra.areLoading = false;
            url.state.extra.haveBeenLoaded = true;
            url.state.extra.failedLoading = false;
        });
    }

    loadDestinationsIfItHasNotAlready() 
    {
        if (this.hasNotLoadedDestinations()) {
            Notifications.openLoadingNotification(true);
            this.getDestinations()
                      .catch(Callable.callAndReturnArgument(Notifications.addFromResponse))
                      .then(Callable.callAndReturnArgument(Notifications.closeLoadingNotification));
        }
    }

    setLoadedDestinations(destinations) {
        this.update(url => {
            url.loadedDestinations = destinations;
            url.destinationsHaveBeenLoaded = true;   
        });
    }

    setLoadedAnalytics(analytics) {
        this.update(url => {
            url.loaded.analytics = analytics;
            
            url.state.analytics.areLoading = false;
            url.state.analytics.haveBeenLoaded = true;
            url.state.analytics.failedLoading = false;
        });
    }

    loadAnalyticsIfItHasNotAlready() 
    {
        if (!this.hasLoadedAnalytics() && !this.isLoadingAnalytics()) {
            return this.static().urlViewsFinder.getByUrlId(this.id)
                                            .then(Callable.callAndReturnArgument(
                                                response => this.setLoadedAnalytics(response)
                                            )).catch(exception => {
                                                // update triggers a rerender from the view
                                                this.update(url => {
                                                    url.state.analytics.areLoading = false;
                                                    url.state.analytics.haveBeenLoaded = false;
                                                    url.state.analytics.failedLoading = true;
                                                });

                                                throw exception;
                                            });
        }
    }

    hasLoadedAnalytics() 
    {
        return this.state.analytics.haveBeenLoaded;
    }

    isLoadingAnalytics() 
    {
        return this.state.analytics.areLoading;   
    }

    hasNotLoadedAnalytics() 
    {
        return !this.state.analytics.areLoading;
    }

    hasLoadedExtra() 
    {
        return this.state.extra.haveBeenLoaded;
    }

    isLoadingExtra() 
    {
        return this.state.extra.areLoading;   
    }

    hasNotLoadedExtra() 
    {
        return !this.state.extra.haveBeenLoaded;
    }

    hasNotLoadedDestinations() 
    {
        return !this.destinationsHaveBeenLoaded;
    }

    getDestinations() {
        return this.static().destinationsFinder.getByUrlId(this.id)
                                               .then(Callable.callAndReturnArgument(
                                                response => this.setLoadedDestinations(response.destinations)
                                                ));
    }

    saveNewDestination() 
    {
        return this.static().destinationsFinder.saveNewWithUrlId(this.id)
                                               .then(
                                                    Callable.callAndReturnArgument(this.addToloadedDestinations)
                                                ); 
    }

    addToloadedDestinations = (response) => {
        this.update(url => {
            url.loadedDestinations.push(response.destination);
        });
    }

    deleteDestination(destination) 
    {
        return this.static().destinationsFinder.deleteWithId(destination.id)
                                        .then(Callable.callAndReturnArgument(response => this.setLoadedDestinations(response.destinations)));
    }
}