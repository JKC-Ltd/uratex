import { fetchData, setIntervalAtFiveMinuteMarks, charts, formatDate, renderChart, getStartEndDate, colorScheme, createOdometer } from "./shared/main.js?v=1.4";

colorScheme();
const processData = (data, refetch, chartID, dataOptions, columnName) => {

    let now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes();

    data.forEach((reading) => {
        let existingSensor = charts[chartID].options.data.find(sensor => sensor.name === chartID);

        if (!existingSensor) {
            // console.log('tests');
            dataOptions.dataPoints.push({
                y: reading.daily_consumption,
                label: reading[columnName]
            })

            charts[chartID].options.data.push(dataOptions);
        } else {
            let chartDataPoints = existingSensor.dataPoints;

            console.log(`Current Time: ${hours}:${minutes}`);

            let existingDataOptions = chartDataPoints.find(dp => dp.label === reading[columnName]);
            // console.log(existingDataOptions);
            if (!existingDataOptions) {
                chartDataPoints.push({
                    y: reading.daily_consumption,
                    label: reading[columnName]
                });
            } else {
                if (hours === 7 && minutes >= 0 && minutes <= 4) {
                    existingDataOptions.y = 0;
                } else {
                    existingDataOptions.y = reading.daily_consumption;
                }
            }
        }
    });

    let dateToday = new Date();
    dateToday.setHours(dateToday.getHours() - 7);
    dateToday = formatDate(dateToday);

    if (chartID === "pandpEnergyConsumption") {
        let chartDataPoints = charts[chartID].options.data[0].dataPoints;

        let totalEnergyConsumption = chartDataPoints.find(date => formatDate(date.label) === formatDate(dateToday));
        let totalEnergyConsumptionValue = document.getElementById("totalEnergyConsumptionValue");

        // $("#totalEnergyConsumptionValue").html(totalEnergyConsumption?.y.toLocaleString() ?? 0);
        createOdometer(totalEnergyConsumptionValue, totalEnergyConsumption?.y.toLocaleString() ?? 0);  

        $("#ghgCurrentDayValue").html(`${Number((totalEnergyConsumption.y * 0.512).toFixed(2)).toLocaleString()} kWh`);
        $("#ghgCurrentDay").css('width', (totalEnergyConsumption.y * 0.512).toFixed(2));

    }

    if (chartID === "dailyEnergyConsumptionPerMeter") {
        let totalValuePerArea = {};
        // console.log(data);
        data.forEach(sensorData => {
            let sensorLocationID = $(`#energyConsumptionPerArea${sensorData.location_id}`);
            if (!totalValuePerArea[sensorData.location_id]) {
                totalValuePerArea[sensorData.location_id] = 0;
            }

            if (hours === 7 && minutes >= 0 && minutes <= 4) {
                totalValuePerArea[sensorData.location_id] = 0;
            } else {
                totalValuePerArea[sensorData.location_id] += sensorData.daily_consumption;
            }

            sensorLocationID.html(totalValuePerArea[sensorData.location_id].toLocaleString());

        });
    }

    if (refetch) {
        charts[chartID].render();
    } else {
        renderChart(chartID, charts[chartID].options);
    }
};


