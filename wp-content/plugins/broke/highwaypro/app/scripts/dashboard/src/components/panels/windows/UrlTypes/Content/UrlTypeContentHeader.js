import './UrlTypeContentHeader.css';

import React, {Component} from 'react';

import { HighWayPro } from '../../../../../domain/highwaypro/HighWayPro';
import { Strings } from '../../../../../domain/utilities/Strings';
import ContentHeaderTitle from
  '../../Urls/UrlsContent/ContentComponents/ContentHeaderTitle';
import UpdateableField from '../../../../Fields/UpdateableField';

class UrlTypeContentHeader extends Component {
    render() {
        return (
            <React.Fragment>
                <ContentHeaderTitle title={this.props.urlType.name}/>
                <header className="hp-url-content-header">
                    <div className="hp-fields">
                        <div className="hp-url-content-header-path-and-url">
                            <div className="hp-url-content-header-path">
                                <UpdateableField 
                                    field="base_path"
                                    entity={this.props.urlType}
                                    label={HighWayPro.text.urls.fields.basePath}
                                    transformInput={Strings.ensureLeadingPath}
                                />
                            </div>
                        </div>
                        <div className="hp-url-content-header-path-and-url">
                            <div className="hp-url-content-header-path">
                                <UpdateableField 
                                    field="name"
                                    entity={this.props.urlType}
                                    label="Name"
                                />
                            </div>
                        </div>
                        <div className="hp-final-url">
                            <div className="hp-url-content-header-final-url --selectable">
                                {HighWayPro.urls.url}{this.props.urlType.base_path}
                            </div>
                            
                        </div>
                    </div>
                </header>
                <div className="hp-notes">
                    {HighWayPro.text.urls.urlTypeBaseUrlMessage.replace(/\*/g, this.props.urlType.base_path.replace(/\//g, ''))}
                </div>
            </React.Fragment>
        );
    }
}

export default UrlTypeContentHeader;