import './UrlContentHeader.css';

import FilterTiltShiftRounded from '@material-ui/icons/FilterTiltShiftRounded';
import React, {Component} from 'react';

import { Callable } from '../../../../../domain/utilities/Callable';
import { HighWayPro } from '../../../../../domain/highwaypro/HighWayPro';
import { Strings } from '../../../../../domain/utilities/Strings';
import ContentHeaderTitle from './ContentComponents/ContentHeaderTitle';
import DashboardLink from '../../../../Buttons/DashboardLink';
import Id from '../../../../icons/Id';
import Notifications from '../../../../notifications/Notifications';
import UpdateableField from '../../../../Fields/UpdateableField';
import UrlTypeMenu from '../UrlTypeMenu';

class UrlContentHeader extends Component {
    state = {
        path: 'unactive',
        name: 'unactive'
    }

    beforeEdition = {
        path: '',
        name: '',
        type_id: 0
    }

    constructor(properties)
    {
        super(properties);

        this.initializeState();
    }

    initializeState() 
    {
        this.beforeEdition = {
            path: this.props.url.path,
            name: this.props.url.name,
            type_id: this.props.url.type_id
        }    
    }

    handleBasePathChange = (event) => {
        
        this.beforeEdition.type_id = this.props.url.type_id;

        this.props.url.update(url => {
            const urlTypeId = event.target.value;

            url.type_id = urlTypeId;
        });

        this.update('type_id');
    }

    storeValueBeforeEdition = (field, event) => {
        this.beforeEdition[field] = event.target.value;
    }

    handleChange = (field, event) => {
        let value = event.target.value;

        if (field === 'path') {
            value = Strings.ensureLeadingPath(value);
        }

        this.updateUrlField(this.props.url, field, value);
    }

    updateUrlField = (url, field, value) => {
        url.update(_url => {
            _url[field] = value;
        });
    }

    valueHasChanged = (field) => {
        return this.beforeEdition[field] !== this.props.url[field];
    }

    update = (field) => {
        if (this.valueHasChanged(field)) {
            Notifications.openLoadingNotification(true, HighWayPro.text.other.saving);

            this.props.url.updateField(field)
                          .then(
                            Callable.callAndReturnArgument(this.handleSuccess.bind(this, this.props.url, field))
                           )
                          .catch(
                            Callable.callAndReturnArgument(this.handleUpdateError.bind(this, this.props.url, field))
                           )
                          .then(
                            Callable.callAndReturnArgument(this.showNotification)
                           );
        }
    }

    handleSuccess = (url, field, response) => {
        this.changeFieldStateTo({name: field, state: 'success'});
        this.refreshUrl(url, response);
    }

    refreshUrl(url, response) 
    {
        url.update(_url => {
            _url.setFieldsFromObject(response.url);   
        });
    }

    handleUpdateError = (url, field) => {
        this.updateUrlField(url, field, this.beforeEdition[field]); 
        this.changeFieldStateTo({name: field, state: 'error'}) 
    }

    changeFieldStateTo(field) {
        this.setState({
            [field.name]: field.state
        })
    }

    showNotification(response) {
        Notifications.openLoadingNotification(false);
        Notifications.addFromResponse(response);
    }

    getInputPropertiesFor(field) {
        return {
            onFocus: this.storeValueBeforeEdition.bind(this, field),
            onBlur: this.update.bind(this, field)
        };
    }

    render() {
        return (
        <React.Fragment>
            <div className="hp-url-content-header-type">
                <span className="hp-icon">
                    <FilterTiltShiftRounded />
                </span>
                <span className="hp-type-name">
                    {this.props.url.getType().name || 'No Type'}
                </span>
            </div>
            <ContentHeaderTitle title={this.props.url.name}/>
            <header className="hp-url-content-header">
                <Id id={this.props.url.id} />
                <div className="hp-fields">
                    <div className="hp-url-content-header-path-and-url">
                        <div className="hp-url-content-header-path">
                            <div className="hp-url-content-header-base-path">
                                <UrlTypeMenu 
                                    typeId={this.props.url.getType().id} 
                                    whenChanged={this.handleBasePathChange}
                                    label={HighWayPro.text.urls.fields.basePath_short}
                                />
                            </div>
                            <UpdateableField 
                                field="path"
                                fieldsToUpdate={["path", "finalUrl"]}
                                entity={this.props.url}
                                label={HighWayPro.text.urls.fields.path}
                                transformInput={Strings.ensureLeadingPath}
                            />
                        </div>
                    </div>
                    <div className="hp-url-content-header-path-and-url">
                        <div className="hp-url-content-header-path hp-url-content-header-name">
                            <UpdateableField 
                                field="name"
                                entity={this.props.url}
                                label={HighWayPro.text.urls.fields.name}
                            />

                        </div>
                    </div>
                    <div className="hp-final-url">
                        <div className="hp-url-content-header-final-url --selectable">
                            {this.props.url.finalUrl}
                        </div>
                        <DashboardLink className="hp-view" href={this.props.url.finalUrl}>
                            {HighWayPro.text.urls.view}
                        </DashboardLink>
                    </div>
                </div>
            </header>
        </React.Fragment>
        );
    }
}

export default UrlContentHeader;