import LanguageRounded from '@material-ui/icons/LanguageRounded';
import React from 'react';
import TextField from '@material-ui/core/TextField';
import FormControl from '@material-ui/core/FormControl';
import { BuiltInComponent } from '../BuiltInComponent';

export class DirectTarget extends BuiltInComponent {
    static type = 'target';
    static getIdStatic() { return 'highwaypro.DirectTarget';}
    getId() { return DirectTarget.getIdStatic() } 
    icon = (<LanguageRounded />);

    initialState = {
        url: this.data.parameters.url || '',
    }

    handleChange = (event) => {
        this.reactComponent.setState({
            url: event.target.value
        });
    }

    getContent() 
    {
        return (
             <FormControl classes={{root: 'MuiFormControl-root'}}>
                 <TextField
                  label="URL"
                  value={this.reactComponent.state.url}
                  onChange={this.handleChange}
                  margin="normal"
                  variant="outlined"
                />
            </FormControl>
        )
    }

    getValuesAsPreview()
    {
        return this.data.parameters.url;
    }
}