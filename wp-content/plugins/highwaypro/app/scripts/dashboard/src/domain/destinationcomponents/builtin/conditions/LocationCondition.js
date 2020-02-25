import Chip from '@material-ui/core/Chip';
import FormControl from '@material-ui/core/FormControl';
import Input from '@material-ui/core/Input';
import InputLabel from '@material-ui/core/InputLabel';
import MenuItem from '@material-ui/core/MenuItem';
import React from 'react';
import Select from '@material-ui/core/Select';
import VpnLockRounded from '@material-ui/icons/VpnLockRounded';

import { BuiltInComponent } from '../BuiltInComponent';

export class LocationCondition extends BuiltInComponent {
    static type = 'condition';
    static getIdStatic() { return 'highwaypro.LocationCondition';}
    getId() { return LocationCondition.getIdStatic(); } 
    icon = (<VpnLockRounded />);

    initialState = {
        countries: this.data.parameters.countries || [],
    }

    handleChange = (event) => {
        this.reactComponent.setState({
            countries: event.target.value
        });
    }

    getContent() 
    {
        return (
            <FormControl classes={{root: 'MuiFormControl-root'}}>
              <InputLabel>Allowed Countries</InputLabel>
              <Select classes={{root:'MuiInputBase-input MuiInput-underline'}}
                multiple
                value={this.reactComponent.state.countries}
                onChange={this.handleChange}
                input={<Input />}
                renderValue={selected => {
                  
                  if (selected.length < 1) {
                    return <Chip key={'_all_'} label={'all'} />
                  }
                  return (<div>
                           {selected.map(value => (
                             <Chip key={value} label={this.allowed.countries[value]} />
                           ))}
                         </div>)
                }}
              >
                {this.getCountriesAsList()}
              </Select>
            </FormControl>
        )
    }

    getCountriesAsList() 
    {
        const menuItems = [];

        for (let countryCode in this.allowed.countries) {
            menuItems.push((
                <MenuItem
                    key={countryCode}
                    value={countryCode}
                    style={{
                      fontWeight:
                        this.reactComponent.state.countries.indexOf(countryCode) === -1
                          ? 400
                          : 600,
                    }}
                  >
                    {this.allowed.countries[countryCode]}
                  </MenuItem>
            ))
        }

        return menuItems;
    }

    getValuesAsPreview()
    {
        return this.data.parameters.countries.map(countryCode => this.allowed.countries[countryCode]).join(', ').trim(', ');
    }
}