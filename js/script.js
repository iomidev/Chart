//All DIV Container from Template
var divClass = document.getElementsByClassName('chdiv');
var div = [];
var j = 1;

//Seperate DIV Container 
for (let i = 0; i< divClass.length; i++) {
    
    //Variables let
    let title, type, chId, chDataFormat, chCurrencySymbol, keyDiv, valueDiv, colorDiv, percDiv, chartDataSet, chartLabels, canVas, chDataTable, thisChart, optionsPie, optionsBar, symbol;

    //DIV[i] from Template
    div[i] = document.getElementById('chart_div_'+j).children;
    
    //HIDDEN Input
    title = div[i].chart_title.value;
    type = div[i].chart_type.value;
    chId = div[i].chart_id.value;
    chDataFormat = div[i].chart_data_format.value;
    chCurrencySymbol = div[i].chart_currency_symbol.value;

    //DIV Input
    keyDiv = div[i].div_key.children;
    valueDiv = div[i].div_value.children;
    colorDiv = div[i].div_color.children;
    percDiv = div[i].div_percent.children;

    //DataSet 
    chartDataSet = {label:[],data:[],backgroundColor: [],borderColor: [],borderWidth: 1};
    chartLabels = {labels:[]};

    //If DataFormat === percent
    if (chDataFormat === "2") {
        for (let k = 0;k<keyDiv.length; k++) {
            chartDataSet.data[k] = percDiv[k].value;
        }
        symbol = function(value) {
                    return value + ' %';
                };
    } else {
        for (let k = 0;k<keyDiv.length; k++) {
            chartDataSet.data[k] = valueDiv[k].value;
        }
        symbol = function(value) {
                    return chCurrencySymbol+ ' ' + value;
                };
    }

    //Insert chartLabels
    for (let k = 0;k<keyDiv.length; k++) {
        chartLabels.labels[k] = keyDiv[k].value;
    }

    //Insert color
    for (let k = 0; k < colorDiv.length; k++) {
        chartDataSet.backgroundColor[k] = "#" + colorDiv[k].value;
        chartDataSet.borderColor[k] = "#" + colorDiv[k].value;
    }

    //Options Pie
    optionsPie = {
        plugins: {
            datalabels: {
                align: 'end',
                anchor: 'center',
                backgroundColor: '#ffffff',
                borderColor: '#000000',
                borderRadius: 1,
                borderWidth: 0.5,
                color: '#000000',
                font: {
                  size: 13,
                  weight: 600
                },
                padding: 2,
                display: 'auto',
                formatter: symbol
            }
        },
        responsive: true,
        maintainAspectRatio: true,
        legend: {
            display: true,
            labels:{
                boxWidth: 5,
                usePointStyle: true,
                boxHeight: 1
            }
        },
        title: {
            display: true,
            text: title
        }
    };

    //Options Bar
    optionsBar = {
            plugins: {
              datalabels: {
                align: 'start',
                anchor: 'end',
                backgroundColor: '#ffffff',
                borderColor: '#000000',
                borderRadius: 1,
                borderWidth: 0.5,
                color: '#000000',
                font: {
                  size: 13,
                  weight: 600
                },
                offset: 1,
                padding: 2,
                clamp: true,
                clip: true,
                display: 'auto',
                formatter: symbol
              }
            },
            scales: {
                xAxes: [{
                stacked: true
                }],
                yAxes: [{
                stacked: true
                }]
            },
            responsive: true,
            maintainAspectRatio: true,
            legend: {
                display: false
            },
            title: {
                display: true,
                text: title
            },
            tooltip: false
          };

    //Canvas Element 
    canVas = document.getElementById(chId).getContext('2d');

    //Check Datatype === pi || (bar/horizontalBar)
    if (type === 'pie') {
    chDataTable = 
        {
            type: type,
            data: {
                labels: chartLabels.labels,
                datasets: [{
                    label: chartDataSet.label,
                    data: chartDataSet.data,
                    backgroundColor: chartDataSet.backgroundColor,
                    borderColor: '#000000',
                    borderWidth: 1
                }]
            },
            options: optionsPie
        };

        //Pie Chart
        thisChart = new Chart(canVas, chDataTable);

    } else {
        chDataTable = 
        {
            type: type,
            data: {
                labels: chartLabels.labels,
                datasets: [{
                    label: chartDataSet.label,
                    data: chartDataSet.data,
                    backgroundColor: chartDataSet.backgroundColor,
                    borderColor: '#000000',
                    borderWidth: 1
                }]
            },
            options: optionsBar
        };

        //Bar && HorizontalBar Chart
        thisChart = new Chart(canVas, chDataTable);
    }
    j++;
}

