import { fetchData, setIntervalAtFiveMinuteMarks, charts, formatDate, renderChart, getStartEndDate, colorScheme } from "./shared/main.js?v=1.1.3";

colorScheme();

const processData = (data, refetch, chartID, dataOptions, columnName) => {
    console.log(`Processing data for chart: ${chartID}`);
    console.log(data);

    let dateToday = new Date();
    dateToday.setHours(dateToday.getHours() - 7); // Deduct 7 hours
    dateToday = formatDate(dateToday);

    data.forEach((reading) => {
        let existingSensor = charts[chartID].options.data.find(chartData => chartData.name === "Active Power");

        if (reading.sensor_brand === "Eastron") {
            reading.real_power = reading.real_power / 1000;
        }

        if (existingSensor) {
            existingSensor.dataPoints.push(
                { y: reading.real_power, label: reading[columnName] },
            );
        } else {
            dataOptions.dataPoints.push(
                { y: reading.real_power, label: reading[columnName] },
            );

            charts[chartID].options.data.push(dataOptions);
        }
    });

    renderChart(chartID, charts[chartID].options);
};

const processActivePowerProfile = (id) => {
    // const [startDate, endDate] = getStartEndDate(9, 25, 'month', 1);
    const processUrl = "/getPower";
    const column = "datetime_created";
    const chartName = "activePowerProfile";
    const activePowerProfileRequest = {
        select: "real_power, datetime_created, sensor_id, sensor_model, sensor_brand",
        // startDate: startDate,
        // endDate: endDate,
        where:
        {
            field: "sensor_id",
            operator: "=",
            value: id,
        }
    };

    const activePowerProfile = () => {

        return {
            exportEnabled: true,
            animationEnabled: true,
            chartName: "Active Power Profile",
            chartProps: {
                request: activePowerProfileRequest,
                processUrl,
            },
            theme: "light2",
            zoomEnabled: true,
            title: {
                text: "Active Power Profile",
                fontSize: 20,
            },
            axisX: {
                labelAngle: -90,
                margin: 30,
                labelFontSize: 12,
                interval: 150,
                // intervalType: "day",
            },
            axisY: {
                title: "Active Power (kW)",
                titlePadding: {
                    top: 1,
                    bottom: 15,
                },
                titleFontSize: 15,
                // includeZero: true
                labelFontSize: 12
            },
            toolTip: {
                shared: true
            },
            legend: {
                cursor: "pointer",
                verticalAlign: "top",
                horizontalAlign: "center",
                dockInsidePlotArea: true,
            },
            data: [],
        }
    }

    const activePowerProfileDataOptions = () => {

        return {
            type: "line",
            name: `Active Power`,
            markerSize: 0,
            dataPoints: [],
        }
    }
    charts[chartName + id] = { options: activePowerProfile() };
    fetchData(activePowerProfileRequest, activePowerProfileDataOptions(), chartName + id, processUrl, column, processData);

}

// Process for the Previous and Present energy consumption calculation

$('.nav-link').on('click', function () {
    console.log('Nav link clicked');

    let activePowerProfileDataId = $(this).data('id');
    console.log(`Active power profile data ID: ${activePowerProfileDataId}`);

    processActivePowerProfile(activePowerProfileDataId);

});

export { processActivePowerProfile };