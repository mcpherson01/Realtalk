import './DestinationComponentMenu.css';

import ClickAwayListener from '@material-ui/core/ClickAwayListener';
import React, {Component} from 'react';
import _ from 'lodash';
import classnames from 'classnames';
import delay from 'delay';

import {
  BuiltInComponent,
} from '../../../../../../../domain/destinationcomponents/builtin/BuiltInComponent';
import {DestinationComponentsManager} from
  '../../../../../../../domain/destinationcomponents/DestinationComponentsManager';
import {
  Events,
} from '../../../../../../../domain/behaviour/events/events/Events';
import { HighWayPro } from '../../../../../../../domain/highwaypro/HighWayPro';
import {clone} from '../../../../../../../domain/utilities/clone';
import Buzz from '../../../../../../Buttons/Buzz';
import DestinationComponentMenuItem from './DestinationComponentMenuItem';
import DestinationComponentMenuItemContent from
  './DestinationComponentMenuItemContent';
import jQuery from 'jquery';

class DestinationComponentMenu extends Component {
    menu = React.createRef();
    menus = React.createRef();
    conditionsElement = React.createRef();
    lastTop = '0';

    initialState = {
        height: 'initial',
        itemIsSelected: false,
        selectedItemId: null,
        finishedClosing: true
    }

    state = clone(this.initialState);

    resetState = () => {
        this.setState(clone(this.initialState));
    }

    handleOutsideClick = (event) => {
        
        if (!this.props.isOpened) {
            return;
        }
        
        if (this.clickIsOutsideMenu(event)) {
            if (!this.state.itemIsSelected) {
                this.props.parent.setState({
                    isOpened: false,
                });
            } else {
                this.setState({
                    shouldBuzz: true
                });
            }
        }
        
    }

    clickIsOutsideMenu = (event) => {
        const menuCoordinates = this.menu.current.getBoundingClientRect();

        const element_horizontal_AreaStart = menuCoordinates.left;
        const element_horizontal_AreaEnd = element_horizontal_AreaStart + menuCoordinates.width;

        const element_vertical_AreaStart = menuCoordinates.top;
        const element_vertical_AreaEnd = element_vertical_AreaStart + menuCoordinates.height;

        const horizontalClickPosition = event.clientX;
        const verticalClickPosition = event.clientY;

        const clickIsOutsideHorizontalRange = 
               horizontalClickPosition < element_horizontal_AreaStart || 
               horizontalClickPosition > element_horizontal_AreaEnd;

        const clickIsOutsideVerticalRange = 
               verticalClickPosition < element_vertical_AreaStart || 
               verticalClickPosition > element_vertical_AreaEnd;

        return clickIsOutsideHorizontalRange || clickIsOutsideVerticalRange;
    }

    afterBuzz = () => {
        this.setState({
            shouldBuzz: false
        });
    }

    setItemIsSelected = (isSelected) => {
        this.setState({
            itemIsSelected: isSelected
        });
    }

    handleMenuItemClick = id => {
        this.setState({
            selectedItemId: id,
            itemIsSelected: true
        });
    }

    handleContentClose = action => {
        if (action === 'close') {
            this.resetState();
            this.props.parent.close();
        } else if (action === 'back') {
            this.resetState();
        }
    }

    heightIs = (height) => {
        return this.state.height === height;
    }

    handleContentActive = menuItemContent => {
        const changeHeight = () => {
            if (!this.heightIs(menuItemContent.offsetHeight)) {
                this.setState({
                    height: menuItemContent.offsetHeight
                });
            }
        };

        if (this.state.itemIsSelected) {
            delay(10).then(changeHeight);
        } else {
            changeHeight();
        }
        
    }

    componentDidMount = () => {
        this.setScreenToCurrentComponent();
        
        this.menu.current.addEventListener('transitionend', this.handleEndOfTransition);    
        this.menu.current.addEventListener('webkitTransitionEnd', this.handleEndOfTransition);
        this.menu.current.addEventListener('oTransitionEnd', this.handleEndOfTransition);
    }

    handleEndOfTransition = (event) => {
        if (event.propertyName === 'transform') {
            if (this.props.isOpened) {
                if (!this.state.itemIsSelected) {
                    Events.call(
                        DestinationComponentMenu.EVENTS.FINISHED_OPENING,
                        {
                            type: this.props.type
                        }
                    )
                } else {
                    Events.call(
                        DestinationComponentMenu.EVENTS.FINISHED_OPENING_ITEM_CONTENT,
                        {
                            componentType: this.props.type,
                        }
                    )
                }
            } else {
                Events.call(
                    DestinationComponentMenu.EVENTS.FINISHED_CLOSING,
                    {
                        type: this.props.type
                    }
                )
            }

            this.setState({
                finishedClosing: true
            });
        }
    }

