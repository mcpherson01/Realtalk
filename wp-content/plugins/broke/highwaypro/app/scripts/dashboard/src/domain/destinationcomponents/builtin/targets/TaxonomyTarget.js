import AsyncSelect from 'react-select/lib/Async';
import CategoryRounded from '@material-ui/icons/CategoryRounded';
import FormControl from '@material-ui/core/FormControl';
import InputLabel from '@material-ui/core/InputLabel';
import React from 'react';

import { BuiltInComponent } from '../BuiltInComponent';
import { TaxonomyFinder } from '../../../data/finders/TaxonomyFinder';
import { isObject } from '../../../utilities/isObject';

export class TaxonomyTarget extends BuiltInComponent {
    static type = 'target';
    static getIdStatic() { return 'highwaypro.TaxonomyTarget';}
    getId() { return TaxonomyTarget.getIdStatic() } 
    icon = (<CategoryRounded />);

    initialState = {
        termId: this.data.parameters.termId || 0,
    }

    constructor(data)
    {
        super(data);

        this.taxonomyFinder = new TaxonomyFinder;
    }

    loadPosts = input => {
        return this.taxonomyFinder.getByKeyword(input).then(terms => terms.map(term => {
            return { value: term.term_id, label: `${term.name} (${term.taxonomy})` }
        }));
    }

    handleTermIdChange = (selected) => {
        this.selectedPost = isObject(selected)? selected : {};

        this.reactComponent.setState({
            termId: selected.value
        })
    }

    getPlaceHolder() 
    {
        if (this.data.parameters.termId > 0) {
            return `Term Id: ${this.data.parameters.termId}`;
        }

        return 'Search Terms';
    }

    getContent() 
    {
        return (
            <React.Fragment>
                <FormControl classes={{root: 'MuiFormControl-root'}}>
                            <AsyncSelect 
                        className="'hp-select-search'" 
                        classNamePrefix="hp-select-search" 
                        placeholder={this.getPlaceHolder()} 
                        onChange={this.handleTermIdChange} 
                        loadOptions={this.loadPosts} 
                        noOptionsMessage={() => 'Search terms to continue'}
                    />
                </FormControl>
            </React.Fragment>
        )
    }

    getValuesAsPreview()
    {
        return `Term Id: ${this.data.parameters.termId}`;
    }
}