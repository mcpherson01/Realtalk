import { BuiltInComponent } from './BuiltInComponent';

export class EmptyBuiltInComponent extends BuiltInComponent
{
    getMetaData()
    {
        return {
            title: 'none'
        }
    }
}
