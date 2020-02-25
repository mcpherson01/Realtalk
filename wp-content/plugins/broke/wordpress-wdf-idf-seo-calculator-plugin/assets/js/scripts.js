/* set to true, to debug */
var wtbIDFcalculatorDebug = false;

var lastAjaxRequest;
var lastAjaxRequestKeyword;
var lastAjaxRequestContent;
var lastAjaxRequestTotal;

var chart1DT;
var chart1DV;
var chart1;
var chart2DT;
var chart2DV;
var chart2;

var colors = [
    '#2f7ed8',
    '#0d233a',
    '#8bbc21',
    '#910000',
    '#492970',
    '#f28f43',
    '#77a1e5',
    '#c42525',
    '#1aadce',
    '#a6f96a',
    '#2626f6',
];
var activeColors;

var chartOptions = {
    fontName: '"Arial"',
    legend: {
        position: 'none'
    },
    chartArea: {
        top: 10,
        left: '5%',
        width: '95%',
        height: '80%'
    },
    vAxis: {
        minValue: 0
    },
    hAxis: {
        textStyle: {
            fontSize: 12
        },
        slantedTextAngle: '90',
        fontName: 'Arial'
    },
    colors: colors
};

var currentContent;

google.load("visualization", "1", {packages:["corechart"]});

jQuery(document).ready(function () {

    setTimeout(function () {
        currentContent = getContent();
    }, 500);

	jQuery('#idf-calculator-check').click(function() {
        drawChart();
        return false;
    });

    jQuery('#addStopWord').on('keypress', function(e) {
		if (e.keyCode === 13) {
            addStopWord();
			return false;
		}
	});

	jQuery('#idf-calculator-addStopKeyword-button').click(function() {
        addStopWord();
        return false;
    });

    jQuery('#wtb_idf_calculator_top_results').change(function(){
        drawChart();
    });

    jQuery('body').on('click', '#chart_legend label', function () {
        jQuery(this).toggleClass('chart-active');
        if (jQuery('#chart_legend label.chart-active').length > 0) {
            var a = [0];
            jQuery.each(jQuery('#chart_legend label.chart-active'), function () {
                a.push(jQuery(this).data('id'));
            });
            set(a, chart1DV, chart1);
        }
    });

    jQuery('body').on('click', '#chart_legend1 label', function () {
        jQuery(this).toggleClass('chart-active');
        if (jQuery('#chart_legend1 label.chart-active').length > 0) {
            var a = [0];
            jQuery.each(jQuery('#chart_legend1 label.chart-active'), function () {
                a.push(jQuery(this).data('id'));
            });
            set(a, chart2DV, chart2);
        }
    });

    // drawChart();
});

function addStopWord() {
    if (jQuery('#addStopWord').val() !== '') {
        jQuery.post(ajaxurl,
            {
                action: 'wtb_idf_calculator_stopword_api',
                stopword: jQuery('#addStopWord').val()
            },
            function(data) {
                jQuery('#addStopWord').val('')
            }
        );
    }
}

