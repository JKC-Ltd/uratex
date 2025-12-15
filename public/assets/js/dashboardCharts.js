import { setIntervalAtFiveMinuteMarks, charts, fetchData, colorScheme, formatDate, renderChart, getStartEndDate } from './dashboardUtils.js?v=10';

colorScheme();
const processChartData = (rows, shouldRefetch, chartId, seriesTemplate, labelField) => {
    const now = new Date();
    const hour = now.getHours();
    const minute = now.getMinutes();

    if (!Array.isArray(rows) || rows.length === 0) {
        if (shouldRefetch && charts[chartId]) charts[chartId].render();
        return;
    }

    // ensure chart exists
    charts[chartId] = charts[chartId] || { options: { data: [] } };

    rows.forEach((row) => {
        const label = row[labelField];
        const value = row.daily_consumption;

        let series = charts[chartId].options.data.find(s => s.name === (seriesTemplate.name || chartId) || s.name === chartId);

        if (!series) {
            // initialize a fresh series based on the template
            series = Object.assign({}, seriesTemplate);
            series.dataPoints = series.dataPoints || [];
            series.dataPoints.push({ y: value, label });
            charts[chartId].options.data.push(series);
            return;
        }

        const existingPoint = series.dataPoints.find(dp => dp.label === label);
        if (!existingPoint) {
            series.dataPoints.push({ y: value, label });
            return;
        }

        // During the early 7:00–7:04 window we keep values at 0 to avoid transient spikes
        if (hour === 7 && minute >= 0 && minute <= 4) {
            existingPoint.y = 0;
        } else {
            existingPoint.y = value;
        }
    });

    if (shouldRefetch) {
        charts[chartId].render();
    } else {
        renderChart(chartId, charts[chartId].options);
    }
};

const processPandPEnergyConsumption = () => {
    const SELECT = `sensors.description as sensor_description,
                    location_name,
                    ROUND(SUM((end_energy - start_energy)), 2) AS daily_consumption,
                    DATE_FORMAT(reading_date, '%M %d, %Y') as reading_date`;
    const PROCESS_URL = '/getDailyEnergyConsumption';
    const CHART_ID = 'pandpEnergyConsumption';
    const LABEL_FIELD = 'reading_date';

    const requestPayload = {
        groupBy: 'reading_date',
        select: SELECT,
        whereIn: [
            { field: 'sensor_id', value: [15, 19] },
        ],
    };

    const createChartOptions = () => ({
        exportEnabled: true,
        chartName: 'Previous and Present Energy Consumption - All Meters',
        chartProps: { request: requestPayload, processUrl: PROCESS_URL },
        animationEnabled: true,
        theme: 'light2',
        colorSet: 'DailyEnergyColorSet',
        title: { fontSize: 20, margin: 30 },
        axisY: {
            title: 'Energy (kWh)',
            titlePadding: { top: 1, bottom: 15 },
            titleFontSize: 15,
            labelFontSize: 12,
            minimum: 10,
            labelFontWeight: 'bold',
        },
        legend: { cursor: 'pointer', verticalAlign: 'bottom', horizontalAlign: 'bottom' },
        data: [],
    });

    const createSeriesTemplate = () => ({
        type: 'column',
        name: CHART_ID,
        indexLabel: '{y}',
        indexLabelMaxWidth: 60,
        indexLabelFontColor: '#FFF',
        indexLabelFontSize: 15,
        indexLabelPlacement: 'inside',
        indexLabelTextAlign: 'center',
        dataPoints: [],
    });

    // periodic refetch
    setIntervalAtFiveMinuteMarks(() => {
        fetchData(requestPayload, createSeriesTemplate(), CHART_ID, PROCESS_URL, LABEL_FIELD, processChartData, true);
        if (charts[CHART_ID]) charts[CHART_ID].render();
    });

    // initialize and perform first fetch
    charts[CHART_ID] = { options: createChartOptions() };
    fetchData(requestPayload, createSeriesTemplate(), CHART_ID, PROCESS_URL, LABEL_FIELD, processChartData);
};

const processDailyEnergyConsumption = () => {
    const SELECT = `sensor_id,
                    ROUND(SUM((end_energy - start_energy)), 2) AS daily_consumption`;
    const PROCESS_URL = '/getEnergyConsumption';
    const CHART_ID = 'dailyEnergyConsumptionPerMeter';
    const LABEL_FIELD = 'sensor_description';

    // Get dynamic start/end dates
    const [startDate, endDate] = getStartEndDate(7, 1, 'day', 1);

    const requestPayload = {
        select: SELECT,
        startDate,
        endDate,
        groupBy: 'sensor_id',
        whereIn: [
            { field: 'sensor_id', value: [15, 16, 17, 18, 19] },
        ],
    };

    const createChartOptions = () => ({
        animationEnabled: true,
        exportEnabled: true,
        chartName: 'Daily Energy Consumption Per Meter',
        chartProps: { request: requestPayload, processUrl: PROCESS_URL },
        theme: 'light2',
        colorSet: 'DailyEnergyColorSet',
        title: { fontSize: 20, margin: 30 },
        axisY: { includeZero: true },
        axisX: { labelFontSize: 12, interval: 1 },
        data: [],
    });

    const createSeriesTemplate = () => ({
        type: 'bar',
        name: CHART_ID,
        indexLabel: '{y} kWh',
        showInlegend: false,
        indexLabelFontColor: '#fff',
        indexLabelFontSize: 13,
        indexLabelPlacement: 'inside',
        dataPoints: [],
    });

    // periodic refetch
    setIntervalAtFiveMinuteMarks(() => {
        fetchData(requestPayload, createSeriesTemplate(), CHART_ID, PROCESS_URL, LABEL_FIELD, aggregatedProcessFn, true);
        if (charts[CHART_ID]) charts[CHART_ID].render();
    });

    // initialize and do first fetch
    charts[CHART_ID] = { options: createChartOptions() };
    fetchData(requestPayload, createSeriesTemplate(), CHART_ID, PROCESS_URL, LABEL_FIELD, aggregatedProcessFn);
};

