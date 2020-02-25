import './Header.css';

import React, {Component} from 'react';

import Logo from './Logo';
import SearchField from './Searchfield';

class Header extends Component {
    rootElement = React.createRef();
    static element = {};
    
    componentDidMount() {
        Header.element = this.rootElement.current;
        this.props.whenRendered(this.rootElement.current);
    }

    render() {
        return (
            <React.Fragment>
                {this.getMobileMessage()}
                <header id="hp-header" className="hp-header" ref={this.rootElement}>
                    <Logo />
                    {/*coming soon!*/ false && (<SearchField />)}<input type="text" onChange={() => alert('changin')}/>
                </header>

            </React.Fragment>
        );
    }

    getMobileMessage() 
    {
        return (
            <div className="hp-mobile-beta-message">The mobile version of the HighWayPro dashboard is in beta.</div>
        )
    }
}

export default Header;