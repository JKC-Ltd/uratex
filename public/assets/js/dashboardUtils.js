export const charts = [];

export const colorScheme = () => {
    return CanvasJS.addColorSet("DailyEnergyColorSet",
        [
            '#4f90c0',  // Muted blue
            '#d67e00',  // Muted orange
            '#65aadd',  // Base blue
            '#3976a3',  // Deep blue
            '#b1d3ec',  // Light blue tone
            '#e3cbb3',  // Soft beige tan
            '#f39801',  // Base orange
            '#b26500',  // Deep orange
            '#f8c784',  // Soft pastel orange
            '#fbe7cc',  // Very light warm beige
            '#7ab676',  // Muted green
            '#cc759e',  // Muted rose
            '#a8825d',  // Warm muted tan
            '#7e9eab',  // Dusty blue-gray
        ]);
};

export const createOdometer = (el, value) => {
    const odometer = new Odometer({
        el: el,
        value: 0,
        duration: 3000,
    });
    // ensure we always pass a safe value
    odometer.update((value ?? 0));
};

export const formatDate = (date) => {
    const newDate = new Date(date);
    return newDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
};

export const setIntervalAtFiveMinuteMarks = (callback) => {
    const scheduleNextRun = () => {
        const now = new Date();
        const minutes = now.getMinutes();
        const seconds = now.getSeconds();
        const ms = now.getMilliseconds();

        const minutesUntilNext = 5 - (minutes % 5);
        let delay = minutesUntilNext * 60 * 1000 - seconds * 1000 - ms + 30 * 1000; // +30 seconds

        setTimeout(() => {
            callback();
            scheduleNextRun();
        }, delay);
    };

    scheduleNextRun();
};

export const getStartEndDate = (hours, days, period, duration) => {
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

    return [formattedStartDate, formattedEndDate];
};

export const fetchData = (request, dataOptions, chartID, url, columnName, processData, refetch = false) => {
    $.ajax({
        type: "GET",
        url: url,
        data: request,
        success: function (data) {
            processData(data, refetch, chartID, dataOptions, columnName);
        },
        error: function (error) {
            console.log(error);
        }
    });
};

export const renderChart = (chartID, config) => {
    charts[chartID] = new CanvasJS.Chart(chartID, config);
    charts[chartID].render();

    console.log(config)

    if (charts[chartID].get("exportEnabled")) {
        const toolbarClass = $(`#${chartID}`).find('.canvasjs-chart-toolbar')[0];

        var exportCSV = document.createElement('div');
        var text = document.createTextNode("Export as CSV");
        exportCSV.setAttribute("style", "padding: 12px 8px; background-color: white; color: black")
        exportCSV.appendChild(text);

        exportCSV.addEventListener("mouseover", function () {
            exportCSV.setAttribute("style", "padding: 12px 8px; background-color: #2196F3; color: white")
        });
        exportCSV.addEventListener("mouseout", function () {
            exportCSV.setAttribute("style", "padding: 12px 8px; background-color: white; color: black")
        });
        exportCSV.addEventListener("click", function () {

            $.ajax({
                type: "GET",
                url: '/exportCSV',
                data: {
                    chartName: config.chartName,
                    processUrl: config.chartProps.processUrl ? config.chartProps.processUrl.substring(1) : "",
                    requestPayload: config.chartProps.request,
                },
                success: function (data) {
                    console.log("Download started:", data);
                    const blob = new Blob([data], { type: 'text/csv;charset=utf-8;' });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `${config.chartName}.csv`;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                    console.log("Download completed");
                },
                error: function (error) {
                    console.error("Download failed:", error);
                }
            });

            // downloadCSV({ filename: "chart-data.csv", chart: chart })
        });
        toolbarClass.lastChild.appendChild(exportCSV);
    }

}
