import milliseconds from 'delay';

import './Buzz.css';

import React, {Component} from 'react';
import classnames from 'classnames';

class Buzz extends Component {

    async componentDidUpdate() {
        if (this.props.shouldBuzz) {
            await milliseconds(150);
            this.props.afterBuzz();
        }
    }

    render() {
        const classes = classnames({
            'hp-buzz': true,
            '--active': this.props.shouldBuzz,
            ...this.props.classes
        });

        return (
            <div className={classes} style={{position: this.props.position || 'absolute'}}>
                {this.props.children}
            </div>
        );
    }
}

export default Buzz;