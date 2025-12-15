import { fetchData, setIntervalAtFiveMinuteMarks, charts, formatDate, renderChart, getStartEndDate, colorScheme, exportFn, createOdometer } from "./shared/main.js?v=1.5";

colorScheme();

const processData = (data, refetch, chartID, dataOptions, columnName) => {

    // let totalEnergyConsumption = 0;
    let uniqueDates = [...new Set(data.map(item => item.reading_date))].sort((a, b) => a.localeCompare(b));

    data.forEach((reading) => {
        // totalEnergyConsumption += reading.daily_consumption;

        // Use the root location name produced by getPerBuilding as the series name
        const seriesName = reading.root_location_name ?? `Location ${reading.root_location_id}`;
        let existingSensor = charts[chartID].options.data.find(sensor => sensor.name === seriesName);

        if (!existingSensor) {
            let newDataOptions = {
                ...dataOptions,
                name: seriesName,
                dataPoints: uniqueDates.map(date => {
                    let dataItem = data.find(d => d.reading_date === date && (d.root_location_name ?? `Location ${d.root_location_id}`) === seriesName);
                    return {
                        name: dataItem?.root_location_name ?? `Location ${dataItem?.root_location_id}`,
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
    const processUrl = "/getEnergyConsumptionPerBuilding";
    const chartName = "dailyEnergyConsumptionAllMeters2";
    const column = "reading_date";
    const dailyEnergyConsumptionAllMetersRequest = {
        select: select,
        roots: [6, 7, 8],
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
            // colorSet: "DailyEnergyColorSet",
            exportEnabled: true,
            zoomEnabled: true,
            title: {
                text: "Daily Energy Consumption - SIIX EMS: Overall Consumption to building",
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