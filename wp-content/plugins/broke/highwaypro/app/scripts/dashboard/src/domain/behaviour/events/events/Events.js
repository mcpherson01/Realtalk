export class Events
{
    static register(event) 
    {
        // event: {name: '', handler: ''}
        Events.events.push(event)
    }

    /**
     *  Unregisters ALL handlers associated with an
     *  event name, use with caution. 
     */
    static unregisterAllWithName(eventName)
    {
        Events.events = Events.events.filter(event => event.name !== eventName);
    }

    static call(eventName, data) 
    {
        Events.events.filter(event => event.name === eventName).forEach(event => {
            event.handler(data, eventName)
        });
    }
}

Events.events = [];