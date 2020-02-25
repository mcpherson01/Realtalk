import Urlspanelwindow from '../../Urlspanelwindow';

import './ListOfUrls.css';

import DirectionsRounded from '@material-ui/icons/DirectionsRounded';
import React, {Component} from 'react';

import { Callable } from '../../../../../domain/utilities/Callable';
import IconWithText from '../../../../icons/IconWithText';
import Id from '../../../../icons/Id';
import Notifications from '../../../../notifications/Notifications';
import Table from '../../../../Tables/Table';
import UrlDestinationsLoading from
  '../../Urls/UrlsContent/Destinations/UrlDestinationsLoading';

class ListOfUrls extends Component {
    handleDestinationsLoadError(response) {
        Notifications.addFromResponse(response);
    }

    showMessages = (response) => {
        Notifications.openLoadingNotification(false)
    }

    refresh = () => 
    {
        this.forceUpdate();
    }

    loadUrlsIfItHasNotAlready() 
    {
        if (this.props.urlType.hasNotLoadedUrls()) {
            Notifications.openLoadingNotification(true);
            this.props.urlType.getUrls()
                      .catch(Callable.callAndReturnArgument(this.handleDestinationsLoadError))
                      .then(Callable.callAndReturnArgument(this.refresh))
                      .then(Callable.callAndReturnArgument(this.showMessages));
        }
    }

    openUrlWindow = (url: Url) => () =>
    {
        Urlspanelwindow.setActiveUrl(url);
    }

    render() {
        this.loadUrlsIfItHasNotAlready();

        if (this.props.urlType.hasNotLoadedUrls()) {
            return <UrlDestinationsLoading title="Loading Urls..." />
        }

        return (
            <div className="hp-list-of-urls">
                {this.props.urlType.loadedUrls.length > 0 && (
                    <header>
                        <span className="hp-count">{this.props.urlType.loadedUrls.length || 'No'} </span>
                        <span className="hp-lou-name">{this.props.urlType.name} </span>
                        <span className="hp-lou-type">URLS</span>
                    </header>
                )}
                <Table className="hp-lou-list" fullWidth={true} borderThickness="thin">
                    {this.props.urlType.loadedUrls.map((url: Url) => (
                        <div className="hp-url-destination" onClick={this.openUrlWindow(url)}>
                            <Id id={url.id} />
                            <div className="hp-name-and-path-list">
                                <div className="hp-list-of-urls--name">{url.name}</div>
                                <div className="hp-list-of-urls--path"><span className="hp-lou-base">{this.props.urlType.base_path}</span>{url.path}</div>
                            </div>
                         </div>
                    ))}
                    {!this.props.urlType.loadedUrls.length && (
                        <IconWithText icon={<DirectionsRounded />} title="No URLS associated with this type" text="There are no URLS asscoaited with this type."/>
                    )}
                </Table>
            </div>
        );
    }
}

export default ListOfUrls;