import './Preferencespanelwindow.css';

import Card from '@material-ui/core/Card';
import CardActionArea from '@material-ui/core/CardActionArea';
import CardActions from '@material-ui/core/CardActions';
import CardContent from '@material-ui/core/CardContent';
import CardMedia from '@material-ui/core/CardMedia';
import React, {Component} from 'react';
import Typography from '@material-ui/core/Typography';

import { HighWayPro } from '../../../domain/highwaypro/HighWayPro';
import { Observer } from '../../../domain/behaviour/events/observer/Observer';
import { Preferences } from '../../../domain/data/Preferences';
import DashboardPreferencesCard from './Preferences/DashboardPreferencesCard';
import PostPreferencesCard from './Preferences/PostPreferencesCard';
import SocialPreferencesCard from './Preferences/SocialPreferencesCard';
import UrlPreferencesCard from './Preferences/UrlPreferencesCard';

class Preferencespanelwindow extends Component {
    static instance;

    cards = [
        [UrlPreferencesCard, DashboardPreferencesCard], 
        [PostPreferencesCard, SocialPreferencesCard]
    ];

    state = {
        preferences: Preferences.createFromGlobals()
    };

    static setPreferences(preferences: Preferences) 
    {
        Preferencespanelwindow.instance.setState({
            preferences: preferences
        });
    }

    componentDidMount()
    {
        Preferencespanelwindow.instance = this;
    }

    componentDidUpdate() 
    {
        this.state.preferences.addOnce(
            'preferencesWindowObserver', 
            new Observer(preferences => {
                this.forceUpdate();
            })
        )
    }

    render() {
        return (
            <div className="preferences-window">
                <h1 className="hp-p-title">{HighWayPro.text.preferences.preferencesTitle}</h1>
                <div className="hp-cards">
                    {this.cards.map(cardRow => (
                        <div className={`hp-card-row hp-card-row--${cardRow.length}`}>
                            {cardRow.map(PreferencesCard => (
                                <Card className="hp-card">
                                    <CardContent className="hp-card-content">
                                      <div className="hp-card-header">
                                        <Typography gutterBottom component="h2">
                                            {PreferencesCard.cardTitle}
                                        </Typography>
                                        <Typography component="p" classes={{root: 'MuiTypography-body'}}>
                                            {PreferencesCard.cardText}
                                        </Typography>
                                      </div>

                                    </CardContent>
                                    <div className="hp-card-fields">
                                          <PreferencesCard preferences={this.state.preferences}/>
                                      </div>
                                </Card>
                            ))}
                        </div>))}
                </div>    
            </div>
        );
    }
}

export default Preferencespanelwindow;