    componentDidUpdate = () => {
        let menusHeight = this.menus.current.offsetHeight + 44;

        if (!this.state.itemIsSelected && !this.heightIs(menusHeight)) {
            this.setState({
                height: menusHeight
            });
        }

        this.setScreenToCurrentComponent();
    }

    setScreenToCurrentComponent() 
    {
        if ((!this.props.isOpened) && 
            (this.props.componentElement instanceof BuiltInComponent) &&
            (this.props.componentElement.getId() !== this.state.selectedItemId)) {
            this.handleMenuItemClick(this.props.componentElement.getId())
        }    
    }

    render() {
        let stateClasses = {
            '--active': this.props.isOpened,
            '--active-item': this.state.itemIsSelected,
            '--unactive': this.state.finishedClosing && !this.props.isOpened,
        };

        let classes = classnames({
            'hp-destination-component-menu': true,
            ...stateClasses
        });

        let containerClasses = classnames({
            'hp-destination-component-menu-container': true,
            ...stateClasses
        });

        return (
            <ClickAwayListener onClickAway={this.handleOutsideClick}>
                <Buzz shouldBuzz={this.state.shouldBuzz} afterBuzz={this.afterBuzz}>
                  <div className={containerClasses}>
                    <div className={classes} style={this.getMenuStyles()} ref={this.menu}>
                        <div className="hp-destinations-component-menus" ref={this.menus}>
                            <header className="hp-destination-component-menu-header">
                                <h1>{HighWayPro.text.destinations.selectATypeTitle.replace('*', _.startCase(this.props.type))}</h1>
                                <div className="hp-help-text">
                                    {HighWayPro[`${this.props.type.toLowerCase()}Data`].split("\n").map(line => (<p>{line}</p>))}                  
                                </div>
                            </header>
                            <hr className="hp-header-separator" />
                            <div className="hp-conditions" ref={this.conditionsElement}>
                                {this.props.componentElements.map(componentElement => {
                                    return (<DestinationComponentMenuItem key={componentElement.getId()} type={this.props.type} componentElement={componentElement} whenClicked={this.handleMenuItemClick}/>)
                                })}
                            </div>
                        </div>
                        <div className="hp-destinations-component-contents">
                            {this.props.componentElements.map(componentElement => {
                                return (<DestinationComponentMenuItemContent menuItemRef={this.menuItemRef} key={componentElement.getId()} type={this.props.type} destination={this.props.destination} componentElement={componentElement} selectedItemId={this.state.selectedItemId} whenContentClosed={this.handleContentClose} whenElementBecomesActive={this.handleContentActive}/>)
                            })}
                        </div>
                    </div>
                  </div>
                </Buzz>
            </ClickAwayListener>
        );
    }

    getMenuStyles() 
    {
        return {
            height: this.state.height,
            left: this.props.coordinates.left,
            top: this.props.isOpened? 
                this.getTop():
                //((this.props.coordinates.top + (this.props.coordinates.height / 2)) - (this.menu.current.offsetHeight / 2)) : 
                this.lastTop,

        };
    }

    getTop() 
    {
        const heightOfTheMenu = this.state.height;
        const halfTheHeightOfTheMenu = (heightOfTheMenu / 2);

        let top = halfTheHeightOfTheMenu;

        const absoluteTopOfMenu = (this.props.coordinates.top + this.props.coordinates.height);
        const relativeTopOfMenu = this.props.coordinates.viewportTop;

        const menuOverFlowsBottomViewport = window.innerHeight < absoluteTopOfMenu + halfTheHeightOfTheMenu;
        const menuOverFlowsTopViewport = relativeTopOfMenu < halfTheHeightOfTheMenu;

        const availableBelowSpace = window.innerHeight - absoluteTopOfMenu;

        console.log(heightOfTheMenu, availableBelowSpace);

        let belowSpace = 0;

        if (menuOverFlowsTopViewport) {
            const newTop = 0 + 68;
            this.lastTop = newTop

            return newTop; // 65 = header height
        } else if (menuOverFlowsBottomViewport) {
            belowSpace = (heightOfTheMenu - (availableBelowSpace - 10));
        } else {
            belowSpace = (halfTheHeightOfTheMenu + (this.props.coordinates.height / 2))
        }

        const newTop = (absoluteTopOfMenu - belowSpace);

        this.lastTop = newTop;

        return newTop;
    }
}

DestinationComponentMenu.EVENTS = {
    FINISHED_OPENING: 'DestinationComponentMenu.events.finished_opening',
    FINISHED_OPENING_ITEM_CONTENT: 'DestinationComponentMenu.events.finished_opening_item_content',
    FINISHED_CLOSING: 'DestinationComponentMenu.events.finished_closing',
}

export default DestinationComponentMenu;