import {
  AddShortUrlButtonCentral,
} from '../../components/AddShortUrlButtonCentral';
import { UrlPickerReceiver } from './UrlPickerReceiver';

export class ClassicTextBlockUrlPickerReceiver extends UrlPickerReceiver
{
    constructor(addShortUrlButton) 
    {
        super(addShortUrlButton);

        this.addShortUrlButton = addShortUrlButton;
    }

    getId() 
    {
        if (this.addShortUrlButton.linkElement) {
            return this.addShortUrlButton.linkElement.attr(AddShortUrlButtonCentral.ATTRIBUTES.id);
        }

        return null;
    }

    handleNewId(id) 
    {
        this.addShortUrlButton.handleNewIdReceived(id);
    }
}