const processPandPEnergyConsumption = () => {
    const select = `sensors.description as sensor_description,
                    location_name,
                    ROUND(SUM((end_energy - start_energy)), 2) AS daily_consumption, 
                    DATE_FORMAT(reading_date, '%M %d, %Y') as reading_date`;
    const processUrl = "/getDailyEnergyConsumption";
    const chartName = "pandpEnergyConsumption";
    const column = "reading_date";
    const pandpEnergyConsumptionRequest = {
        groupBy: "reading_date",
        select: select,
        where: [
            {
                field: "sensor_id",
                operator: "=",
                value: 15,
            }
        ]
    };

    const pandPEnergyConsumptionOptions = () => ({
        exportEnabled: true,
        chartName: "Previous and Present Energy Consumption - All Meters",
        chartProps: {
            request: pandpEnergyConsumptionRequest,
            processUrl,
        },
        animationEnabled: true,
        theme: "light2",
        colorSet: "DailyEnergyColorSet",
        title: { fontSize: 20, margin: 30 },
        axisY: {
            title: "Energy (kWh)",
            titlePadding: { top: 1, bottom: 15 },
            titleFontSize: 15,
            labelFontSize: 12,
            minimum: 10,
            labelFontWeight: "bold",
        },
        legend: { cursor: "pointer", verticalAlign: "bottom", horizontalAlign: "bottom" },
        data: []
    });

    const pandPEnergyConsumptionDataOptions = () => ({
        type: "column",
        name: chartName,
        indexLabel: "{y}",
        indexLabelMaxWidth: 60,
        indexLabelFontColor: "#FFF",
        indexLabelFontSize: 15,
        indexLabelPlacement: "inside",
        indexLabelTextAlign: "center",
        dataPoints: []
    });

    setIntervalAtFiveMinuteMarks(() => {
        console.log("Refetching...");
        fetchData(pandpEnergyConsumptionRequest, pandPEnergyConsumptionDataOptions(), chartName, processUrl, column, processData, true);
        charts[chartName].render();
    });

    charts[chartName] = { options: pandPEnergyConsumptionOptions() };
    fetchData(pandpEnergyConsumptionRequest, pandPEnergyConsumptionDataOptions(), chartName, processUrl, column, processData);
};

const processDailyEnergyConsumptionPerMeter = () => {

    const select = `location_name,
                    location_id,
                    description as sensor_description,
                    reading_date,
                    ROUND((end_energy - start_energy), 2) AS daily_consumption
                    `;
    const processUrl = "/getEnergyConsumption";
    const chartName = "dailyEnergyConsumptionPerMeter";
    const column = "sensor_description";

    // Get updated dates dynamically
    const [startDate, endDate] = getStartEndDate(7, 1, 'day', 1);

    const dailyEnergyConsumptionPerMeterRequest = {
        select: select,
        startDate: startDate,
        endDate: endDate,
        where: [
            {
                field: "sensor_id",
                operator: "!=",
                value: 15,
            },
        ]
    };

    const dailyEnergyConsumptionPerMeterOptions = () => {

        return {
            animationEnabled: true,
            exportEnabled: true,
            chartName: "Daily Energy Consumption Per Meter",
            chartProps: {
                request: dailyEnergyConsumptionPerMeterRequest,
                processUrl,
            },
            theme: "light2",
            colorSet: "DailyEnergyColorSet",
            title: {
                fontSize: 20,
                margin: 30
            },
            axisY: {
                includeZero: true,
            },
            axisX: {
                labelFontSize: 12,
                interval: 1,
            },
            data: [

            ]
        }
    }

    const dailyEnergyConsumptionPerMeterDataOptions = () => {
        return {
            type: "bar",
            name: chartName,
            indexLabel: "{y} kWh",
            showInlegend: false,
            indexLabelFontColor: "#fff",
            indexLabelFontSize: 13,
            indexLabelPlacement: "inside",
            dataPoints: []
        }
    };


    setIntervalAtFiveMinuteMarks(function () {
        console.log("refetching...");

        fetchData(dailyEnergyConsumptionPerMeterRequest, dailyEnergyConsumptionPerMeterDataOptions(), chartName, processUrl, column, processData, true);
        charts[chartName].render();
    });

    charts[chartName] = { options: dailyEnergyConsumptionPerMeterOptions() };
    fetchData(dailyEnergyConsumptionPerMeterRequest, dailyEnergyConsumptionPerMeterDataOptions(), chartName, processUrl, column, processData);

}


// Process for the Previous and Present energy consumption calculation
processPandPEnergyConsumption();



// Process for the Daily energy consumption per meter calculation
processDailyEnergyConsumptionPerMeter();

// -----------------------------------------------------------------------------------------------


// Separate process for no charts

// Process for the Daily energy consumption per meter calculation

