import { AddShortUrlButton } from '../../components/gutenberg/AddShortUrlButton';
import { UrlPickerReceiver } from './UrlPickerReceiver';

export class GutenbergTextBlockUrlPickerReceiver extends UrlPickerReceiver
{
    constructor(addShortUrlButton) 
    {
        super(addShortUrlButton);

        this.addShortUrlButton = addShortUrlButton;
    }

    getId() 
    {
        return this.addShortUrlButton.props.activeAttributes['data-id'];
    }

    handleNewId(id) 
    {
        this.addShortUrlButton.handleNewIdReceived(id);
    }
}