import classnames from 'classnames';

import { HighWayProApp } from '../HighWayProApp';
import { UrlPickerReceiver } from '../domain/urlPicker/UrlPickerReceiver';
import { delay } from '../utilities/delay';
import DeleteIcon from '../../images/delete.svg';

const { wp } =  window;
const Component = HighWayProApp.getComponent();
const $ = jQuery;

const createElement = HighWayProApp.getCreateElement();

export class UrlPicker extends Component
{
    cache = {
        urls: [
            /*{
                name: 'HostGator Promo Link',
                finalUrl: 'neblabs.com/go/hostgator-promo',
                id: 1
            },
            {
                name: 'Corebox - Premium Modern WordPress Magazine/Blog/News Theme | Best of 2018',
                finalUrl: 'neblabs.com/p/98765986',
                id: 2
            },
            {
                name: 'HostGator Promo Link',
                finalUrl: 'neblabs.com/go/hostgator-promo',
                id: 3
            }*/
        ]
    }
    initialState = {
        urls: [
        ],
        isLoading: false,
        currentNavigationUrlIndex: null,
        assignedUrl: null,

        fetchingUrl: false,
        isFetchingSearchedUrls: false,
        searchText: '',

        isOpened: false,
        isOpening: false,
        isClosed: true,
        isClosing: false
    };

    state = Object.assign({}, this.initialState);

    

    classes = {
        withUrls: '--hwpro-with-results',
        urlPicker: 'hwpro-url-picker'
    };

    componentDidMount() 
    {
        document.addEventListener('click', this.handleOutsideClick.bind(this));
    }

    componentDidUpdate() 
    {
        if (this.props.isOpen) {
            if (this.props.urlPickerReceiver != this.state.lastUrlPickerReceiver) {
                this.reset({
                    isClosed: false,
                    isOpened: true
                });
            }            
            this.open();
            this.setUrlIfItHasOne();
        } else if (!this.props.isOpen) {
            this.close();
        }
    }

    render() 
    {
        return (
            <div 
                className={`${this.classes.urlPicker} ${classnames({
                    'hwpro--isOpened': this.state.isOpened,
                    'hwpro--isOpening': this.props.isOpen,
                    'hwpro--isClosing': !this.props.isOpen,
                    'hwpro--isClosed': this.state.isClosed,
                    'hwpro--Left': this.props.position === 'left'                    
                })}`}
                onTransitionEnd={this.handleTransitionEnd.bind(this)}
                style={this.props.coordinates}
            >
                {
                    this.state.fetchingUrl? (
                        <div className="hwpro-searching">
                            <div className="lds-ring"><div></div><div></div><div></div><div></div></div>
                        </div>
                    ) : (
                        <React.Fragment>
                            <input type="search" className="hwpro-search" placeholder={window.HighWayProPostEditor.text.urlPicker.enterUrlToSearch} value={this.state.searchText} onChange={this.handleSearchInput.bind(this)} onKeyDown={this.handleNavigation.bind(this)}/>   
                            <ul className={`hwpro-url-picker-results ${this.hasUrls()? this.classes.withUrls : '' }`}>
                                {this.getAssignedUrlItem()}
                                {this.getItems()}
                            </ul>
                        </React.Fragment>
                    )
                }
            </div>
        );
    }

    getItems() 
    {
        if (this.state.isFetchingSearchedUrls) {
            return (<div className="hwpro-searching">
                        <div className="lds-ring"><div></div><div></div><div></div><div></div></div>
                    </div>);
        }

        if (this.hasUrls()) {
            return this.state.urls.map(url => this.getUrlItem(url));
        }

        // finally, no assigned url and no url items to show...
        if (!this.hasAssignedUrl()) {
            return (
                <div className="hwpro-no-items">
                    <h1>{window.HighWayProPostEditor.text.urlPicker.noUrls.title}</h1>
                    <p>{window.HighWayProPostEditor.text.urlPicker.noUrls.message}</p>
                </div>
            )
        }
    }

    getUrlItem(url, options) 
    {
        options = options || {};
        const assigned = options.assigned;

        return (
            <li 
                key={url.id} 
                data-id={url.id} 
                className={`hwpro-list-url ${classnames({
                    '--hwpro-assigned-url': assigned,
                    '--hwpro-active': this.state.activeUrl && this.state.activeUrl.id === url.id
                })}`}
                onClick={
                    //ignore click on assigned urls, the click event is handled down below
                    assigned? () => {} : this.handleClick(url)
                }
            >
                <div className="hwpro-list-url-item">
                    <div className="hwpro-list-url--name">{url.name}</div>
                    <div className="hwpro-list-url--url">{url.finalUrl}</div>
                </div>
                {assigned && 
                    <div className="hwpro-delete" onClick={this.handleClick(null)}>
                        <DeleteIcon />
                    </div>
                }
            </li>
        );
    }

    /**
     * THIS METHOD IS ALSO USED BY THE DELETE ICON WHEN CLICKED
     * TO REMOVE THE URL
     */
    handleClick(url) 
    {
        return () => this.setState({
            activeUrl: url,
        }, this.handleDesiredUrlHasBeenSelected.bind(this));
    }

    handleSearchInput(event) 
    {
        this.setState({
            searchText: event.target.value,
        }, delay(this.fetchSearchedForUrls.bind(this), 250));
    }

