import DeviceUnknownRounded from '@material-ui/icons/DeviceUnknownRounded';
import React from 'react';
import TextField from '@material-ui/core/TextField';

import { BuiltInComponent } from '../BuiltInComponent';

export class UserAgentCondition extends BuiltInComponent {
    static type = 'condition';
    static getIdStatic() { return 'highwaypro.UserAgentCondition';}
    getId() { return UserAgentCondition.getIdStatic() } 
    icon = (<DeviceUnknownRounded />);

    initialState = {
        userAgents: this.convertArrayToStringByNewLines(this.data.parameters.userAgents || []),
    }

    handleChange = event => {
        this.reactComponent.setState({
            userAgents: event.target.value
        });
    };

    getFinalParameters() 
    {
        return {
            userAgents: this.converStringTotArrayByNewLines(this.reactComponent.state.userAgents),
        }
    }

    getContent() 
    {
        return (
            <React.Fragment>
                <TextField
                    label="User Agent Strings"
                    multiline
                    rows="3"
                    value={this.reactComponent.state.userAgents}
                    onChange={this.handleChange}
                    margin="normal"
                    helperText="Hit enter to separate one or more user agent strings"
                    variant="outlined"
                />
          </React.Fragment>
        )
    }

    getValuesAsPreview()
    {
        return this.data.parameters.userAgents
                                    .concat(this.data.parameters.urls)
                                    .join(', ').trim(', ');
    }
}