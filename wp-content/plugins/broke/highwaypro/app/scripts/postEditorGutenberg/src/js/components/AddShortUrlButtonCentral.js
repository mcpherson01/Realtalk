import { UrlPicker } from './UrlPicker';

const $ = jQuery;

export class AddShortUrlButtonCentral
{
    static TAG_NAME   = 'hwprourl';
    static TITLE      = 'HighWayPro Short Url';
    static CLASSES    = 'highwaypro-url';
    static ATTRIBUTES = {
        id: 'data-id'
    }

    static getCurrentCoordinates() 
    {
        const selection = window.getSelection();
        let coordinates;

        if (selection.type.toLowerCase() === 'none') {
            coordinates = {
                top: '50%',
                left: '50%'
            };
        } else {
            const range = selection.getRangeAt(0).getBoundingClientRect();
            let left = (range.left + window.scrollX) - (282 / 2) + (range.width / 2);

            left = AddShortUrlButtonCentral.calculateViewableLeftCoordinates(left);

            coordinates = {
                top: range.top + window.scrollY + (range.height + 10),
                left: left
            }
        }

        return coordinates;
    }

    static calculateViewableLeftCoordinates(left)
    {
        const windowWidth = $(window).width();
        const elementGetsOutOfTheviewPortRight = () => ((left + UrlPicker.WIDTH) > windowWidth);
        const elementGetsOutOfTheviewPortLeft = () => (left < 0);

        if (elementGetsOutOfTheviewPortLeft()) {
            left = 10;
        } else if (elementGetsOutOfTheviewPortRight()) {
            while (elementGetsOutOfTheviewPortRight()) {
                left -= 10;
            }
        }

        return left;
    }
}