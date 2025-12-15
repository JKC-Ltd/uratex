import { fetchData, setIntervalAtFiveMinuteMarks, charts, formatDate, renderChart, getStartEndDate, colorScheme, exportFn, createOdometer } from "./shared/main.js?v=1.5";

colorScheme();

const processData = (data, refetch, chartID, dataOptions, columnName) => {

    // let totalEnergyConsumption = 0;
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

    // $('#monthlyEnergyConsumption').html(totalEnergyConsumption.toLocaleString());

    if (refetch) {
        charts[chartID].render();
    } else {
        renderChart(chartID, charts[chartID].options);
    }

};

const processDailyEnergyConsumptionAllMeters = () => {

    let select = "*, ROUND((end_energy - start_energy), 2) AS daily_consumption";
    // const [startDate, endDate] = getStartEndDate(9, 24, 'month', 1);
    const processUrl = "/getEnergyConsumption";
    const chartName = "dailyEnergyConsumptionAllMeters";
    const column = "reading_date";
    const dailyEnergyConsumptionAllMetersRequest = {
        select: select,
        where: [
            {
                field: "sensor_id",
                operator: "!=",
                value: 15,
            },
            {
                field: "sensor_id",
                operator: "!=",
                value: 19,
            }
        ]
        // startDate: startDate,
        // endDate: endDate

    };

    $(`#${chartName}Btn`).on('click', () => {
        exportFn(dailyEnergyConsumptionAllMetersRequest, processUrl);
    })

    const dailyEnergyConsumptionAllMeters = () => {

        return {
            animationEnabled: true,
            theme: "light2",
            chartName: "Daily Energy Consumption - All Meters",
            chartProps: {
                request: dailyEnergyConsumptionAllMetersRequest,
                processUrl,
            },
            colorSet: "DailyEnergyColorSet",
            exportEnabled: true,
            zoomEnabled: true,
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
                itemclick: (e) => toggleDataSeries(e, chartName),
                fontSize: 15,
            },
            data: [],
        }
    }

    const dailyEnergyConsumptionAllMetersDataOptions = () => {

        return {
            type: "stackedColumn",
            name: "",
            showInLegend: true,
            dataPoints: []
        }
    }

    const toolTipContent = (e) => {

        // console.log(e.entries[0].dataPoint.label);

        const totalConsumption = e.entries.reduce((total, item) => total + item.dataPoint.y, 0);
        const label = "<span style = \"color:DodgerBlue;\">Date:<strong> " + e.entries[0].dataPoint.label + "</strong></span><br/><br/>";
        const total = "<br/><span style = \"color:Tomato\">Total:</span><strong> " + totalConsumption.toLocaleString() + "</strong><br/>";
        let sensors = "";

        e.entries.forEach(entry => {
            sensors += `<span style="color: ${entry.dataSeries.color}"> ${entry.dataSeries.name}: </span> <strong>${entry.dataPoint.y}</strong><br/>`
        });

        return (label.concat(sensors)).concat(total);
    }

    const toggleDataSeries = (e, chartID) => {
        if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        } else {
            e.dataSeries.visible = true;
        }
        charts[chartID].render();
    }


    setIntervalAtFiveMinuteMarks(function () {
        console.log("refetching...");
        fetchData(dailyEnergyConsumptionAllMetersRequest, dailyEnergyConsumptionAllMetersDataOptions(), chartName, processUrl, column, processData, true);
        charts[chartName].render();
    });

    charts[chartName] = { options: dailyEnergyConsumptionAllMeters() };
    fetchData(dailyEnergyConsumptionAllMetersRequest, dailyEnergyConsumptionAllMetersDataOptions(), chartName, processUrl, column, processData);


}

// Process for the Monthly energy consumption calculation
processDailyEnergyConsumptionAllMeters();

// -----------------------------------------------------------------------------------------------


// Separate process for no charts

// Process for the Daily energy consumption per meter calculation


const fetchDataNoneCharts = (select, startDate, endDate, divID, divDate) => {
    $(`#${divDate}`).text(`${formatDate(startDate)} - ${formatDate(endDate)}`);
    $.ajax({
        type: "GET",
        url: "/getEnergyConsumption",
        data: {
            select: select,
            startDate: startDate,
            endDate: endDate
        },
        success: function (data) {
            let totalValue = {};
            let totalValueId = document.getElementById(`${divID}`);

            totalValue[divID] = data.reduce((total, item) => total + item.daily_consumption, 0);

            createOdometer(totalValueId, totalValue[divID].toLocaleString());
            // $(`#${divID}`).html(totalValue[divID].toLocaleString());
            // console.log(totalValue);

        },
        error: function (error) {
            console.log(error);
        }
    })

};

const processCurrentWeekEnergyConsumption = () => {
    let select = "*, ROUND((end_energy - start_energy), 2) AS daily_consumption";
    const [startDate, endDate] = getStartEndDate(7, 7, 'week', 1);
    let endDateMoment = moment(endDate);
    let endDateSub = endDateMoment.clone().subtract(1, "day").format('YYYY-MM-DD HH:mm:ss');

    setIntervalAtFiveMinuteMarks(function () {
        console.log("refetching...");
        fetchDataNoneCharts(select, startDate, endDateSub, "weeklyEnergyConsumption", "weeklyEnergyConsumptionDate");
    });

    // Initial fetch
    fetchDataNoneCharts(select, startDate, endDateSub, "weeklyEnergyConsumption", "weeklyEnergyConsumptionDate");
};

const processCurrentDayEnergyConsumption = () => {
    let select = "*, ROUND((end_energy - start_energy), 2) AS daily_consumption";
    const [startDate, endDate] = getStartEndDate(7, 1, 'day', 1);

    setIntervalAtFiveMinuteMarks(function () {
        console.log("refetching...");
        fetchDataNoneCharts(select, startDate, endDate, "dailyEnergyConsumption", "dailyEnergyConsumptionDate");
    });

    fetchDataNoneCharts(select, startDate, endDate, "dailyEnergyConsumption", "dailyEnergyConsumptionDate");

};

const processMonthlyEnergyConsumption = () => {
    let select = "*, ROUND((end_energy - start_energy), 2) AS daily_consumption";
    const [startDate, endDate] = getStartEndDate(7, 25, 'month', 1);
    let endDateMoment = moment(endDate);
    let endDateSub = endDateMoment.clone().subtract(1, "day").format('YYYY-MM-DD HH:mm:ss');

    setIntervalAtFiveMinuteMarks(function () {
        console.log("refetching...");
        fetchDataNoneCharts(select, startDate, endDateSub, "monthlyEnergyConsumption", "monthlyEnergyConsumptionDate");
    });

    fetchDataNoneCharts(select, startDate, endDateSub, "monthlyEnergyConsumption", "monthlyEnergyConsumptionDate");

};

processCurrentWeekEnergyConsumption();

processCurrentDayEnergyConsumption();

processMonthlyEnergyConsumption();