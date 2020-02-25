import React, {Component} from 'react';

import { UrlViewsFinder } from '../../../domain/data/finders/UrlViewsFinder';
import Notifications from '../../notifications/Notifications';
import UrlStatistics from './Urls/statistics/UrlStatistics';

export default class OverviewPanelWindow extends Component
{
    state = {
        hasLoadedAnalytics: false,
        analytics: {},
        layout: 'default'
    };

    componentDidMount() 
    {
        this.loadAllUrls();
        this.updateLayout();
        
        window.addEventListener('resize', this.updateLayout.bind(this))
    }

    loadAllUrls() 
    {
        const urlViewsFinder = new UrlViewsFinder;

        urlViewsFinder.getStatsForAllUrls().then(analytics => {
            if (analytics.type === 'all_url_views_read_sucess') {
                this.setState({
                    hasLoadedAnalytics: true,
                    analytics: analytics
                })
            } else {
                Notifications.addFromResponse({
                    message: 'Error loading analytics for all urls.',
                    state: 'error'
                });
            }

        })
    }

    render() 
    {
        return <UrlStatistics layout={this.state.layout} hasLoaded={this.state.hasLoadedAnalytics} getData={() => this.state.analytics}/>
    }

    updateLayout() 
    {
        const newLayout = window.innerWidth < 1200? 'compact' : 'default';

        if (this.state.layout !== newLayout) {
            this.setState({
                layout: newLayout
            });
        }
    }
}