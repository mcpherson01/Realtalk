import './BarChart.css';

import React, {Component} from 'react';

import CustomPieChart from './CustomPieChart';
import UrlStatistics from './UrlStatistics';

import NumberFormat from 'react-number-format';

class BarChart extends Component {
    totalNumberOfItems = 5;

    static COLORS = [
        '#4385ff', '#3878ec', '#0393f4', '#20afef', '#ffcd26', '#bfd2dd'
    ];

    render() {
        return (
            <div className="hp-bar-container">
                <div className="hp-bar">
                    {this.getItems().map(item => (
                        <div className="hp-bar-item" style={{width: `${item.percentage}%`}}></div>
                    ))}
                </div>
                <div className="hp-bar-overview">
                    {this.getItems().map((item, index, items: Array) => (
                        <div className="hp-bar-overview-item">
                            <div className="hp-bar-item--country">
                                {(items.length === 6 && items.length === index + 1)? 'Other' : UrlStatistics.getShortFormattedName(item[this.props.field.name])}
                            </div>
                            <div className="hp-bar-item--percentage" style={{color:this.getColorForIndex(index)}}><NumberFormat value={item.percentage} decimalScale={2} displayType="text" suffix="%"/></div>
                        </div>
                    ))}
                </div>
                <div className="hp-bar-list-container">
                    <div className="hp-bar-list">
                        {this.props.data.map((item, index) => (
                            <div className="hp-bar-list-item">
                                <div className="hp-bar-item--icon" style={{background: this.getColorForIndex(index)}}></div>
                                <div className="hp-bar-item--country">{UrlStatistics.getFormattedName(item[this.props.field.name])}</div>
                                <div className="hp-bar-item--clicks">{item.total}</div>
                                <div className="hp-bar-item--percentage"><NumberFormat value={item.percentage} decimalScale={2} displayType="text" suffix="%"/></div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        );
    }

    getItems() 
    {
        const firstSixItems = this.props.data.slice(0, this.totalNumberOfItems + 1);

        if (typeof this.calculatedItems !== 'array') {
            this.calculatedItems = firstSixItems.map((item, index) => {
                const isTheLastItem = index === this.totalNumberOfItems;

                if (isTheLastItem) {
                    // asign a combined percentage of the rest of the items...
                    const theRestOfTheItemsExcludingTheFirstFive = this.props.data.slice(this.totalNumberOfItems - 2);
                    item = Object.assign({}, item);

                    item[this.props.field.value] = theRestOfTheItemsExcludingTheFirstFive
                                 .reduce((accumulator, currentItem) => accumulator + currentItem[this.props.field.value], 0);
                }

                return item;
            });
        }


        return this.calculatedItems;
    }

    getColorForIndex(index) 
    {
        return BarChart.COLORS[index] || '#bfd2dd';
    }
}

export default BarChart;