const fetchDataNoneCharts = (select, startDate, endDate, divID) => {

    if (divID === 'currentMonthEnergyConsumption') {
        $.ajax({
            type: "GET",
            url: "/getEnergyConsumption",
            data: {
                select: select,
                startDate: startDate,
                endDate: endDate,
                whereIn: [
                    {
                        field: "sensor_id",
                        value: [15, 19],
                    },
                ]
            },
            success: function (data) {
                data = data[0];

                let endDateMoment = moment(endDate);
                let endDateSub = endDateMoment.clone().subtract(1, "day").format('YYYY-MM-DD HH:mm:ss');
                let currentMonthEnergyConsumptionValue = document.getElementById(`${divID}Value`);

                // console.log(endDateSub);
                // $(`#${divID}Value`).html(data.daily_consumption.toLocaleString());
                createOdometer(currentMonthEnergyConsumptionValue, data.daily_consumption.toLocaleString());
                $(`#${divID}StartDate`).html(formatDate(startDate));
                $(`#${divID}EndDate`).html(formatDate(endDateSub));

                // $("#ghgCurrentMonth").html(`${(data.daily_consumption * 0.512).toLocaleString()} kWh`);
                $("#ghgCurrentMonthValue").html(`${Number((data.daily_consumption * 0.512).toFixed(2)).toLocaleString()
                    } kWh`);
                $("#ghgCurrentMonth").css('width', (data.daily_consumption * 0.512).toFixed(2));

            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    if (divID === 'currentCurrentDayConsumption') {


        $.ajax({
            type: "GET",
            url: "/getEnergyConsumption",
            data: {
                select: select,
                startDate: startDate,
                endDate: endDate,
                whereIn: [
                    {
                        field: "sensor_id",
                        value: [15, 19],
                    },
                ]
            },
            success: function (data) {
                // console.log(data);
                data = data[0];

                let totalEnergyConsumptionValue = document.getElementById("totalEnergyConsumptionValue");

                // $("#totalEnergyConsumptionValue").html(totalEnergyConsumption?.y.toLocaleString() ?? 0);
                createOdometer(totalEnergyConsumptionValue, data.daily_consumption.toLocaleString() ?? 0);
                $("#ghgCurrentMonth").html(`${(data.daily_consumption * 0.512).toLocaleString()} kWh`);
                $("#ghgCurrentDayValue").html(`${Number((data.daily_consumption * 0.512).toFixed(2)).toLocaleString()
                    } kWh`);
                $("#ghgCurrentDay").css('width', (data.daily_consumption * 0.512).toFixed(2));

            },
            error: function (error) {
                console.log(error);
            }
        });
    }


};

const processCurrentMonthEnergyConsumption = () => {
    const select = `
            ROUND(SUM((end_energy - start_energy)), 2) AS daily_consumption
        `;

    setIntervalAtFiveMinuteMarks(function () {
        const [startDate, endDate] = getStartEndDate(7, 25, 'month', 1);
        console.log("refetching...");
        fetchDataNoneCharts(select, startDate, endDate, "currentMonthEnergyConsumption");
    });

    // Initial fetch
    const [startDate, endDate] = getStartEndDate(7, 25, 'month', 1);
    fetchDataNoneCharts(select, startDate, endDate, "currentMonthEnergyConsumption");
};

const processCurrentDayConsumption = () => {
    const select = `
            ROUND(SUM((end_energy - start_energy)), 2) AS daily_consumption
        `;

    setIntervalAtFiveMinuteMarks(function () {
        const [startDate, endDate] = getStartEndDate(7, 1, 'day', 1);
        console.log("refetching...");
        fetchDataNoneCharts(select, startDate, endDate, "currentCurrentDayConsumption");
    });

    // Initial fetch
    const [startDate, endDate] = getStartEndDate(7, 1, 'day', 1);
    fetchDataNoneCharts(select, startDate, endDate, "currentCurrentDayConsumption");
};

processCurrentMonthEnergyConsumption();

processCurrentDayConsumption();