function drawChart() {
    if (jQuery('#idf-calculator-word').length === 0 || jQuery('#idf-calculator-word').val().length === 0) {
        return;
    }

    var content = '';
    if (jQuery("#wp-content-wrap").hasClass('html-active')) {
        content = jQuery("#content").val();
    } else {
        content = jQuery("#content_ifr").contents().find('#tinymce').html()
        if (content === undefined || content.length === 0) {
            content = jQuery("#content").val();
        }
    }

    if (lastAjaxRequestKeyword === jQuery('#idf-calculator-word').val()
            && lastAjaxRequestTotal === jQuery('#wtb_idf_calculator_top_results').val()
            && lastAjaxRequestContent === content) {
        return false;
    }

    lastAjaxRequestTotal = jQuery('#wtb_idf_calculator_top_results').val();
    lastAjaxRequestContent = content;

    jQuery('#chart_div').html('<span class="wtb-idf-ajax-loader">'+jQuery('#wtb-idf-loader-text').text()+'</span>').css('height', 'auto');
    jQuery('#chart_div1').html('').css('height', 'auto');

    jQuery('#chart_legend').html('');
    jQuery('#chart_legend1').html('');

    if (lastAjaxRequest !== undefined) {
        lastAjaxRequest.abort();
    }

    if (lastAjaxRequestContent === undefined || lastAjaxRequestContent.length <= 0) {
        lastAjaxRequestContent = currentContent;
    }

    lastAjaxRequestKeyword = jQuery('#idf-calculator-word').val();
    lastAjaxRequest = jQuery.post(ajaxurl,
        {
            action: 'wtb_idf_calculator_api',
            keyword: lastAjaxRequestKeyword,
            content: lastAjaxRequestContent,
            total: lastAjaxRequestTotal
        },
        function(data) {
            if (data !== null) {
                // parse to float. Because google charts wonna no string, and php < 5.3.3 gives us string
                jQuery.each(data.chart1.data, function(id, item) {
                    if (id > 0) {
                        jQuery.each(item, function(id2, item2) {
                            if (id2 > 0) {
                                data.chart1.data[id][id2] = parseFloat(item2);
                            }
                        });
                    }
                });

                jQuery.each(data.chart2.data, function(id, item) {
                    if (id > 0) {
                        jQuery.each(item, function(id2, item2) {
                            if (id2 > 0) {
                                data.chart2.data[id][id2] = parseFloat(item2);
                            }
                        });
                    }
                });

                jQuery('#chart_div').html('').css('height', '500px');
                jQuery('#chart_div1').html('').css('height', '500px');

                if (wtbIDFcalculatorDebug) {
                    console.group('Chart1 Data');
                    console.log(data.chart1.data);
                    console.groupEnd();
                }

                chart1DT = google.visualization.arrayToDataTable(data.chart1.data);
                chart1DV = new google.visualization.DataView(chart1DT);

                if (wtbIDFcalculatorDebug) {
                    console.group('Chart2 Data');
                    console.log(data.chart2.data);
                    console.groupEnd();
                }

                chart2DT = google.visualization.arrayToDataTable(data.chart2.data);
                chart2DV = new google.visualization.DataView(chart2DT);

                drawCharts(data);
            } else {
                jQuery('#chart_div').html('').css('height', 'auto');
                jQuery('#chart_div1').html('').css('height', 'auto');

                jQuery('#chart_legend').html('');
                jQuery('#chart_legend1').html('');
            }
        },
        'json'
    ).fail(function(x) {
        jQuery('#chart_div').html(x.responseText).css('height', 'auto');
        jQuery('#chart_div1').html('').css('height', 'auto');

        jQuery('#chart_legend').html('');
        jQuery('#chart_legend1').html('');

        // reset keyword
        lastAjaxRequestKeyword = '';
    });
}

function drawCharts(data)
{
    if (chart1DV !== undefined) {
        chart1 = new google.visualization.LineChart(document.getElementById('chart_div'));
        chartOptions.colors = colors;
        chart1.draw(chart1DV, chartOptions);

        jQuery('#chart_legend').html(drawLegend(chart1DV));
    }

    if (chart2DV !== undefined) {
        chart2 = new google.visualization.LineChart(document.getElementById('chart_div1'));
        chartOptions.colors = colors;
        chart2.draw(chart2DV, chartOptions);

        jQuery('#chart_legend1').html(drawLegend(chart2DV));
    }
}

function set(cols, dv, chart)
{
    activeColors = [];
    jQuery.each(cols, function (id, item) {
        if (item > 0) {
            activeColors.push(colors[item-1]);
        }
    });
    chartOptions.colors = activeColors;

    dv.setColumns(cols);
    chart.draw(dv, chartOptions);
}

function drawLegend(legend) {

    var string = '';

    for (var i = 0; i < legend.getNumberOfColumns(); i++) {
        var id = legend.getColumnId(i);
        if (id > 0) {
            string += '<label class="chart-active" data-id="'+id+'"><span style="background-color: '+colors[id-1]+'"></span>'+this.label+'</label>';
        }
    }

    return string;
}

window.onresize = drawCharts;

function getContent() {
    return wp.data.select('core/editor').getCurrentPost().content;
}
