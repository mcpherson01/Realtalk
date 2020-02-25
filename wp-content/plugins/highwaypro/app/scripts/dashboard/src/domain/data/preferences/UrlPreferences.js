import { PreferencesBase } from './PreferencesBase';

export class UrlPreferences extends PreferencesBase
{
    getName = () => 'UrlPreferences';
    getComponentType = () => 'url';
}