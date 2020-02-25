import { AddShortUrlButtonCentral } from '../AddShortUrlButtonCentral';
import {
  ClassicTextBlockUrlPickerReceiver,
} from '../../domain/urlPicker/ClassicTextBlockUrlPickerReceiver';
import { HighWayProApp } from '../../HighWayProApp';
import { UrlPicker } from '../UrlPicker';

const { wp } =  window;

let Component;

if (wp && wp.element) {
    Component = wp.element.Component
} else {
    Component = window.React.Component;
}

const createElement = HighWayProApp.getCreateElement();

const $ = jQuery;



export default class AddShortUrlButton extends Component
{
    static register()
    {
        document.createElement(AddShortUrlButtonCentral.TAG_NAME);

        tinymce.PluginManager.add('myplugin', (editor, url) => {

            editor.addCommand(
                'HighWayPro_handleAddButtonWasCliked', AddShortUrlButton.handleAddButtonWasCliked
            );

            editor.addButton( 'myplugin' , {
                title : AddShortUrlButtonCentral.TITLE,
                image : window.HighWayProPostEditor.pluginURI + 'app/scripts/postEditorGutenberg/src/images/logo.svg',
                cmd   : 'HighWayPro_handleAddButtonWasCliked',
                onpostrender: function() {
                    jQuery('<div id="highwaypro-classic-editor-picker"></div>').appendTo(jQuery('body'));
                    
                    ReactDOM.render(
                        <AddShortUrlButton editor={editor}/>, 
                        document.getElementById('highwaypro-classic-editor-picker')
                    );
                }
            });

        });
    }

    state = {
        isOpen: false,

    }

    componentDidMount() 
    {
        AddShortUrlButton.instance = this;

        this.props.editor.on('click', this.handleEditorWasClicked.bind(this));
    }

    render() 
    {
        return (
            <UrlPicker 
                isOpen={this.state.isOpen}
                urlPickerReceiver={new ClassicTextBlockUrlPickerReceiver(this)}
                coordinates={this.getCurrentCoordinates()}
                allowedClickableElement=".mce-btn"
                customAllowableClicableElement={this.isCustomAllowableClicableElement.bind(this)}
                close={this.close.bind(this)}
                closeInactive={this.closeInactive.bind(this)}
                position="left"
            />
       )
    }

    open(optionalLinkElement) 
    {
        // used by: ClassicTextBlockUrlPickerReceiver
        this.linkElement = optionalLinkElement;

        this.setState({
            isOpen: true
        })
    }

    close() 
    {
        if (this.state.isOpen) {
            this.setState({
                isOpen: false
            });
        }
    }

                    
    closeInactive() 
    {
        this.setState({
            isOpen: false
        })
    }

    isCustomAllowableClicableElement($target) 
    {
        return $target == this.linkElement;
    }

    handleEditorWasClicked(event) 
    {
        const target = $(event.target);

        if (target.hasClass(AddShortUrlButtonCentral.CLASSES)) {

            this.open(target);
        } else if (!target.hasClass('hwpro-url-picker')) {
            this.close();
        }
    }

    handleNewIdReceived(id) 
    {
        // we are editing an existing link
        if (this.linkElement) {

            if (id) {
                this.linkElement.attr(AddShortUrlButtonCentral.ATTRIBUTES.id, id);
            } else {
                // remove the link
                this.linkElement.contents().unwrap();
            }
        } else {
            // we're creating a new link from scratch!
            if (id) {
                this.props.editor.execCommand(
                    'mceReplaceContent', 
                    false, 
                    `<hwprourl class="${AddShortUrlButtonCentral.CLASSES}" ${AddShortUrlButtonCentral.ATTRIBUTES.id}="${id}">{$selection}</hwprourl>`
                )
            }
        }
    }

    static handleAddButtonWasCliked() 
    {
        AddShortUrlButton.instance.open();
    }

    getCurrentCoordinates() 
    {
        if (!this.state.isOpen) {
            return {};
        }

        /**
         * Shame-lessly borrowed from: 
         * 
         * https://github.com/abrimo/TinyMCE-Autocomplete-Plugin/blob/master/src/autocomplete/editor_plugin_src.js
         *
         * Thanks a ton!
         * 
         * Talk about backwards compatibility!
         *
         */
        
        var editorContainer = this.props.editor.getContainer();

        if (editorContainer) {
            var editorElement = jQuery(editorContainer);
        } else {
            var editorElement = jQuery(`#${this.props.editor.id}`);
        }

        var tinymcePosition = editorElement.offset();
        var toolbarPosition = editorElement.find(".mce-toolbar-grp").first();
        var nodePosition = jQuery(this.props.editor.selection.getNode()).position();
        var textareaTop = 0;
        var textareaLeft = 0;
        if (this.props.editor.selection.getRng().getClientRects().length > 0) {
            textareaTop = this.props.editor.selection.getRng().getClientRects()[0].top + this.props.editor.selection.getRng().getClientRects()[0].height;
            textareaLeft = this.props.editor.selection.getRng().getClientRects()[0].left;
        } else {
            textareaTop = parseInt(jQuery(this.props.editor.selection.getNode()).css("font-size")) * 1.3 + nodePosition.top;
            textareaLeft = nodePosition.left;
        }

        const lineHeight = 5;

        if (editorContainer) {
            var top = tinymcePosition.top + toolbarPosition.innerHeight() + textareaTop + lineHeight
            var left = tinymcePosition.left + textareaLeft;
        } else {
            var top = toolbarPosition.innerHeight() + textareaTop + lineHeight;
            var left = textareaLeft;
        }

        return {
            top: top - $(window).scrollTop(),
            left: AddShortUrlButtonCentral.calculateViewableLeftCoordinates(left)
        };
    }
}