    fetchSearchedForUrls() 
    {
        $.ajax({
            method: 'GET',
            url: window.HighWayProPostEditor.postUrl,
            data: {
                action: 'highwaypro_post',
                path: 'urls',
                data: JSON.stringify({
                    filters: {
                        url: {
                            name: this.state.searchText
                        },
                        limit: 3
                    }
                })
            },
            dataType: 'json',
            beforeSend: () => this.setState({isFetchingSearchedUrls: true}),
            success: this.handleReceivedUrls.bind(this),
            error: () => {console.log('an error')}
        })
    }

    handleReceivedUrls(response) 
    {
        this.setState({
            isFetchingSearchedUrls: false,
            urls: response.urls
        })
    }

    handleNavigation(event) 
    {
        if (UrlPicker.NAVIGATION_KEYS.includes(event.key)) {
            event.preventDefault();

            let newNavigationIndex = this.state.currentNavigationUrlIndex;

            switch (event.key) {
                case 'ArrowDown':
                    if (this.state.currentNavigationUrlIndex < (this.state.urls.length -1)) {
                        ++newNavigationIndex;
                    }
                break;
                case 'ArrowUp':
                    if (this.state.currentNavigationUrlIndex > 0) {
                        --newNavigationIndex;
                    }
                break;
            }

            this.setState(state => ({
                currentNavigationUrlIndex: newNavigationIndex,
                activeUrl: this.state.urls[newNavigationIndex]
            }));
        } else if (event.key === 'Enter') {
            this.handleDesiredUrlHasBeenSelected();
        }
    }

    handleDesiredUrlHasBeenSelected() 
    {
        const activeUrl = this.state.activeUrl;

        this.props.urlPickerReceiver.setId(activeUrl? activeUrl.id : null, this);

        // re-render
        this.close()
    }

    handleOutsideClick(event) 
    {
        let target = $(event.target);
        let customAllowableClicableElement = this.props.customAllowableClicableElement? this.props.customAllowableClicableElement(target) : true;

        let wasClickedOutsidePickerWindow = !target.closest(`.${this.classes.urlPicker}`).length 
                                                && 
                                            !target.closest(this.props.allowedClickableElement).length
                                                &&
                                            customAllowableClicableElement;
        if (this.props.isOpen && wasClickedOutsidePickerWindow) {
           this.props.closeInactive();
        }
    }

    close() 
    {
        if (this.props.isOpen) {
            this.reset();
            this.props.close();
        }
    }

    reset(extra) 
    {
        extra = extra || {};
        this.setState(
            Object.assign(
                this.initialState,
                extra,
                {
                    lastUrlPickerReceiver: this.props.urlPickerReceiver
                }
            )
        );
    }

    open() 
    {
        if (this.state.isOpening || this.state.isOpened) {
            return;
        }

        let then;

        this.setState({
            isClosing: false,
            isClosed: false,
            isOpened: false,
            isOpening: true,
        }, then = () => {
            // after the display block has been applied...
            // wait for the engine not to apply the classes too early
            window.setTimeout(() => {
                this.setState({
                    isClosing: false,
                    isClosed: false,
                    isOpened: true,
                    isOpening: false
                })   
            }, 50);
        });
    }

    setUrlIfItHasOne() 
    {
        const linkId = parseInt(this.props.urlPickerReceiver.getId());
        
        if (this.state.assignedUrl) {
            return;
        }

        if (linkId) {
            const cachedUrl = this.cache.urls.find(url => url.id == linkId);

            if (cachedUrl) {
                this.setAssignedUrl(cachedUrl);
            } else {
                this.fetchUrl(linkId);
            }
        } else {
            this.setAssignedUrl(null);
        }
    }

    fetchUrl(linkId) 
    {
        if (!this.state.fetchingUrl) {
            $.ajax({
                method: 'GET',
                url: window.HighWayProPostEditor.postUrl,
                data: {
                    action: 'highwaypro_post',
                    path: 'url',
                    data: JSON.stringify({
                        'id': linkId
                    })
                },
                dataType: 'json',
                beforeSend: () => this.setState({fetchingUrl: true}),
                success: this.handleReceivedUrl.bind(this),
                error: () => {console.log('an error')}
            })
        }
    }

    handleReceivedUrl(response) 
    {
        this.setAssignedUrl(response.url);
        this.setState({fetchingUrl: false})
    }

    setAssignedUrl(url) 
    {
        if (this.state.assignedUrl != url) {
            this.setState({
                assignedUrl: url
            })
        }
    }

    hasAssignedUrl() 
    {
        return this.state.assignedUrl;
    }

    handleTransitionEnd() 
    {
        if (this.state.isClosing) {
            this.setState({
                isClosing: false,
                isClosed: true,
                isOpening: false,
                isOpened: false
            })
        } else if (this.state.isOpening) {
            this.setState({
                isClosing: false,
                isClosed: false,
                isOpening: false,
                isOpened: true
            })
        } else {
            this.forceUpdate();
        }
    }


    getAssignedUrlItem() 
    {
        if (this.state.assignedUrl) {
            return (
                <div className="hwpro-assigned-url-container">
                    {this.getUrlItem(this.state.assignedUrl, {assigned: true})}
                </div>
            )
        }
    }

    hasUrls() 
    {
        return this.state.urls.length;
    }
}

UrlPicker.NAVIGATION_KEYS = [
    'ArrowDown',
    'ArrowUp'
];

UrlPicker.WIDTH = 282;