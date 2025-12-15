window.onload = function () {

    let charts = [];

    CanvasJS.addColorSet("DailyEnergyColorSet",
        [
            '#bca184', // Warm Taupe
            '#7a8b4e', // Olive Green
            '#d67c6e', // Muted Coral
            '#4e5b7e', // Dark Slate Blue
            '#9b4d82', // Soft Plum
            '#b57e1f',  // Dark Mustard
            '#5d737e', // Dusty Teal
            '#e57c10', // Medium Orange
            '#4a8fc2', // Medium Blue

        ]);

    const renderChart = (chartID, config) => {
        charts[chartID] = new CanvasJS.Chart(chartID, config);
        charts[chartID].render();
    }

    const formatDate = (date) => {
        const newDate = new Date(date);
        return newDate.toLocaleDateString("en-US", { year: "numeric", month: "long", day: "numeric" });
    }

    const processData = (data, refetch, chartID, columnName) => {

        let totalEnergyConsumption = 0;
        // let dateToday = new Date();
        // dateToday.setHours(dateToday.getHours() - 9); // Deduct 9 hours
        // dateToday = formatDate(dateToday);

        let uniqueDates = [...new Set(data.map(item => item.reading_date))];

        data.forEach((reading) => {
            totalEnergyConsumption += reading.daily_consumption;
            let existingSensor = charts[chartID].options.data.find(sensor => sensor.name === reading.description);
            if (!existingSensor) {
                charts[chartID].options.data.push({
                    type: "stackedColumn",
                    name: reading.description,
                    showInLegend: true,
                    dataPoints: uniqueDates.map(date => {
                        let dataItem = data.find(d => d.reading_date === date && d.description === reading.description);
                        return { name: dataItem.description, label: formatDate(date), y: dataItem ? dataItem.daily_consumption : null };
                    })
                });
            }
        });

        $('#monthlyEnergyConsumption').html(totalEnergyConsumption.toLocaleString());

        if (refetch) {
            charts[chartID].render();
        } else {
            renderChart(chartID, charts[chartID].options);
        }

    };


    const getStartEndDate = (hours, days, period, duration) => {
        let now = moment();
        let dateToday = now.clone().startOf(period).add(hours, 'hours');


        if (period === 'month') {
            dateToday.add(days, 'days');
        }

        let formattedStartDate, formattedEndDate;

        if (now.isSameOrAfter(dateToday)) {
            formattedStartDate = dateToday.clone().format('YYYY-MM-DD HH:mm:ss');
            formattedEndDate = dateToday.clone().add(duration, period).format('YYYY-MM-DD HH:mm:ss');
        } else {
            formattedStartDate = dateToday.clone().subtract(duration, period).format('YYYY-MM-DD HH:mm:ss');
            formattedEndDate = dateToday.clone().format('YYYY-MM-DD HH:mm:ss');
        }

        console.log(formattedStartDate, formattedEndDate);
        return [formattedStartDate, formattedEndDate];
    };



    const fetchData = (request, chartID, url, columnName, refetch = false) => {

        $.ajax({
            type: "GET",
            url: url,
            data: request,
            success: function (data) {
                processData(data, refetch, chartID, columnName);
            },
            error: function (error) {
                console.log(error);
            }
        })
    };

    const setIntervalAtFiveMinuteMarks = (callback) => {
        const now = new Date();
        const delay = (5 - (now.getMinutes() % 5)) * 60 * 1000 - now.getSeconds() * 1000 - now.getMilliseconds();
        setTimeout(() => {
            callback();
            setInterval(callback, 5 * 60 * 1000);
        }, delay);
    };

    const processDailyEnergyConsumptionAllMeters = () => {

        let select = "*, ROUND((end_energy - start_energy), 2) AS daily_consumption";
        [startDate, endDate] = getStartEndDate(9, 24, 'month', 1);

        const initDailyEnergyConsumptionAllMeters = () => {

            return {
                animationEnabled: true,
                theme: "light2",
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
                    content: "{name}: {y} kWh"
                },
                legend: {
                    cursor: "pointer",
                    horizontalAlign: "center",
                    itemclick: (e) => toggleDataSeries(e, "dailyEnergyConsumptionAllMeters"),
                    fontSize: 15,
                },
                data: [],
            }
        }



        const toggleDataSeries = (e, chartID) => {
            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            charts[chartID].render();
        }

        const dailyEnergyConsumptionAllMeters = initDailyEnergyConsumptionAllMeters();
        const dailyEnergyConsumptionAllMetersRequest = {
            select: select,
            startDate: startDate,
            endDate: endDate

        };
        charts["dailyEnergyConsumptionAllMeters"] = { options: dailyEnergyConsumptionAllMeters };
        fetchData(dailyEnergyConsumptionAllMetersRequest, "dailyEnergyConsumptionAllMeters", "/getEnergyConsumption", "reading_date");

        setIntervalAtFiveMinuteMarks(function () {
            console.log("refetching...");
            fetchData(dailyEnergyConsumptionAllMetersRequest, "dailyEnergyConsumptionAllMeters", "/getEnergyConsumption", "reading_date", true);
            charts["dailyEnergyConsumptionAllMeters"].render();
        });
    }

    // Process for the Monthly energy consumption calculation
    processDailyEnergyConsumptionAllMeters();

    // -----------------------------------------------------------------------------------------------


    // Separate process for no charts

    // Process for the Daily energy consumption per meter calculation


    const fetchDataNoneCharts = (select, startDate, endDate, divID) => {

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
                totalValue[divID] = data.reduce((total, item) => total + item.daily_consumption, 0);

                $(`#${divID}`).html(totalValue[divID].toFixed(2));
                console.log(totalValue);

            },
            error: function (error) {
                console.log(error);
            }
        })
    };

    const processCurrentWeekEnergyConsumption = () => {
        let select = "*, ROUND((end_energy - start_energy), 2) AS daily_consumption";

        setIntervalAtFiveMinuteMarks(function () {
            [startDate, endDate] = getStartEndDate(9, 7, 'week', 1);
            console.log("refetching...");
            fetchDataNoneCharts(select, startDate, endDate, "weeklyEnergyConsumption");
        });

        // Initial fetch
        [startDate, endDate] = getStartEndDate(9, 7, 'week', 1);
        fetchDataNoneCharts(select, startDate, endDate, "weeklyEnergyConsumption");
    };

    const processCurrentDayEnergyConsumption = () => {

        let select = "*, ROUND((end_energy - start_energy), 2) AS daily_consumption";

        setIntervalAtFiveMinuteMarks(function () {
            [startDate, endDate] = getStartEndDate(9, 1, 'day', 1);
            console.log("refetching...");
            fetchDataNoneCharts(select, startDate, endDate, "dailyEnergyConsumption");
        });

        [startDate, endDate] = getStartEndDate(9, 1, 'day', 1);
        fetchDataNoneCharts(select, startDate, endDate, "dailyEnergyConsumption");

    };

    processCurrentWeekEnergyConsumption();

    processCurrentDayEnergyConsumption();

}
