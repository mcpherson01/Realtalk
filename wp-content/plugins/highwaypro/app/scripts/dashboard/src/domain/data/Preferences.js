import { Domain } from './domain/Domain';
import { HighWayPro } from '../highwaypro/HighWayPro';
import { PostPreferences } from './preferences/PostPreferences';
import { SocialPreferences } from './preferences/SocialPreferences';
import { UrlPreferences } from './preferences/UrlPreferences';
import { DashboardPreferences } from './preferences/DashboardPreferences';
import { clone } from '../utilities/clone';

export class Preferences extends Domain
{
    getName = () => 'Preferences';

    static createFromGlobals() 
    {
        if (!(Preferences.preferences instanceof Preferences)) {
            Preferences.preferences = new Preferences(HighWayPro.preferences);
        }
        
        return Preferences.preferences;
    }

    constructor(preferencesData) 
    {
        super();

        if (this.getName() === 'Preferences') {
            
            this.preferencesData = clone(preferencesData);
            
            this.url = new UrlPreferences(this, this.preferencesData.url);
            this.social = new SocialPreferences(this, this.preferencesData.social);
            this.post = new PostPreferences(this, this.preferencesData.post);
            this.dashboard = new DashboardPreferences(this, this.preferencesData.dashboard);
        }
    }
}