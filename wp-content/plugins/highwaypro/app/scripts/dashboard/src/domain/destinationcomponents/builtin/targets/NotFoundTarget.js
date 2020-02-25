import NotListedLocationRounded from '@material-ui/icons/NotListedLocationRounded';
import React from 'react';

import { BuiltInComponent } from '../BuiltInComponent';

export class NotFoundTarget extends BuiltInComponent {
    static type = 'target';
    static getIdStatic() { return 'highwaypro.NotFoundTarget';}
    getId() { return NotFoundTarget.getIdStatic() } 
    icon = (<NotListedLocationRounded />);

    initialState = {
        termId: this.data.parameters.termId || 0,
    }

    getContent() 
    {
        return;//
    }

    getValuesAsPreview()
    {
        return;
    }
}