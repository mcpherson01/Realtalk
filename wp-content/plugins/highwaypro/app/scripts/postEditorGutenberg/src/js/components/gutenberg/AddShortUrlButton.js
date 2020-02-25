import { AddShortUrlButtonCentral } from '../AddShortUrlButtonCentral';
import {
  GutenbergTextBlockUrlPickerReceiver,
} from '../../domain/urlPicker/GutenbergTextBlockUrlPickerReceiver';
import { HighWayPro } from '../../HighWayPro';
import { HighWayProApp } from '../../HighWayProApp';
import { UrlPicker } from '../UrlPicker';
import ElementIcon from '../../../images/logo.svg';

const { wp } =  window;
const { Fragment, Component } = wp.element;
const { registerFormatType, unregisterFormatType } = wp.richText;
const { RichTextToolbarButton } = wp.editor;
const $ = jQuery;

const createElement = HighWayProApp.getCreateElement();

export default class AddShortUrlButton extends Component
{
    static NAME = 'highwaypro/add-short-url';

    static register()
    {
        document.createElement(AddShortUrlButton.TAG_NAME);

        registerFormatType(AddShortUrlButton.NAME, {
            title: AddShortUrlButtonCentral.TITLE,
            tagName: AddShortUrlButtonCentral.TAG_NAME,
            className: AddShortUrlButtonCentral.CLASSES,
            attributes: {
                [AddShortUrlButtonCentral.ATTRIBUTES.id]: AddShortUrlButtonCentral.ATTRIBUTES.id,
            },
            edit: AddShortUrlButton
        });
    }

    state = {
        urlPickerReceiver: null,
        isOpen: false,
        addUrl: false
    }

    componentDidUpdate() 
    {
        if (this.props.isActive && !this.state.isOpen) {
            this.open({
                origin: 'fromExistingFormat'
            });
        } else {
             if (!this.props.isActive && this.state.openOrigin === 'fromExistingFormat') {
                this.close();
            }
        }
    }

    render() {
        return (
            <Fragment>
                <RichTextToolbarButton
                    icon={ <ElementIcon /> }
                    title="HighWayPro Short Url"
                    onClick={this.open.bind(this, {
                        origin: 'fromClick'
                    })}
                />
                <UrlPicker 
                    isOpen={this.state.isOpen}
                    urlPickerReceiver={new GutenbergTextBlockUrlPickerReceiver(this)}
                    coordinates={AddShortUrlButtonCentral.getCurrentCoordinates()}
                    allowedClickableElement=".components-button"
                    close={this.close.bind(this)}
                    closeInactive={this.closeInactive.bind(this)}
                />
            </Fragment>
        );
    }

    open(openOrigin) 
    {
        this.setState({
            isOpen: true,
            openOrigin: openOrigin.origin
        })
    }

    explicitelyOpen() 
    {
        this.setState({
            isOpen: true,
            openFromClick: true
        })
    }

    close() 
    {
        if (this.state.isOpen) {
            this.setState({
                isOpen: false,
                addUrl: false,
                urlPickerReceiver: null
            })
        }
    }

    closeInactive() 
    {
        if (!this.props.isActive) {
            this.close();
        }
    }

    handleNewIdReceived(id) 
    {
        // converted to string which it seems breaks with any other data type
        id = id? `${id}` : '';

        const action = id? wp.richText.applyFormat : wp.richText.toggleFormat;

        this.props.onChange(action(
            this.props.value,
            {
                type: AddShortUrlButton.NAME,
                attributes: {
                    'data-id': id
                }
            }
        ) );
    }
}