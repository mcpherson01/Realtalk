import { isObject } from '../../../utilities/isObject';

import AsyncSelect from 'react-select/lib/Async';
import FormControl from '@material-ui/core/FormControl';
import InputLabel from '@material-ui/core/InputLabel';
import InsertDriveFileRounded from '@material-ui/icons/InsertDriveFileRounded';
import MenuItem from '@material-ui/core/MenuItem';
import React from 'react';
import Select from '@material-ui/core/Select';
import classnames from 'classnames';

import { BuiltInComponent } from '../BuiltInComponent';
import { PostsFinder } from '../../../data/finders/PostsFinder';

export class PostTarget extends BuiltInComponent {
    static type = 'target';
    static getIdStatic() { return 'highwaypro.PostTarget';}
    getId() { return PostTarget.getIdStatic() } 
    icon = (<InsertDriveFileRounded />);

    initialState = {
        type: this.data.parameters.type || '',
        id: this.data.parameters.id || 0,
    }

    constructor(data)
    {
        super(data);

        this.postsFinder = new PostsFinder;
    }

    handleChange = type => event => {
        this.reactComponent.setState({
            [type]: event.target.value
        });
    }

    loadPosts = input => {
        return this.postsFinder.getByKeyword(input).then(posts => posts.map(post => {
            return { value: post.ID, label: post.post_title }
        }));
    }

    handlePostIdChange = (selected) => {
        this.selectedPost = isObject(selected)? selected : {};

        this.reactComponent.setState({
            id: selected.value
        })
    }

    getPlaceHolder() 
    {
        if (this.data.parameters.id > 0) {
            return `Post Id: ${this.data.parameters.id}`;
        }

        return 'Search Content';
    }
    getContent() 
    {
        return (
            <React.Fragment>
                <FormControl classes={{root: 'MuiFormControl-root'}}>
              <InputLabel>Type of Posts</InputLabel>
              <Select classes={{root:'MuiInputBase-input MuiInput-underline'}}
                value={this.reactComponent.state.type}
                onChange={this.handleChange('type')}
              >
                {this.getTypesMenuItems()}
              </Select>
            </FormControl>
            <AsyncSelect 
                className={classnames({'hp-select-search': true, '--disabled': this.reactComponent.state.type.toLowerCase() !== 'withid'})} 
                classNamePrefix="hp-select-search" 
                placeholder={this.getPlaceHolder()} 
                onChange={this.handlePostIdChange} 
                loadOptions={this.loadPosts} 
                noOptionsMessage={() => 'Search content to continue'}
            />
            </React.Fragment>
        )
    }

    getTypesMenuItems() 
    {
        const menuItems = [];

        for(let key in this.allowed.types) {
            menuItems.push((<MenuItem
                                key={key}
                                value={key}
                                style={{
                                  fontWeight:
                                    this.reactComponent.state.type.indexOf(key) === -1
                                      ? 400
                                      : 600,
                                }}
                              >
                                {this.allowed.types[key]}
                              </MenuItem>));
        }  

        return menuItems;
    }

    getValuesAsPreview = () =>
    {
        const type = this.allowed.types[this.data.parameters.type];

        if (this.data.parameters.type.toLowerCase() === 'withid') {
            return `${type}: ${this.data.parameters.id}`
        }

        return type;
    }
}