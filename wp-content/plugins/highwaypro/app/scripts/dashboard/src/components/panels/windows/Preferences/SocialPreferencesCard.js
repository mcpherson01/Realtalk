import './SocialPreferencesCard.css';

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

class SocialPreferencesCard extends PreferencesCard {
    static cardTitle = 'Social';
    static cardText = '';

    preferencesType = 'social';

    render() {
        return (
        <React.Fragment>
            <FormControlLabel
              control={
                <Switch
                  checked={this.props.preferences.social.og_url_is_enabled}
                  onChange={this.toggle('og_url_is_enabled')}
                  value={this.props.preferences.social.og_url_is_enabled}
                  color="primary"
                />
              }
              label={HighWayPro.text.preferences.social.og_url_is_enabled.label}
              labelPlacement="start"
              classes={{label: 'hp-hf-description'}}
            />
            <FormHelperText classes={{root: 'MuiFormHelperText'}}>{HighWayPro.text.preferences.social.og_url_is_enabled.description}</FormHelperText>
            {/*coming soon, has been postponed to v 1.1*/false && (<HorizontalField 
                title={HighWayPro.text.preferences.social.og_url_post_types_enabled.title}
                field={(<React.Fragment>
                    <InputLabel>Type</InputLabel>
                    <Select
                        className="MuiInput-underline MuiInputBase-input"
                        multiple
                        value={this.props.preferences.social.og_url_post_types_enabled}
                        onChange={this.handleChange('og_url_post_types_enabled')}
                        IconComponent={() => null}
                        fullWidth={false}
                        label="numeric"
                        >
                            {map(HighWayPro.preferences.social._allowed.og_url_post_types_enabled, (settingName, name) => {
                                return (<MenuItem key={settingName} value={settingName}>
                                            {_.capitalize(name)}
                                        </MenuItem>);
                            })}
                    </Select>
                    <FormHelperText classes={{root: 'MuiFormHelperText'}}></FormHelperText>
                </React.Fragment>
                )} 
            />)}
        </React.Fragment>
        );
    }
}

export default SocialPreferencesCard;