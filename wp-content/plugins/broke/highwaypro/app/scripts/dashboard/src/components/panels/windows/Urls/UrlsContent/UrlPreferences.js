import './UrlPreferences.css';

import Card from '@material-ui/core/Card';
import CardContent from '@material-ui/core/CardContent';
import FormHelperText from '@material-ui/core/FormHelperText';
import InputLabel from '@material-ui/core/InputLabel';
import MenuItem from '@material-ui/core/MenuItem';
import React, {Component} from 'react';
import Typography from '@material-ui/core/Typography';
import _ from 'lodash';

import { Events } from '../../../../../domain/behaviour/events/events/Events';
import { HighWayPro } from '../../../../../domain/highwaypro/HighWayPro';
import {
  Observer,
} from '../../../../../domain/behaviour/events/observer/Observer';
import HorizontalField from '../../../fields/HorizontalField';
import UpdateableField from '../../../../Fields/UpdateableField';
import UrlDestinationsLoading from './Destinations/UrlDestinationsLoading';

class UrlPreferences extends Component {
    urlExtraEventsHaveBeenRegistered = false;
    hasNotAddedObservers = true;

    render() {
        return  (
            <div className="hp-url-preferences">
                <div className="hp-url-preferences-heading">
                    {HighWayPro.text.urls.toolsAndPreferences}
                </div>
                {this.getCards()}
            </div>
        )
    }

    handleUrlUpdateOnce() 
    {
        this.props.url.loaded.extra.items.forEach(extra => {
            if (!extra.observers.length) {
                extra.add(new Observer(() => {
                    UrlPreferences.mountedComponent.forceUpdate();
                }));
            }
        })
    }

