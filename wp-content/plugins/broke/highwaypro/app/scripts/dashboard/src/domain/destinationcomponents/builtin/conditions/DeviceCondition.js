import Input from '@material-ui/core/Input';
import Chip from '@material-ui/core/Chip';
import FormControl from '@material-ui/core/FormControl';
import InputLabel from '@material-ui/core/InputLabel';
import MenuItem from '@material-ui/core/MenuItem';
import LaptopMacRounded from '@material-ui/icons/LaptopMacRounded';
import React from 'react';
import Select from '@material-ui/core/Select';

import { BuiltInComponent } from '../BuiltInComponent';

export class DeviceCondition extends BuiltInComponent {
    static type = 'condition';
    static getIdStatic() { return 'highwaypro.DeviceCondition';}
    getId() { return DeviceCondition.getIdStatic() } 
    icon = (<LaptopMacRounded />);

    initialState = {
        devices: this.data.parameters.devices || [],
    }

    handleChange = (event) => {
        this.reactComponent.setState({
            devices: event.target.value
        });
    }

    getContent() 
    {
        return (
            <FormControl classes={{root: 'MuiFormControl-root'}}>
              <InputLabel>Allowed Devices</InputLabel>
              <Select classes={{root:'MuiInputBase-input MuiInput-underline'}}
                multiple
                className="MuiInput-underline MuiInputBase-input"
                value={this.reactComponent.state.devices}
                onChange={this.handleChange}
                input={<Input />}
                renderValue={selected => {
                  
                  if (selected.length < 1) {
                    return <Chip key={'_all_'} label={'all'} />
                  }
                  return (<div>
                           {selected.map(value => (
                             <Chip key={value} label={value} />
                           ))}
                         </div>)
                }}
              >
                {this.allowed.devices.map(device => (
                  <MenuItem
                    key={device}
                    value={device}
                    style={{
                      fontWeight:
                        this.reactComponent.state.devices.indexOf(device) === -1
                          ? 400
                          : 600,
                    }}
                  >
                    {device}
                  </MenuItem>
                ))}
              </Select>
            </FormControl>
        )
    }

    getValuesAsPreview()
    {
        return this.data.parameters.devices.join(', ').trim(', ');
    }
}