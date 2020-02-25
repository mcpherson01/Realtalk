
import FormControl from '@material-ui/core/FormControl';
import FormHelperText from '@material-ui/core/FormHelperText';
import InputLabel from '@material-ui/core/InputLabel';
import MenuItem from '@material-ui/core/MenuItem';
import PeopleRounded from '@material-ui/icons/PeopleRounded';
import React from 'react';
import Select from '@material-ui/core/Select';
import classnames from 'classnames';

import { BuiltInComponent } from '../BuiltInComponent';
import DashboardLink from '../../../../components/Buttons/DashboardLink';

export class UserRoleCondition extends BuiltInComponent {
    static type = 'condition';
    static getIdStatic() { return 'highwaypro.UserRoleCondition';}
    getId() { return UserRoleCondition.getIdStatic() } 
    icon = (<PeopleRounded />);

    initialState = {
        userType: this.data.parameters.userType || [],
        roles: this.data.parameters.roles || [],
        capabilities: this.data.parameters.capabilities || []
    }

    handleChange = field => event => {
        this.reactComponent.setState({
            [field]: event.target.value
        });
    }

    rolesAndCapabilitiesAreDisabled() {
        return this.reactComponent.state.userType !== 'loggedwithrole';
    }

    getContent() 
    {
        const disableStateClass = classnames({
            '--disabled': this.rolesAndCapabilitiesAreDisabled()
        });

        return (
        <React.Fragment>
            <FormControl classes={{root: 'MuiFormControl-root'}}>
              <InputLabel>User Type</InputLabel>
              <Select classes={{root:'MuiInputBase-input MuiInput-underline'}}

                value={this.reactComponent.state.userType}
                onChange={this.handleChange('userType')}
              >
                {this.getUserTypesMenuItems()}
              </Select>
            </FormControl>
            <FormControl classes={{root: 'MuiFormControl-root'}} className={disableStateClass} disabled={this.rolesAndCapabilitiesAreDisabled()}>
              <InputLabel>User Roles Allowed</InputLabel>
              <Select
                multiple
                value={this.reactComponent.state.roles}
                onChange={this.handleChange('roles')}
              >
                {this.getUserRolesMenuItems()}
              </Select>
               <FormHelperText classes={{root: 'MuiFormHelperText'}}>User roles include WordPress default roles as well as roles registered with a plugin. <DashboardLink href="https://codex.wordpress.org/Roles_and_Capabilities">Learn More</DashboardLink>.</FormHelperText>
            </FormControl>
            <FormControl classes={{root: 'MuiFormControl-root'}} className={disableStateClass} disabled={this.rolesAndCapabilitiesAreDisabled()}>
              <InputLabel>User Capabilities Allowed</InputLabel>
              <Select
                multiple
                value={this.reactComponent.state.capabilities}
                onChange={this.handleChange('capabilities')}
              >
                {this.getUserCapabilitiesMenuItems()}
              </Select>
               <FormHelperText classes={{root: 'MuiFormHelperText'}}>User capabilities include WordPress default capabilities as well as capabilities registered with a plugin. <DashboardLink href="https://codex.wordpress.org/Roles_and_Capabilities">Learn More</DashboardLink>.</FormHelperText>
            </FormControl>
        </React.Fragment>
        )
    }

    getUserTypesMenuItems = () => {
        const menuItems = [];

        for (let userType in this.allowed.userType) {
            menuItems.push((<MenuItem
                    key={userType}
                    value={userType}
                    style={{
                      fontWeight:
                        this.reactComponent.state.userType.indexOf(userType) === -1
                          ? 400
                          : 600,
                    }}
                  >
                    {this.allowed.userType[userType]}
                  </MenuItem>));   
        }

        return menuItems;
    }

    getUserRolesMenuItems = () => {
        const capabilitiesRoles = this.allowed.roles.map(role => (<MenuItem
                    key={role}
                    value={role}
                    style={{
                      fontWeight:
                        this.reactComponent.state.roles.indexOf(role) === -1
                          ? 400
                          : 600,
                    }}
                  >
                    {role}
                  </MenuItem>));   

        return capabilitiesRoles;
    }

    getUserCapabilitiesMenuItems = () => {
        const capabilitiesItems = this.allowed.capabilities.map(capabilities => (<MenuItem
                    key={capabilities}
                    value={capabilities}
                    style={{
                      fontWeight:
                        this.reactComponent.state.capabilities.indexOf(capabilities) === -1
                          ? 400
                          : 600,
                    }}
                  >
                    {capabilities}
                  </MenuItem>));  

        return capabilitiesItems;

    }

    getValuesAsPreview()
    {
        return this.allowed.userType[this.data.parameters.userType];
    }
}