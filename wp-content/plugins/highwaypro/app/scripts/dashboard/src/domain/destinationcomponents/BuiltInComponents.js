import { DeviceCondition } from './builtin/conditions/DeviceCondition';
import { DirectTarget } from './builtin/targets/DirectTarget';
import { DisposableCondition } from './builtin/conditions/DisposableCondition';
import { ExpiringCondition } from './builtin/conditions/ExpiringCondition';
import { LocationCondition } from './builtin/conditions/LocationCondition';
import { NotFoundTarget } from './builtin/targets/NotFoundTarget';
import { PostTarget } from './builtin/targets/PostTarget';
import { RefererCondition } from './builtin/conditions/RefererCondition';
import { TaxonomyTarget } from './builtin/targets/TaxonomyTarget';
import { UserAgentCondition } from './builtin/conditions/UserAgentCondition';
import { UserRoleCondition } from './builtin/conditions/UserRoleCondition';

export function BuiltInComponents() {
    let components = [
        DeviceCondition,
        LocationCondition,
        DisposableCondition,
        ExpiringCondition,
        RefererCondition,
        UserAgentCondition,
        UserRoleCondition,
        DirectTarget,
        PostTarget,
        TaxonomyTarget,
        NotFoundTarget
    ];

    window.addEventListener('HighwayProRegisterComponent', event => {
        components.forEach(component => {
            event.detail.registrator.register(component);        
        });
    });
}