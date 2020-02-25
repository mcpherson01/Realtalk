import './UrlStatsDailyChart.css';

import {
  Area,
  AreaChart,
  CartesianGrid,
  Tooltip,
  XAxis,
  YAxis
} from 'recharts';
import React, {Component} from 'react';
import _ from 'lodash';

import { month } from '../../../../../domain/utilities/dates/month';
import CustomChartToolTip from './CustomChartToolTip';

class UrlStatsDailyChart extends Component {
    data = [
                    {
                        "total": 1,
                        "day": '24',
                        "offset": 30,
                        "month": '9',
                        "year": '2012',
                        "date": "2012-09-24 10:11:36"
                    },
                    {
                        "total": 3,
                        "day": '23',
                        "offset": 29,
                        "month": '9',
                        "year": '2012',
                        "date": "2012-09-23 10:11:36"
                    },
                    {
                        "total": 12,
                        "day": '22',
                        "offset": 28,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-22"
                    },
                    {
                        "total": 18,
                        "day": '21',
                        "offset": 27,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-21"
                    },
                    {
                        "total": 8,
                        "day": '20',
                        "offset": 26,
                        "month": '9',
                        "year": '2012',
                        "date": "2012-09-20 10:11:36"
                    },
                    {
                        "total": 22,
                        "day": '19',
                        "offset": 25,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-19"
                    },
                    {
                        "total": 12,
                        "day": '18',
                        "offset": 24,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-18"
                    },
                    {
                        "total": 3,
                        "day": '17',
                        "offset": 23,
                        "month": '9',
                        "year": '2012',
                        "date": "2012-09-17 10:11:36"
                    },
                    {
                        "total": 20,
                        "day": '16',
                        "offset": 22,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-16"
                    },
                    {
                        "total": 13,
                        "day": '15',
                        "offset": 21,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-15"
                    },             
                    {
                        "total": 34,
                        "day": '14',
                        "offset": 20,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-14"
                    },  
                    {
                        "total": 4,
                        "day": '13',
                        "offset": 19,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-13"
                    },         
                    {
                        "total": 9,
                        "day": '12',
                        "offset": 18,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-12"
                    },         
                    {
                        "total": 12,
                        "day": '11',
                        "offset": 17,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-11"
                    },         
                    {
                        "total": 10,
                        "day": '10',
                        "offset": 16,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-10"
                    },         
                    {
                        "total": 12,
                        "day": '09',
                        "offset": 15,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-09"
                    },         
                    {
                        "total": 16,
                        "day": '08',
                        "offset": 14,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-08"
                    },         
                    {
                        "total": 14,
                        "day": '07',
                        "offset": 13,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-07"
                    },         
                    {
                        "total": 18,
                        "day": '06',
                        "offset": 12,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-06"
                    },         
                    {
                        "total": 17,
                        "day": '05',
                        "offset": 11,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-05"
                    },         
                    {
                        "total": 12,
                        "day": '04',
                        "offset": 10,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-04"
                    }, 
                    {
                        "total": 12,
                        "day": '03',
                        "offset": 9,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-03"
                    }, 
                    {
                        "total": 13,
                        "day": '02',
                        "offset": 8,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-02"
                    }, 
                    {
                        "total": 12,
                        "day": '01',
                        "offset": 7,
                        "month": '09',
                        "year": '2012',
                        "date": "2012-09-01"
                    }, 
                    {
                        "total": 15,
                        "day": '31',
                        "offset": 6,
                        "month": '08',
                        "year": '2012',
                        "date": "2012-08-31"
                    }, 
                    {
                        "total": 12,
                        "day": '30',
                        "offset": 5,
                        "month": '08',
                        "year": '2012',
                        "date": "2012-08-30"
                    }, 
                    {
                        "total": 1,
                        "day": '29',
                        "offset": 4,
                        "month": '8',
                        "year": '2012',
                        "date": "2012-08-29 10:11:36"
                    }, 
                    {
                        "total": 12,
                        "day": '28',
                        "offset": 3,
                        "month": '08',
                        "year": '2012',
                        "date": "2012-08-28"
                    }, 
                    {
                        "total": 12,
                        "day": '27',
                        "offset": 2,
                        "month": '08',
                        "year": '2012',
                        "date": "2012-08-27"
                    },         
                    {
                        "total": 12,
                        "day": '26',
                        "offset": 1,
                        "month": '08',
                        "year": '2012',
                        "date": "2012-08-26"
                    }, 
                    {
                        "total": 12,
                        "day": '25',
                        "offset": 0,
                        "month": '08',
                        "year": '2012',
                        "date": "2012-08-25"
                    },         
        ].reverse();

    state = {
        width: 600 // initial width...
    };

    elements = {
        main: React.createRef()
    }

    getDay(offset) 
    {
        return this.props.data.filter(day => {
            return day.offset === offset;
        })[0];
    }

    componentDidMount() 
    {
        this.setWidth();
        window.addEventListener('resize', this.setWidth.bind(this));
    }

    componentDidUpdate() 
    {
        this.setWidth();
    }

    render() {
        return (
            <div className="hp-url-stats-daily-chart" ref={this.elements.main}>
                <AreaChart width={this.state.width} height={300} data={this.props.data}
                    margin={{top: 10, right: 0, left: 0, bottom: 0}}>
                    <CartesianGrid strokeDasharray="3 3"/>
                    <XAxis 
                        type="number"
                        domain={[31, 1]}
                        dataKey="offset" 
                        tickCount={6}
                        tickFormatter={offset => (
                            _.truncate(month(this.getDay(offset).month), {length: 3, omission: ''}) + ` ${this.getDay(offset).day}`
                        )}
                    />
                    <YAxis allowDecimals={false}/>
                    <Tooltip
                        content={({payload: data}) => {
                            let day = (data[0] && data[0].payload) || {};

                            return <CustomChartToolTip day={day || {}} />;
                        }}
                    />
                    <Area type='monotone' dot={true} dataKey='total' stroke={'#5a96fd'} fill='none' />
              </AreaChart>
            </div>
        );
    }

    setWidth() 
    {
        if (!this.elements.main.current) return;

        const newWidth = this.elements.main.current.offsetWidth - 30;

        if (newWidth != this.state.width) {
            this.setState({
                width: newWidth
            })
        }
    }
}

export default UrlStatsDailyChart;