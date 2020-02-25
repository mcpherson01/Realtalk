import { PreferencesBase } from './PreferencesBase';

export class SocialPreferences extends  PreferencesBase
{
    getName = () => 'SocialPreferences';
    getComponentType = () => 'social';
}