function aggregatedProcessFn(rows, refetch, chartId, dataOptions, columnName) {
    const mapBySensor = {};
    (rows || []).forEach(r => {
        const id = Number(r.sensor_id);
        const val = Number(r.daily_consumption) || 0;
        mapBySensor[id] = (mapBySensor[id] || 0) + val;
    });

    // Compute building values
    const building2Ids = [16, 17, 18];
    const building2 = building2Ids.reduce((sum, id) => sum + (mapBySensor[id] || 0), 0);
    const building3 = mapBySensor[19] || 0;
    const sensor15 = mapBySensor[15] || 0;
    const building1 = sensor15 - building2;

    const aggregatedRows = [
        { label: 'Building 3', daily_consumption: Number(building3.toFixed(2)) },
        { label: 'Building 2', daily_consumption: Number(building2.toFixed(2)) },
        { label: 'Building 1', daily_consumption: Number(building1.toFixed(2)) },
    ];

    processChartData(aggregatedRows, refetch, chartId, dataOptions, 'label');
}

// Previous & Present Energy Consumption - Per Building (grouped by building on X axis)
const processPandPEnergyConsumptionPerBuilding = () => {
    const SELECT = `sensor_id,
                        ROUND(SUM((end_energy - start_energy)), 2) AS daily_consumption,
                        DATE_FORMAT(reading_date, '%M %d, %Y') as reading_date`;
    const PROCESS_URL = '/getDailyEnergyConsumption';
    const CHART_ID = 'pAndPEnergyConsumptionPerBuilding';
    const LABEL_FIELD = 'reading_date';

    const requestPayload = {
           groupBy: ['reading_date', 'sensor_id'],
        select: SELECT,
        whereIn: [{ field: 'sensor_id', value: [15, 16, 17, 18, 19] }],
    };

    const createChartOptions = () => ({
        exportEnabled: true,
        chartName: 'Previous and Present Energy Consumption - Per Building',
        chartProps: { request: requestPayload, processUrl: PROCESS_URL },
        animationEnabled: true,
        theme: 'light2',
        colorSet: 'DailyEnergyColorSet',
        title: { fontSize: 20, margin: 30 },
        axisY: { title: 'Energy (kWh)', titlePadding: { top: 1, bottom: 15 }, titleFontSize: 15, labelFontSize: 12 },
        legend: { cursor: 'pointer', verticalAlign: 'bottom', horizontalAlign: 'bottom' },
        data: [],
    });

    const createSeriesTemplate = () => ({ type: 'column', name: '', indexLabel: '{y}', indexLabelFontColor: '#FFF', indexLabelFontSize: 12, indexLabelPlacement: 'inside', dataPoints: [] });

    const processPerBuilding = (rows, refetch) => {
        // rows: [{ sensor_id, daily_consumption, reading_date }, ...]
        const byDate = {};
        (rows || []).forEach(r => {
            const date = r.reading_date;
            const sensor = Number(r.sensor_id);
            const val = Number(r.daily_consumption) || 0;
            byDate[date] = byDate[date] || {};
            byDate[date][sensor] = (byDate[date][sensor] || 0) + val;
        });

        const dates = Object.keys(byDate).sort((a, b) => new Date(a) - new Date(b));

        // For each date create a series where dataPoints are Building 1/2/3
        const series = dates.map(date => {
            const sensors = byDate[date] || {};
            const b2 = [16, 17, 18].reduce((s, id) => s + (sensors[id] || 0), 0);
            const b3 = sensors[19] || 0;
            const s15 = sensors[15] || 0;
            const b1 = s15 - b2;

            return Object.assign({}, createSeriesTemplate(), {
                name: date,
                dataPoints: [
                    { label: 'Building 1', y: Number(b1.toFixed(2)) },
                    { label: 'Building 2', y: Number(b2.toFixed(2)) },
                    { label: 'Building 3', y: Number(b3.toFixed(2)) },
                ],
            });
        });

        charts[CHART_ID] = charts[CHART_ID] || { options: createChartOptions() };
        charts[CHART_ID].options.data = series;

        if (refetch && charts[CHART_ID]) charts[CHART_ID].render();
        else renderChart(CHART_ID, charts[CHART_ID].options);
    };

    // periodic refetch
    setIntervalAtFiveMinuteMarks(() => {
        fetchData(requestPayload, createSeriesTemplate(), CHART_ID, PROCESS_URL, LABEL_FIELD, processPerBuilding, true);
        if (charts[CHART_ID]) charts[CHART_ID].render();
    });

    // initialize and perform first fetch
    charts[CHART_ID] = { options: createChartOptions() };
    fetchData(requestPayload, createSeriesTemplate(), CHART_ID, PROCESS_URL, LABEL_FIELD, processPerBuilding);
};

processPandPEnergyConsumptionPerBuilding();


// Process for the Previous and Present energy consumption calculation
processPandPEnergyConsumption();


// Process for the Daily energy consumption per meter calculation
processDailyEnergyConsumption();