import { setIntervalAtFiveMinuteMarks, charts, fetchData, colorScheme, formatDate, renderChart, getStartEndDate } from './dashboardUtils.js?v=10';

colorScheme();
const energyContext = document.getElementById('energy-visibility-context');
const activeBranchId = energyContext?.dataset.branchId || '';
// Unified processor (same shape as `energyConsumptionCharts.js`)
const processChartData = (data, refetch, chartID, dataOptions, columnName) => {
    const rows = Array.isArray(data) ? data : [];
    const byDate = {};
    const sensorsById = new Map();

    rows.forEach((row) => {
        const date = row.reading_date;
        const sensorId = Number(row.sensor_id);
        const sensorName = row.sensor_description || row.description || `Sensor ${sensorId}`;
        const value = Number(row.daily_consumption) || 0;

        byDate[date] = byDate[date] || {};
        byDate[date][sensorId] = (byDate[date][sensorId] || 0) + value;
        sensorsById.set(sensorId, sensorName);
    });

    const uniqueDates = Object.keys(byDate).sort((a, b) => new Date(a) - new Date(b));
    const sensorIds = [...sensorsById.keys()].sort((a, b) => a - b);

    charts[chartID] = charts[chartID] || { options: { data: [] } };
    charts[chartID].options.data = sensorIds.map((sensorId) => {
        const sensorName = sensorsById.get(sensorId) || `Sensor ${sensorId}`;
        const dataPoints = uniqueDates.map((date) => ({
            label: formatDate(date),
            y: Number(((byDate[date] || {})[sensorId] || 0).toFixed(2)),
        }));

        return Object.assign({}, dataOptions, {
            name: sensorName,
            dataPoints,
        });
    });

    if (refetch) charts[chartID].render();
    else renderChart(chartID, charts[chartID].options);
};


// Create a stacked chart that shows all sensors.
const processDailyEnergyConsumptionPerBuilding = () => {
    const SELECT = `*, ROUND((end_energy - start_energy), 2) AS daily_consumption`;
    const PROCESS_URL = '/getEnergyConsumption';
    const CHART_ID = 'dailyEnergyConsumptionPerBuilding';
    const LABEL_FIELD = 'reading_date';

    const requestPayload = {
        select: SELECT,
        ...(activeBranchId ? { branch_id: activeBranchId } : {}),
    };

    const createChartOptions = () => ({
        animationEnabled: true,
        theme: 'light2',
        exportEnabled: true,
        chartName: 'Daily Energy Consumption - All Sensors (Stacked)',
        chartProps: { request: requestPayload, processUrl: PROCESS_URL },
        colorSet: 'DailyEnergyColorSet',
        title: {
            text: "Daily Energy Consumption - All Sensors",
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