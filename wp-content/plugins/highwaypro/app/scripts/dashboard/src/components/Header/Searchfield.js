import './Searchfield.css';

import Input from '@material-ui/core/Input';
import InputAdornment from '@material-ui/core/InputAdornment';
import PublicRounded from '@material-ui/icons/PublicRounded';

import React, {Component} from 'react';

class Searchfield extends Component {
    render() {
        return (
            <div className="hp-search-field">
                <Input
                    placeholder="Search Url..."
                    startAdornment={<InputAdornment position="start">
                                      <PublicRounded />
                                    </InputAdornment>}
                    disableUnderline={true}
                    fullWidth={true}
                  />
            </div>
        );
    }
}

export default Searchfield;