import { PreferencesBase } from './PreferencesBase';

export class PostPreferences extends PreferencesBase
{
    getName = () => 'PostPreferences';
    getComponentType = () => 'post';
}