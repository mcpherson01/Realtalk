import { PreferencesBase } from './PreferencesBase';

export class DashboardPreferences extends PreferencesBase
{
    getName = () => 'DashboardPreferences';
    getComponentType = () => 'dashboard';
}