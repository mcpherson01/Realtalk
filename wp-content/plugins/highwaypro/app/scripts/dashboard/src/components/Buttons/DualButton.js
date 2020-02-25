import './DualButton.css';

import React, {Component} from 'react';

import Button from './Button';

class DualButton extends Component {
    render() {
        const buttons = [this.props.buttons.left, this.props.buttons.right];

        return (
            <div className={`hp-dual-button ${this.props.classes}`}>
                {buttons.map(button => 
                    <Button whenClicked={button.whenClicked} width={button.width || 50} classes={`${button.classes}`} style="line">
                        {button.text}
                    </Button>               
                )}
            </div>
        );
    }
}

export default DualButton;