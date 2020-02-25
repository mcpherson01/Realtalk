"use strict";

var _richText = require("@wordpress/rich-text");

var _blockEditor = require("@wordpress/block-editor");

var MyCustomButton = function MyCustomButton(props) {
  return wp.element.createElement(_blockEditor.RichTextToolbarButton, {
    icon: "editor-code",
    title: "Sample output",
    onClick: function onClick() {
      console.log('toggle format');
    }
  });
};

(0, _richText.registerFormatType)('my-custom-format/sample-output', {
  title: 'Sample output',
  tagName: 'samp',
  className: null,
  edit: MyCustomButton
});
//# sourceMappingURL=wds-link-format-button.js.map
