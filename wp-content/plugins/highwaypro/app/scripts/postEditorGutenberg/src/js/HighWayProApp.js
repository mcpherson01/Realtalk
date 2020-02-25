export class HighWayProApp
{
    static getComponent()
    {
        return HighWayProApp.gutenbergIsEnabled()? window.wp.element.Component : window.React.Component;
    }

    static gutenbergIsEnabled() 
    {
        return window.wp && 
               window.wp.editor && 
              (typeof window.wp.editor.BlockControls !== 'undefined');
    }

    static getCreateElement()
    {
        return HighWayProApp.gutenbergIsEnabled()? window.wp.element.createElement : window.React.createElement;
    }
}