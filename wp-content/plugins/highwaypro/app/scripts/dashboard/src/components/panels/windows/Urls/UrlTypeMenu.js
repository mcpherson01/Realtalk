import InputLabel from '@material-ui/core/InputLabel';

import FormControl from '@material-ui/core/FormControl';

import './UrlTypeMenu.css';

import ListItemText from '@material-ui/core/ListItemText';
import MenuItem from '@material-ui/core/MenuItem';
import React, {Component} from 'react';
import Select from '@material-ui/core/Select';

import { UrlType } from '../../../../domain/data/UrlType';
import { UrlTypes } from '../../../../domain/data/finders/UrlTypes';

class UrlTypeMenu extends Component {
    getDefaultText = () => {
        return this.props.defaultText || 'Base +';
    }

    render() {

        const urlType = UrlTypes.getFromMemoryWithId(this.props.typeId);
        const basePath = (urlType instanceof UrlType) && urlType.base_path; 

        return (
        <FormControl 
            classes={{root: 'MuiFormControl-root'}} 
            className="hp-url-type-menu" 
            variant={this.props.variant || null}
            fullWidth={this.props.fullWidth}
        >
          {this.props.label? (<InputLabel htmlFor="age-simple">{this.props.label}</InputLabel>) : ''}
            <Select
                className="MuiInput-underline"
                value={basePath || this.getDefaultText()}
                onChange={this.props.whenChanged}
                renderValue={value => (<div className="MuiInputBase-input">{value}</div>)}
                IconComponent={() => null}
                fullWidth={this.props.fullWidth}
                label={this.props.label}
                >
                    <MenuItem value="">
                      <em>None</em>
                    </MenuItem>
                    {UrlTypes.all.map(urlType => {
                        return (<MenuItem key={urlType.id} value={urlType.id}>
                                    <ListItemText
                                      primary={urlType.base_path + '/'}
                                      secondary={urlType.name}
                                    />
                                </MenuItem>);
                    })}
            </Select>
        </FormControl>
        );
    }
}

export default UrlTypeMenu;