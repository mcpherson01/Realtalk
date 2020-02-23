(function() {
    tinymce.create('tinymce.plugins.Mayosis', {
        /**
        * Initializes the plugin, this will be executed after the plugin has been created.
        * This call is done before the editor instance has finished it's initialization so use the onInit event
        * of the editor instance to intercept that event.
        *
        * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
        * @param {string} url Absolute URL to where the plugin is located.
        */
        init : function(ed, url) {
            ed.addButton('buttonshortcode', {
                title : 'Insert button shortcode',
                cmd : 'buttonshortcode',
                image : lbdbs_plugin.url + 'img/icon-grey.png'
            });
            ed.addCommand('buttonshortcode', function() {
                ed.windowManager.open({
                    title : 'Insert a Button',
                    body: [
                        {type: 'textbox', name: 'link', label: 'Link'},
                        {type: 'checkbox', name: 'new_tab', label: 'Open link in a new tab'},
                        {type: 'textbox', name: 'content', label: 'Button Text' },
                        
                         {type: 'listbox',
                            name: 'size',
                            label: 'Button Size',
                            'values': [
                                {text: 'XXS', value: 'XXS'},
                                {text: 'XS', value: 'XS'},
                                {text: 'S', value: 'S'},
                                {text: 'M', value: 'M'},
                                {text: 'L', value: 'L'},
                                {text: 'XL', value: 'XL'},
                                {text: 'XXL', value: 'XXL'},
                                {text: '3XL', value: '3XL'},
                                {text: '4XL', value: '4XL'},
                                {text: '5XL', value: '5XL'},
                                
                                
                            ]
                        },
                    
                        {type: 'listbox',
                            name: 'styles',
                            label: 'Button Style',
                            'values': [
                                {text: 'Flat', value: 'flat'},
                                {text: 'Ghost', value: 'ghost'},
                                {text: '3D', value: '3d'},
                                {text: 'Shade', value: 'shade'},
                                {text: 'Link', value: 'link'},
                            ]
                        },
                        
                        {type: 'listbox',
                            name: 'width',
                            label: 'Button Width',
                            'values': [
                                {text: 'Normal', value: 'default'},
                                {text: 'Block', value: 'block'},
                            ]
                        },
                        
                        {type: 'listbox',
                            name: 'hover',
                            label: 'Button Hover',
                            'values': [
                                {text: 'Bright', value: 'bright'},
                                {text: 'Grow', value: 'grow'},
                                {text: 'Pulse Grow', value: 'plusegrow'},
                                {text: 'Float', value: 'float'},
                                {text: 'Buzz Out', value: 'buzzout'},
                                {text: 'Underline Left', value: 'uleft'},
                                {text: 'Underline Center', value: 'ucenter'},
                                {text: 'Underline Right', value: 'uright'},
                                {text: 'Underline Reveal', value: 'ureveal'},
                                {text: 'Overline Reveal', value: 'oreveal'},
                                {text: 'Shadow', value: 'shadow'},
                                {text: 'Float Shadow', value: 'fshadow'},
                            ]
                        },
                        
                        {type: 'listbox',
                            name: 'color',
                            label: 'Button Color',
                            'values': [
                                {text: 'Accent', value: 'accent'},
                                {text: 'Secondary Accent', value: 'secaccent'},
                                {text: 'Text', value: 'text'},
                                {text: 'Red', value: 'red'},
                                {text: 'Black', value: 'black'},
                                {text: 'Blue', value: 'blue'},
                                {text: 'Green', value: 'green'},
                                {text: 'Crimson', value: 'crimson'},
                                {text: 'Deeppink', value: 'deeppink'},
                                {text: 'Orange', value: 'orange'},
                                {text: 'Darkorange', value: 'darkorange'},
                                {text: 'Teal', value: 'teal'},
                                {text: 'White', value: 'white'},
                                {text: 'Limegreen', value: 'lime'},
                                {text: 'Cyan', value: 'cyan'},
                                {text: 'Gold', value: 'gold'},
                                {text: 'Yellow', value: 'yellow'},
                                {text: 'Darkviolet', value: 'darkviolet'},
                            ]
                        },
                        
                         {type: 'listbox',
                            name: 'shape',
                            label: 'Button Shape',
                            'values': [
                                {text: 'Sharp', value: 'sharp'},
                                {text: 'Smooth', value: 'smooth'},
                                {text: 'Smoother', value: 'smooter'},
                                {text: 'Rounded', value: 'rounded'},
                                {text: 'Pill', value: 'pill'},
                            ]
                        },
                       

                        {type: 'textbox', name: 'custom_class', label: 'Custom Button Class'},
                    ],
                    onsubmit: function(e) {
                        ed.focus();

                        // build shortcode that gets inserted into the content when 'ok' is pressed on the modal
                        // [button link="" new_tab="" type="" size="" style="" custom_class=""][/button]
                        ed.selection.setContent('[button link="' + e.data.link + '" new_tab="' + e.data.new_tab + '" size="' + e.data.size + '" width="' + e.data.width + '" style="' + e.data.styles + '"  hover="' + e.data.hover + '" color="' + e.data.color + '" shape="' + e.data.shape + '" custom_class="' + e.data.custom_class + '"  ]' + e.data.content + '[/button]');
                    }
                });
            });
        },

        /**
        * Creates control instances based in the incomming name. This method is normally not
        * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
        * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
        * method can be used to create those.
        *
        * @param {String} n Name of the control to create.
        * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
        * @return {tinymce.ui.Control} New control instance or null if no control was created.
        */
        createControl : function(n, cm) {
            return null;
        },

        /**
        * Returns information about the plugin as a name/value array.
        * The current keys are longname, author, authorurl, infourl and version.
        *
        * @return {Object} Name/value array containing information about the plugin.
        */
        getInfo : function() {
            return {
                longname : 'Mayosis Button Shortcode',
                author : 'Nazmus Shadhat',
                authorurl : 'http://teconce.com',
                version : "1.0"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add( 'mayosis', tinymce.plugins.Mayosis );
})();
