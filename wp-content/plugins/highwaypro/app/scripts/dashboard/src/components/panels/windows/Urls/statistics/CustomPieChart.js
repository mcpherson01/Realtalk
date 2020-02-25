import './CustomPieChart.css';

import { Cell, Pie, PieChart } from 'recharts';
import React, {Component} from 'react';

import UrlStatistics from './UrlStatistics';
import NumberFormat from 'react-number-format';

class CustomPieChart extends Component {
    static COLORS = [
        '#fd9f29', '#00b0f4', '#1368bb', '#31c5b9', '#ffcd26', '#b6d0e0'
    ];

    render() {
        //const COLORS = ['#0088FE', '#02a0fe', '#02b8ff', '#2af0fa', '#2afac1', '#2afa87', '#59db75', '#6ddb59', '#9ddb59', '#e8c543', '#ffb04e', '#ff6454'];

        const RADIAN = Math.PI / 180;      

        return (
            <React.Fragment>
                <div className="hp-pie-chart">
                    <div className="hp-pie-chart-chart">
                        <PieChart width={this.props.width} height={this.props.height} onMouseEnter={this.onPieEnter}>
                            <Pie
                              data={this.props.data} 
                              dataKey="percentage" 
                              nameKey={this.props.field.name}
                              innerRadius={this.props.innerRadius || 50}
                              outerRadius={80} 
                              fill="#8884d8"
                              paddingAngle={0.8}
                            >
                                {
                                  this.props.data.map((entry, index) => <Cell fill={this.getColorForIndex(index)}/>)
                              }
                            </Pie>
                
                        </PieChart>
                    </div>
                    <div className="hp-bar-list-container">
                        <div className="hp-bar-list">
                            {this.props.data.map((item, index) => (
                                <div className="hp-bar-list-item">
                                    <div className="hp-bar-item--icon" style={{background: this.getColorForIndex(index)}}></div>
                                    <div className="hp-bar-item--country">{UrlStatistics.getFormattedName(item[this.props.field.name])}</div>
                                    <div className="hp-bar-item--clicks">{item.total}</div>
                                    <div className="hp-bar-item--percentage">
                                        <NumberFormat value={item.percentage} decimalScale={2} displayType="text" suffix="%"/>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </React.Fragment>
        );
    }

    getColorForIndex(index) 
    {
        const colors = this.props.colors || CustomPieChart.COLORS;
        
        return colors[index] || '#b6d0e0';
    }
}

export default CustomPieChart;