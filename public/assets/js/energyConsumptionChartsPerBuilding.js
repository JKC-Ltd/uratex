import { setIntervalAtFiveMinuteMarks, charts, fetchData, colorScheme, formatDate, renderChart, getStartEndDate } from './dashboardUtils.js?v=10';

colorScheme();
// Unified processor (same shape as `energyConsumptionCharts.js`)
const processChartData = (data, refetch, chartID, dataOptions, columnName) => {
    // Aggregate sensor rows into date -> building sums
    const byDate = {};
    (data || []).forEach(r => {
        const date = r.reading_date;
        const sensor = Number(r.sensor_id);
        const val = Number(r.daily_consumption) || 0;
        byDate[date] = byDate[date] || {};
        byDate[date][sensor] = (byDate[date][sensor] || 0) + val;
    });

    const uniqueDates = Object.keys(byDate).sort((a, b) => new Date(a) - new Date(b));

    const buildings = ['Building 1', 'Building 2', 'Building 3'];

    charts[chartID] = charts[chartID] || { options: { data: [] } };

    buildings.forEach(building => {
        // avoid duplicating series on refetch
        if (charts[chartID].options.data.find(s => s.name === building)) return;

        const dataPoints = uniqueDates.map(date => {
            const sensors = byDate[date] || {};
            const b2 = [16, 17, 18].reduce((s, id) => s + (sensors[id] || 0), 0);
            const b3 = sensors[19] || 0;
            const s15 = sensors[15] || 0;
            const b1 = s15 - b2;

            let y = 0;
            if (building === 'Building 1') y = Number(b1.toFixed(2));
            if (building === 'Building 2') y = Number(b2.toFixed(2));
            if (building === 'Building 3') y = Number(b3.toFixed(2));

            return { label: formatDate(date), y };
        });

        charts[chartID].options.data.push(Object.assign({}, dataOptions, { name: building, dataPoints }));
    });

    if (refetch) charts[chartID].render();
    else renderChart(chartID, charts[chartID].options);
};


// Create a stacked per-building chart similar to `energyConsumptionCharts.js`.
const processDailyEnergyConsumptionPerBuilding = () => {
    const SELECT = `*, ROUND((end_energy - start_energy), 2) AS daily_consumption`;
    const PROCESS_URL = '/getEnergyConsumption';
    const CHART_ID = 'dailyEnergyConsumptionPerBuilding';
    const LABEL_FIELD = 'reading_date';

    const requestPayload = {
        select: SELECT,
        whereIn: [
            { field: 'sensor_id', value: [15, 16, 17, 18, 19] },
        ],
    };

    const createChartOptions = () => ({
        animationEnabled: true,
        theme: 'light2',
        exportEnabled: true,
        chartName: 'Daily Energy Consumption - Per Building (Stacked)',
        chartProps: { request: requestPayload, processUrl: PROCESS_URL },
        colorSet: 'DailyEnergyColorSet',
        title: {
            text: "Daily Energy Consumption - Total Facility",
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

    const createEmptySeries = () => ({ type: 'stackedColumn', name: "", showInLegend: true, dataPoints: [] });

    const toolTipContent = (e) => {
        const totalConsumption = e.entries.reduce((total, item) => total + (item.dataPoint.y || 0), 0);
        const label = `<span style="color:DodgerBlue;">Date:<strong> ${e.entries[0].dataPoint.label}</strong></span><br/><br/>`;
        const total = `<br/><span style="color:Tomato">Total:</span><strong> ${totalConsumption.toLocaleString()}</strong><br/>`;
        let sensors = '';
        e.entries.forEach(entry => {
            sensors += `<span style="color: ${entry.dataSeries.color}"> ${entry.dataSeries.name}: </span> <strong>${entry.dataPoint.y}</strong><br/>`;
        });
        return (label + sensors) + total;
    };

    const toggleDataSeries = (e, CHART_ID) => {
        e.dataSeries.visible = !(typeof e.dataSeries.visible === 'undefined' ? true : e.dataSeries.visible);
        charts[CHART_ID].render();
    };

    // periodic refetch
    setIntervalAtFiveMinuteMarks(() => {
        fetchData(requestPayload, createEmptySeries(), CHART_ID, PROCESS_URL, LABEL_FIELD, processChartData, true);
    });

    // initialize and do first fetch
    charts[CHART_ID] = { options: createChartOptions() };
    fetchData(requestPayload, createEmptySeries(), CHART_ID, PROCESS_URL, LABEL_FIELD, processChartData);
};

processDailyEnergyConsumptionPerBuilding();