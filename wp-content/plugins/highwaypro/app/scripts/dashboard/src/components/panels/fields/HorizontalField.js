import './HorizontalField.css';
import _ from 'lodash';
import FormControl from '@material-ui/core/FormControl';
import React, {Component} from 'react';

class HorizontalField extends Component {
    render() {
        return (
            <div className={`hp-horizontal-field ${this.props.fieldDirection === 'horizontal' && 'hp-horizontal-field--horizontal-field' || ''} ${this.props.className}`}>
                <div className="hp-hf-description">
                    {_.capitalize(this.props.title)}
                </div>
                <FormControl classes={{root: 'MuiFormControl-root'}} className="hp-hf-field">
                    {this.props.field}
                </FormControl>
            </div>
        );
    }
}

export default HorizontalField;