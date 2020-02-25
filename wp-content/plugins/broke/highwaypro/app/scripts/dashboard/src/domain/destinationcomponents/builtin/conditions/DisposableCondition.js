import FormControl from '@material-ui/core/FormControl';
import InputLabel from '@material-ui/core/InputLabel';
import MenuItem from '@material-ui/core/MenuItem';
import OutlinedInput from '@material-ui/core/OutlinedInput';
import React from 'react';
import LooksOneRounded from '@material-ui/icons/LooksOneRounded';
import Select from '@material-ui/core/Select';
import _ from 'lodash';

import { BuiltInComponent } from '../BuiltInComponent';

export class DisposableCondition extends BuiltInComponent {
    static type = 'condition';
    static getIdStatic() { return 'highwaypro.DisposableCondition';}
    getId() { return DisposableCondition.getIdStatic() } 
    icon = (<LooksOneRounded />);

    initialState = {
        numberOfTimesItCanBeUsed: this.data.parameters.numberOfTimesItCanBeUsed || 1,
    }

    constructor(properties)
    {
        super(properties);

        this.numbers = _.range(1, 30).concat(_.range(30, 101, 5)).concat(_.range(100, 1001, 100));
    }

    handleChange = (event) => {
        this.reactComponent.setState({
            numberOfTimesItCanBeUsed: event.target.value
        });
    }

    getContent() 
    {
        return (
              <FormControl classes={{root: 'MuiFormControl-root'}} variant="outlined">
                  <InputLabel
                    ref={ref => {
                      this.InputLabelRef = ref;
                    }}
                    htmlFor="outlined-age-simple"
                  >
                    Number of times it can be used
                  </InputLabel>
                  <Select classes={{root:'MuiInputBase-input MuiInput-underline'}}
                    MenuProps={{
                        PaperProps: {style:{maxHeight: 300}}
                    }}
                    PaperProps
                    value={this.reactComponent.state.numberOfTimesItCanBeUsed}
                    onChange={this.handleChange}
                    input={
                      <OutlinedInput />
                    }
                  >
                    {this.numbers.map(
                        number => <MenuItem value={number}>{number}</MenuItem>   
                    )}
                  </Select>
            </FormControl>
        )
    }

    getValuesAsPreview()
    {
        const numberOfTimes = this.data.parameters.numberOfTimesItCanBeUsed;
        const times = numberOfTimes > 1? 'uses' : 'use';
        return `Max: ${numberOfTimes} ${times}`;
    }
}