    getCards() 
    {
        if (this.props.url.hasNotLoadedExtra()) {
            return <UrlDestinationsLoading title={HighWayPro.text.urls.loadingPreferences}/>
        } else {
            UrlPreferences.mountedComponent = this;
            this.handleUrlUpdateOnce();
        }

        return (<div className="hp-url-preferences-cards">
                    <Card className="hp-card hp-url-preferences--keyword-insertion">
                        <CardContent className="hp-card-content">
                            <div className="hp-card-header">
                                <Typography gutterBottom variant="h5" component="h2">
                                    {HighWayPro.text.urls.dynamicLinkInsertionTitle}
                                </Typography>
                                <Typography component="p" classes={{root: 'MuiTypography-body'}}>
                                    {HighWayPro.text.urls.dynamicLinkInsertionDescription}
                                </Typography>
                            </div>
                        </CardContent>
                        <div className="hp-card-fields">
                            <HorizontalField 
                                title="All: "
                                field={(
                                    <UpdateableField 
                                        type="text"
                                        field="keyword_injection_keywords"
                                        entity={this.props.url.loaded.extra.get('keyword_injection')}

                                        label={HighWayPro.text.urls.dynamicLinkInsertionLabel}
                                        multiline
                                        rows="3"
                                        value={this.props.url.loaded.extra.get('keyword_injection').getValue('keyword_injection_keywords')}
                                        margin="normal"
                                        helperText={HighWayPro.text.urls.dynamicLinkInsertionHelper}
                                        variant="outlined"
                                    />
                                )} 
                                fieldDirection="horizontal"
                            />
                            <div className="hp-fields-row">
                                <HorizontalField 
                                    className="hp-keyword-insertion-field--post-types"
                                    title="Enabled in: "
                                    field={(<React.Fragment>
                                        <InputLabel>Content Type</InputLabel>
                                        <UpdateableField 
                                            type="select"
                                            multiple={true}
                                            field="keyword_injection_context"
                                            entity={this.props.url.loaded.extra.get('keyword_injection')}
                                            helperText="Separate keywords with a coma (,)"
                                            menuItems={HighWayPro.postTypes.map(postType => (
                                                <MenuItem key={postType.name} value={postType.name}>
                                                    {postType.label} ({postType.name})
                                                </MenuItem>
                                            ))}
                                        />
                                        <FormHelperText classes={{root: 'MuiFormHelperText'}}></FormHelperText>
                                    </React.Fragment>
                                    )} 
                                />
                                <HorizontalField 
                                    className="hp-keyword-insertion-field--limit"
                                    title={HighWayPro.text.urls.keywordsLimitTitle}
                                    field={(<React.Fragment>
                                      <InputLabel
                                        htmlFor="outlined-age-simple"
                                      >
                                      </InputLabel>
                                      <UpdateableField 
                                            type="select"
                                            field="keyword_injection_limit"
                                            entity={this.props.url.loaded.extra.get('keyword_injection_limit')}
                                            helperText=""
                                            renderValue={value => parseInt(value) === -1? 'No Limit' : value}
                                            menuItems={_.range(0, 21).map(number => (
                                                 <MenuItem key={number} value={number}>
                                                    {number}
                                                </MenuItem>
                                            ))}
                                        />
                                    </React.Fragment>
                                    )} 
                                    fieldDirection="horizontal"
                                />
                            </div>
                        </div>
                    </Card>
                    <Card className="hp-card hp-url-preferences--link-placement">
                        <CardContent className="hp-card-content">
                            <div className="hp-card-header">
                                <Typography gutterBottom variant="h5" component="h2">
                                    {HighWayPro.text.urls.inContentLinksTitle}
                                </Typography>
                                <Typography component="p" classes={{root: 'MuiTypography-body'}}>
                                    {HighWayPro.text.urls.inContentLinksDescription}
                                </Typography>
                            </div>
                        </CardContent>
                        <div className="hp-card-fields">
                            <HorizontalField 
                                className="hp-keyword-link-placement-field--click-behaviour"
                                title="When clicked: "
                                field={(<React.Fragment>
                                    <InputLabel>Click behaviour</InputLabel>
                                    <UpdateableField 
                                        type="select"
                                        field="link_placement_click_behaviour"
                                        entity={this.props.url.loaded.extra.get('link_placement_click_behaviour')}
                                        renderValue={value => {
                                            const optionName = value || HighWayPro.preferences.post._default.link_placement_click_behaviour;

                                            return _.invert(HighWayPro.preferences.post._allowed.link_placement_click_behaviour)[optionName];
                                        }}
                                        menuItems={Object.keys(HighWayPro.preferences.post._allowed.link_placement_click_behaviour).map((optionDescription, index, options) => (
                                            <MenuItem key={HighWayPro.preferences.post._allowed.link_placement_click_behaviour[optionDescription]} value={HighWayPro.preferences.post._allowed.link_placement_click_behaviour[optionDescription]}>
                                                {optionDescription}
                                            </MenuItem>
                                        ))}
                                    />
                                    <FormHelperText classes={{root: 'MuiFormHelperText'}}>This option takes precedence over the same option from the global preferences section.</FormHelperText>
                                </React.Fragment>
                                )} 
                            />
                            <HorizontalField 
                                className="hp-keyword-link-placement-field--click-nofollow"
                                title="Follow type: "
                                field={(<React.Fragment>
                                    <InputLabel></InputLabel>
                                    <UpdateableField 
                                        type="select"
                                        field="link_placement_follow_type"
                                        entity={this.props.url.loaded.extra.get('link_placement_follow_type')}
                                        menuItems={HighWayPro.preferences.post._allowed.link_placement_follow_type.map((option) => (
                                            <MenuItem key={option} value={option}>
                                                {option}
                                            </MenuItem>
                                        ))}
                                    />
                                    <FormHelperText classes={{root: 'MuiFormHelperText'}}></FormHelperText>
                                </React.Fragment>
                                )} 
                            />
                            {/*coming soon...*/ false && (<HorizontalField 
                                className="hp-keyword-link-placement-field--title-attr"
                                title="Title Attribute: "
                                field={(<React.Fragment>
                                    <InputLabel></InputLabel>
                                    <UpdateableField 
                                        type="text"
                                        field="link_placement_title_attribute"
                                        entity={this.props.url.loaded.extra.get('link_placement_title_attribute')}
                                    />
                                    <FormHelperText classes={{root: 'MuiFormHelperText'}}></FormHelperText>
                                </React.Fragment>
                                )} 
                            />)}
                        </div>
                    </Card>
                </div>)
    }
}

export default UrlPreferences;