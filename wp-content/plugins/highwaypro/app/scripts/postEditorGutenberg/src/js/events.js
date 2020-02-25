export class Events
{
    static register(event) 
    {
        Events.events.push(event)
    }

    static call(eventName, data) 
    {
        Events.events.filter(event => event.name === eventName).forEach(event => {
            event.handler(data, eventName)
        });
    }
}

Events.events = [];