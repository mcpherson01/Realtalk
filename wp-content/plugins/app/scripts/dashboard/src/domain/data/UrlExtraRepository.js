import { Domain } from './domain/Domain';
import { HighWayPro } from '../highwaypro/HighWayPro';
import { UrlExtra } from './UrlExtra';
import { clone } from '../utilities/clone';

export class UrlExtraRepository extends Domain
{
    getName = () => 'UrlExtraRepository';

    constructor(extraItems, url: Url) 
    {
        super();

        this.items = extraItems || [];
        this.url = url;

        // duplicate the defaults array for this url
        this.defaults =  HighWayPro.urlExtras.default.slice(0);

        for (let defaultExtra of this.defaults) {
            const defaultExtraWasNotFound = this.items.find(extra => extra.name === defaultExtra.name);

            if (!defaultExtraWasNotFound) {
                this.items.push(Object.assign({}, defaultExtra, {url_id: this.url.id}));
            }
        }

        this.items = this.items.map(extra => new UrlExtra(extra));
    }

    get(fieldName) 
    {
        const name = UrlExtra.getAliasedName(fieldName);

        return this.items.find(extra => extra.name === name);
    }
}