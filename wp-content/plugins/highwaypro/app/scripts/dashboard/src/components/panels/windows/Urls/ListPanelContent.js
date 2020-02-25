import './ListPanelContent.css';

import OpenInBrowserRounded from '@material-ui/icons/OpenInBrowserRounded';
import React, {Component} from 'react';

import IconWithText from '../../../icons/IconWithText';

class ListPanelContent extends Component {
    render() {
        if (this.props.item instanceof this.props.instanceType) {
            return (
                <div className="hp-url-content">
                    {this.getBackButton()}
                    {this.props.renderContent(this.props.item)}
                </div>
            );
        }

        return this.props.noItemSelectedContent || (<div className="hp-content-no-item-selected">
                    <IconWithText 
                                classes="--self-centered-horizontally"
                                icon={<OpenInBrowserRounded />}
                                title={`No ${this.props.name} selected!`} 
                                text="Please select an item from the left sidebar or create a new one to get started."
                            />
                </div>);
    }

    getBackButton() 
    {
        return <button className="hp-content--close hp-button" onMouseDown={this.props.toggleVisibility}>Back</button>
    }
}

export default ListPanelContent;