import './Table.css';

import React, {Component} from 'react';
import classnames from 'classnames';

class Table extends Component {
    render() {
        const extraClasses = classnames({
            '--full-width': (this.props.fullWidth === true),
        });

        return (
            <div className={`hp-url-destinations ${this.props.className} --border-${this.props.borderThickness || 'regular'} ${extraClasses}`}>
                {this.props.children}
            </div>
        );
    }
}

export default Table;