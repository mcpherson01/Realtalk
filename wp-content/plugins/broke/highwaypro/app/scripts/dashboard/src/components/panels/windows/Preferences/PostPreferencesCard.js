import './PostPreferencesCard.css';

import FormControlLabel from '@material-ui/core/FormControlLabel';
import FormHelperText from '@material-ui/core/FormHelperText';
import InputLabel from '@material-ui/core/InputLabel';
import MenuItem from '@material-ui/core/MenuItem';
import React from 'react';
import Select from '@material-ui/core/Select';
import Switch from '@material-ui/core/Switch';
import _ from 'lodash';

import { HighWayPro } from '../../../../domain/highwaypro/HighWayPro';
import { map } from '../../../../domain/utilities/object/map';
import HorizontalField from '../../fields/HorizontalField';
import PreferencesCard from './PreferencesCard';

class PostPreferencesCard extends PreferencesCard {
    static cardTitle = 'Post Links';
    static cardText = '';

    preferencesType = 'post';

    render() {
        return (
        <React.Fragment>
            <FormControlLabel
              control={
                <Switch
                  checked={this.props.preferences.post.keyword_injection_is_enabled}
                  onChange={this.toggle('keyword_injection_is_enabled')}
                  value={this.props.preferences.post.keyword_injection_is_enabled}
                  color="primary"
                />
              }
              label={HighWayPro.text.preferences.post.dynamicLinkInsertion.label}
              labelPlacement="start"
              className="hp-horizontal-field"
              classes={{label: 'hp-hf-description'}}
            />
            <FormHelperText classes={{root: 'MuiFormHelperText'}}>{HighWayPro.text.preferences.post.dynamicLinkInsertion.description}</FormHelperText>
            <HorizontalField 
                title={HighWayPro.text.preferences.post.keyword_injection_limit.title}
                field={(<React.Fragment>
                    <InputLabel>Limit</InputLabel>
                    <Select
                        className="MuiInput-underline MuiInputBase-input"
                        value={this.props.preferences.post.keyword_injection_limit}
                        onChange={this.handleChange('keyword_injection_limit')}
                        IconComponent={() => null}
                        fullWidth={false}
                        label="numeric"
                        >
                            {_.range(0, 21).map(number => (
                                 <MenuItem key={number} value={number}>
                                    {number}
                                </MenuItem>
                            ))}
                    </Select>
                    <FormHelperText classes={{root: 'MuiFormHelperText'}}>{HighWayPro.text.preferences.post.keyword_injection_limit.description}</FormHelperText>
                </React.Fragment>
                )} 
            />
            <HorizontalField 
                title={HighWayPro.text.preferences.post.keyword_injection_post_types_enabled.title}
                field={(<React.Fragment>
                    <InputLabel>Type</InputLabel>
                    <Select
                        className="MuiInput-underline MuiInputBase-input"
                        multiple
                        value={this.props.preferences.post.keyword_injection_post_types_enabled}
                        onChange={this.handleChange('keyword_injection_post_types_enabled')}
                        IconComponent={() => null}
                        fullWidth={false}
                        label="numeric"
                        >
                            {map(HighWayPro.preferences.post._allowed.keyword_injection_post_types_enabled, (settingName, name) => {
                                return (<MenuItem key={settingName} value={settingName}>
                                            {_.capitalize(name)}
                                        </MenuItem>);
                            })}
                    </Select>
                    <FormHelperText classes={{root: 'MuiFormHelperText'}}>{HighWayPro.text.preferences.post.keyword_injection_post_types_enabled.description}</FormHelperText>
                </React.Fragment>
                )} 
            />
            <HorizontalField 
                title={HighWayPro.text.preferences.post.link_placement_click_behaviour.title}
                field={(<React.Fragment>
                    <InputLabel>Click Behaviour</InputLabel>
                    <Select
                        className="MuiInput-underline MuiInputBase-input"
                        value={this.props.preferences.post.link_placement_click_behaviour}
                        onChange={this.handleChange('link_placement_click_behaviour')}
                        IconComponent={() => null}
                        fullWidth={false}
                        label="numeric"
                        >
                        {Object.keys(HighWayPro.preferences.post._allowed.link_placement_click_behaviour).map((optionDescription, index, options) => (
                            <MenuItem key={HighWayPro.preferences.post._allowed.link_placement_click_behaviour[optionDescription]} value={HighWayPro.preferences.post._allowed.link_placement_click_behaviour[optionDescription]}>
                                {optionDescription}
                            </MenuItem>
                        ))}
                    </Select>
                    <FormHelperText classes={{root: 'MuiFormHelperText'}}>{HighWayPro.text.preferences.post.link_placement_click_behaviour.description}</FormHelperText>
                </React.Fragment>
                )} 
            />
            <HorizontalField 
                title={HighWayPro.text.preferences.post.link_placement_follow_type.title}
                field={(<React.Fragment>
                    <InputLabel>Follow Type</InputLabel>
                    <Select
                        className="MuiInput-underline MuiInputBase-input"
                        value={this.props.preferences.post.link_placement_follow_type}
                        onChange={this.handleChange('link_placement_follow_type')}
                        IconComponent={() => null}
                        fullWidth={false}
                        label="numeric"
                        >
                        {HighWayPro.preferences.post._allowed.link_placement_follow_type.map((option) => (
                            <MenuItem key={option} value={option}>
                                {option}
                            </MenuItem>
                        ))}
                    </Select>
                    <FormHelperText classes={{root: 'MuiFormHelperText'}}>{HighWayPro.text.preferences.post.link_placement_follow_type.description}</FormHelperText>
                </React.Fragment>
                )} 
            />
        </React.Fragment>
        );
    }
}

export default PostPreferencesCard;