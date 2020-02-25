import { HighWayPro } from '../../HighWayPro';

export class UrlPickerReceiver
{
    getId() 
    {
        throw new Error('Method getId() must be extended');
    }

    setId(id, urlPicker) 
    {
        this.handleNewId(id);
    }
}