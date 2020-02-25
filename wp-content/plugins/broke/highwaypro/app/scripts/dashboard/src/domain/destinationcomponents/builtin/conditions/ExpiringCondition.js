import { DatePicker, MuiPickersUtilsProvider } from 'material-ui-pickers';
import DateRangeRounded from '@material-ui/icons/DateRangeRounded';
import { format } from 'date-fns';
import subDays from 'date-fns/subDays';
import addDays from 'date-fns/addDays';
import ChevronLeftRounded from '@material-ui/icons/ChevronLeftRounded';
import ChevronRightRounded from '@material-ui/icons/ChevronRightRounded';
import DateFnsUtils from 'material-ui-pickers/utils/date-fns-utils';
import React from 'react';

import { BuiltInComponent } from '../BuiltInComponent';

export class ExpiringCondition extends BuiltInComponent {
    static type = 'condition';
    static getIdStatic() { return 'highwaypro.ExpiringCondition';}
    getId() { return ExpiringCondition.getIdStatic() } 
    icon = (<DateRangeRounded />);

    initialState = {
        expirationDate: this.data.parameters.expirationDate || new Date,
        dateObject:     this.data.parameters.expirationDate || new Date
    }

    handleChange = (date) => {
        this.reactComponent.setState({
            expirationDate: format(date, 'YYYY-MM-dd'),
            dateObject: date
        });
    }

    getContent() 
    {
        return (<div className="picker">
            <MuiPickersUtilsProvider utils={DateFnsUtils}>
              <DatePicker
                  value={subDays(addDays(this.reactComponent.state.expirationDate, 1), 1)}
                  onChange={this.handleChange.bind(this)}
                  autoOk={true}
                  disablePast={true}
                  leftArrowIcon={<ChevronLeftRounded />}
                  rightArrowIcon={<ChevronRightRounded />}
                />
            </MuiPickersUtilsProvider>
        </div>
        )
    }

    getValuesAsPreview()
    {
        return this.data.parameters.expirationDate;
    }
}