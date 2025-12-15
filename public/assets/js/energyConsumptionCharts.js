import { setIntervalAtFiveMinuteMarks, charts, fetchData, colorScheme, formatDate, renderChart, getStartEndDate } from './dashboardUtils.js?v=10';

colorScheme();

const processChartData = (data, refetch, chartID, dataOptions, columnName) => {
    let uniqueDates = [...new Set(data.map(item => item.reading_date))].sort((a, b) => a.localeCompare(b));

    data.forEach((reading) => {
        // totalEnergyConsumption += reading.daily_consumption;

        let existingSensor = charts[chartID].options.data.find(sensor => sensor.name === reading.description);

        if (!existingSensor) {
            let newDataOptions = {
                ...dataOptions,
                name: reading.description,
                dataPoints: uniqueDates.map(date => {
                    let dataItem = data.find(d => d.reading_date === date && d.description === reading.description);
                    return {
                        name: dataItem?.description,
                        label: formatDate(date),
                        y: dataItem ? dataItem.daily_consumption : null
                    };
                })
            };

            charts[chartID].options.data.push(newDataOptions);
        }
    });

    if (refetch) {
        charts[chartID].render();
    } else {
        renderChart(chartID, charts[chartID].options);
    }
};


const processDailyEnergyConsumptionAllMeters = () => {
    const SELECT = `*, ROUND((end_energy - start_energy), 2) AS daily_consumption`;
    const PROCESS_URL = '/getEnergyConsumption';
    const CHART_ID = 'dailyEnergyConsumptionAllMeters';
    const LABEL_FIELD = 'reading_date';

    const requestPayload = {
        select: SELECT,
    };

    const createChartOptions = () => ({
        animationEnabled: true,
        theme: "light2",
        exportEnabled: true,
        chartName: "Daily Energy Consumption - All Meters",
        chartProps: { request: requestPayload, processUrl: PROCESS_URL },
        colorSet: 'DailyEnergyColorSet',
        title: {
            text: "Daily Energy Consumption - SIIX EMS: All Meters",
            fontSize: 20,
            margin: 30
        },
        axisY: {
            title: "Energy (kWh)",
            titlePadding: {
                top: 1,
                bottom: 15,
            },
            titleFontSize: 15,
            // includeZero: true
            labelFontSize: 12
        },
        axisX: {
            labelAngle: -90,
            margin: 30,
            labelFontSize: 12,
            interval: 1,
            // intervalType: "month",
        },
        toolTip: {
            // content: "{name}: {y} kWh"
            shared: true,
            content: (e) => toolTipContent(e),
        },
        legend: {
            cursor: "pointer",
            horizontalAlign: "center",
            itemclick: (e) => toggleDataSeries(e, CHART_ID),
            fontSize: 15,
        },
        data: [],
    });

    const createSeriesTemplate = () => ({
        type: "stackedColumn",
        name: "",
        showInLegend: true,
        dataPoints: []
    });

    const toolTipContent = (e) => {
        const totalConsumption = e.entries.reduce((total, item) => total + item.dataPoint.y, 0);
        const label = "<span style = \"color:DodgerBlue;\">Date:<strong> " + e.entries[0].dataPoint.label + "</strong></span><br/><br/>";
        const total = "<br/><span style = \"color:Tomato\">Total:</span><strong> " + totalConsumption.toLocaleString() + "</strong><br/>";
        let sensors = "";

        e.entries.forEach(entry => {
            sensors += `<span style="color: ${entry.dataSeries.color}"> ${entry.dataSeries.name}: </span> <strong>${entry.dataPoint.y}</strong><br/>`
        });

        return (label.concat(sensors)).concat(total);
    }

    const toggleDataSeries = (e, CHART_ID) => {
        if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        } else {
            e.dataSeries.visible = true;
        }
        charts[CHART_ID].render();
    }

    // periodic refetch
    setIntervalAtFiveMinuteMarks(() => {
        fetchData(requestPayload, createSeriesTemplate(), CHART_ID, PROCESS_URL, LABEL_FIELD, processChartData, true);
        if (charts[CHART_ID]) charts[CHART_ID].render();
    });

    // initialize and do first fetch
    charts[CHART_ID] = { options: createChartOptions() };
    fetchData(requestPayload, createSeriesTemplate(), CHART_ID, PROCESS_URL, LABEL_FIELD, processChartData);
};

// Process for the Previous and Present energy consumption calculation
processDailyEnergyConsumptionAllMeters();