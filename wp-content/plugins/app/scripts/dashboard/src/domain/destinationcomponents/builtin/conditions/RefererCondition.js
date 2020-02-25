import ForwardRounded from '@material-ui/icons/ForwardRounded';
import React from 'react';
import TextField from '@material-ui/core/TextField';

import { BuiltInComponent } from '../BuiltInComponent';

export class RefererCondition extends BuiltInComponent {
    static type = 'condition';
    static getIdStatic() { return 'highwaypro.RefererCondition';}
    getId() { return RefererCondition.getIdStatic() } 
    icon = (<ForwardRounded />);

    initialState = {
        domains: this.convertArrayToStringByNewLines(this.data.parameters.domains || []),
        urls: this.convertArrayToStringByNewLines(this.data.parameters.urls || []),
    }

    handleChange = type => event => {
        this.reactComponent.setState({
            [type]: event.target.value
        });
    };

    getFinalParameters() 
    {
        return {
            domains: this.converStringTotArrayByNewLines(this.reactComponent.state.domains),
            urls: this.converStringTotArrayByNewLines(this.reactComponent.state.urls),
        }
    }

    getContent() 
    {
        return (
            <React.Fragment>
                <TextField
                    label="Domains"
                    multiline
                    rows="3"
                    value={this.reactComponent.state.domains}
                    onChange={this.handleChange('domains')}
                    fullWidth={true}
                    margin="normal"
                    helperText="Hit enter to separate one or more domains"
                    variant="outlined"
                />
                <TextField
                    label="URLs"
                    multiline
                    rows="3"
                    value={this.reactComponent.state.urls}
                    onChange={this.handleChange('urls')}
                    fullWidth={true}
                    margin="normal"
                    helperText="Hit enter to separate one or more urls"
                    variant="outlined"
                />
          </React.Fragment>
        )
    }

    getValuesAsPreview()
    {
        return this.data.parameters.domains
                                    .concat(this.data.parameters.urls)
                                    .join(', ').trim(', ');
    }
}