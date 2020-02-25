import CustomPieChart from './CustomPieChart';

import './MultiBarChart.css';

import React, {Component} from 'react';

class MultiBarChart extends Component {
    totalNumberOfItems = 5;

    static COLORS = [
        '#4385ff', '#3878ec', '#0393f4', '#20afef', '#ffcd26', '#bfd2dd'
    ];

    render() {
        return (
            <div className="hp--multibar-container">
                <div className="hp--multibar">
                    {this.getItems().map((item, index) => (
                        <div className="hp--multibar-item" >
                            <div className="hp--multibar-bar-name">{item[this.props.field.name]}</div>
                            <div className="hp--multibar-item-bar" style={{
                                width: `${item.percentage}%`,
                                background: this.getColorForIndex(index)
                            }}></div>
                        </div>
                    ))}
                </div>
                <div className="hp-bar-list-container">
                    <div className="hp-bar-list">
                        {this.props.data.map((item, index) => (
                            <div className="hp-bar-list-item">
                                <div className="hp-bar-item--icon" style={{background: this.getColorForIndex(index)}}></div>
                                <div className="hp-bar-item--country">{item[this.props.field.name]}</div>
                                <div className="hp-bar-item--clicks">{item.total}</div>
                                <div className="hp-bar-item--percentage">{item.percentage}%</div>
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
        return MultiBarChart.COLORS[index] || '#bfd2dd';
    }
}

export default MultiBarChart;