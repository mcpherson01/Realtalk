import './UpdateableField.css';

import React, {Component} from 'react';
import Select from '@material-ui/core/Select';
import TextField from '@material-ui/core/TextField';
import _ from 'lodash';
import delay from 'delay';
import { Callable } from '../../domain/utilities/Callable';
import { Domain } from '../../domain/data/domain/Domain';
import { HighWayPro } from '../../domain/highwaypro/HighWayPro';
import { Strings } from '../../domain/utilities/Strings';
import Notifications from '../notifications/Notifications';
import $ from 'jquery';

class UpdateableField extends Component {
    state = {
        fieldState: 'unactive',
    }

    beforeEdition = '';

    handleChange = event => {
        let value = event.target.value;
        console.log('handlin change""""');
        
        if (typeof this.props.transformInput === 'function') {
            value = this.props.transformInput(value);
        }

        this.updateEntityField(this.props.entity, value);
    }

    updateEntityField = (entity, value) => {
        entity.update(entity => {
            entity.set(this.props.field, value);
        });
    }

    getInputProperties() 
    {
        return {
            onFocus: this.storeValueBeforeEdition,
            onBlur: this.props.type !== 'select'? this.update.bind(this) : () => {},
            onKeyDown: this.handleChange
        };
    }

    storeValueBeforeEdition = event => {
        console.log('eement bein fcused', event.target)
        this.beforeEdition = event.target.value;
    }

    update() {
        if (this.valueHasChanged()) {
            Notifications.openLoadingNotification(true, HighWayPro.text.other.saving);

            this.props.entity.updateField(this.props.field)
                          .then(
                            Callable.callAndReturnArgument(this.handleSuccess.bind(this, this.props.entity))
                           )
                          .catch(
                            Callable.callAndReturnArgument(this.handleUpdateError.bind(this, this.props.entity))
                           )
                          .then(
                            Callable.callAndReturnArgument(this.showNotification)
                           );
        }
    }

    handleSuccess = (entity, response) => {
        this.changeFieldStateTo('success');

        this.refreshEntity(entity, response);
    }

    handleUpdateError = (entity) => {
        this.updateEntityField(entity, this.beforeEdition); 
        this.changeFieldStateTo('error');
    }

    changeFieldStateTo(state) 
    {
        this.setState({
            fieldState: state
        });    
    }

    refreshEntity(entity, response) 
    {
        entity.update(entity => {
            const newEntity = response[Strings.lcfirst(entity.constructor.getName())]

            const fieldsToUpdate = [this.props.field].concat(
                Array.isArray(this.props.fieldsToUpdate)? this.props.fieldsToUpdate : []
            ).filter(field => !!field);

            fieldsToUpdate.forEach(field => {
                entity.set(
                    field,
                    newEntity instanceof Domain? newEntity.get(field) : newEntity[field]
                ); 
            });
        });
    }

    showNotification(response) {
        Notifications.openLoadingNotification(false);
        Notifications.addFromResponse(response);
    }

    valueHasChanged = () => {
        return this.beforeEdition !== this.props.entity.get(this.props.field);
    }

    render() {
        const type = this.props.type || 'text';

        const managementProps = {
            label: this.props.label,
            value: this.props.entity.get(this.props.field),
            onChange: this.handleChange,
            error: this.state.fieldState === 'error',
            inputProps: _.merge(this.getInputProperties(), {}),
            FormHelperTextProps: {classes:{root: 'MuiFormHelperText'}}
        };

        if (type === 'text') {
            return (
                <TextField
                  {...managementProps}
                  onClick={async (event) => {
                    await delay(1e2);

                    $(event.target).focus();
                  }}
                  className="MuiInput-underline"
                  margin="normal"
                  multiline={this.props.multiline}
                  rows={this.props.rows}
                  margin="normal"
                  variant={this.props.variant}
                  helperText={this.props.helperText}
                />
            );
        } else if (type === 'select') {
            return (
                <Select
                    {...managementProps}
                    className="MuiInput-underline"
                    classes={{root:'MuiInputBase-input MuiInput-underline'}}
                    multiple={this.props.multiple}
                    renderValue={this.props.renderValue || (value => _.capitalize(value)+' ')}
                    IconComponent={this.props.IconComponent}
                    fullWidth={this.props.fullWidth || false}
                    onClose={event => {console.log('closing')}}
                    MenuProps={{
                        onExit: this.update.bind(this),
                    }}
                    >
                    {this.props.menuItems}
                </Select>
            )
        }
    }
}

export default UpdateableField;