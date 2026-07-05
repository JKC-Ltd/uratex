import { setIntervalAtFiveMinuteMarks, charts, fetchData, colorScheme, formatDate, renderChart, getStartEndDate } from './dashboardUtils.js?v=10';

colorScheme();
const dashboardContext = document.getElementById('energy-visibility-context');
const activeBranchId = dashboardContext?.dataset.branchId || '';
const userRole = (dashboardContext?.dataset.userRole || '').toLowerCase();
const isAdmin = userRole === 'admin';
const availableBranchIds = (() => {
    const rawBranches = dashboardContext?.dataset.branches;
    if (!rawBranches) {
        return [];
    }

    try {
        return JSON.parse(rawBranches)
            .map((branch) => String(branch.id))
            .filter(Boolean);
    } catch (error) {
        return [];
    }
})();

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
    const SELECT = `ROUND(SUM((end_energy - start_energy)), 2) AS daily_consumption,
                    DATE_FORMAT(reading_date, '%M %d, %Y') as reading_date`;
    const PROCESS_URL = '/getDailyEnergyConsumption';
    const CHART_ID = 'pandpEnergyConsumption';
    const LABEL_FIELD = 'reading_date';

    const requestPayload = {
        groupBy: 'reading_date',
        select: SELECT,
        ...(activeBranchId ? { branch_id: activeBranchId } : {}),
    };

    const createChartOptions = () => ({
        exportEnabled: true,
        chartName: 'Previous and Present Energy Consumption - All Meters',
        chartProps: { request: requestPayload, processUrl: PROCESS_URL },
        animationEnabled: true,
        theme: 'light2',
        colorSet: 'DailyEnergyColorSet',
        title: { fontSize: 20, margin: 30 },
        axisX: {
            labelFontSize: 12,
            labelFontWeight: 'bold',
        },
        axisY: {
            title: 'Energy (kWh)',
            titleFontSize: 15,
            labelFontSize: 12,
            includeZero: true,
        },
        legend: { cursor: 'pointer', verticalAlign: 'bottom', horizontalAlign: 'bottom' },
        data: [],
    });

    const createSeriesTemplate = () => ({
        type: 'bar',
        name: CHART_ID,
        indexLabel: '{y}',
        indexLabelMaxWidth: 80,
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
    const PROCESS_URL = '/getEnergyConsumptionPerBuilding';
    const CHART_ID = 'dailyEnergyConsumptionPerMeter';

    const createChartOptions = () => ({
        animationEnabled: true,
        exportEnabled: true,
        chartName: 'Daily Energy Consumption Per Branch',
        chartProps: { processUrl: PROCESS_URL },
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
        showInLegend: false,
        indexLabelFontColor: '#fff',
        indexLabelFontSize: 13,
        indexLabelPlacement: 'inside',
        dataPoints: [],
    });

    const processPerBranch = (rows, refetch) => {
        // Sum daily_consumption across all reading dates, grouped by branch
        const byBranch = {};
        (rows || []).forEach(r => {
            const branch = r.root_location_name || `Branch ${r.root_location_id}`;
            byBranch[branch] = (byBranch[branch] || 0) + (Number(r.daily_consumption) || 0);
        });

        const dataPoints = Object.entries(byBranch).map(([label, total]) => ({
            label,
            y: Number(total.toFixed(2)),
        }));

        charts[CHART_ID] = charts[CHART_ID] || { options: createChartOptions() };
        charts[CHART_ID].options.data = [
            Object.assign({}, createSeriesTemplate(), { dataPoints }),
        ];

        if (refetch && charts[CHART_ID]) charts[CHART_ID].render();
        else renderChart(CHART_ID, charts[CHART_ID].options);
    };

    // periodic refetch
    const doFetch = (refetch = false) => {
        const [startDate, endDate] = getStartEndDate(7, 1, 'day', 1);
        const requestPayload = {
            startDate,
            endDate,
            ...(activeBranchId ? { branch_id: activeBranchId } : {}),
            ...(!activeBranchId && !isAdmin && availableBranchIds.length ? { branch_ids: availableBranchIds } : {}),
            ...(!activeBranchId && isAdmin ? { roots: [2, 10, 16] } : {}),
        };
        if (charts[CHART_ID]) charts[CHART_ID].options.chartProps = { request: requestPayload, processUrl: PROCESS_URL };
        fetchData(requestPayload, createSeriesTemplate(), CHART_ID, PROCESS_URL, 'root_location_name', processPerBranch, refetch);
        if (refetch && charts[CHART_ID]) charts[CHART_ID].render();
    };
    
    setIntervalAtFiveMinuteMarks(() => doFetch(true));

    // initialize and do first fetch
    charts[CHART_ID] = { options: createChartOptions() };
    doFetch();
  
};


// Previous & Present Energy Consumption - Per Building (grouped by building on X axis)
const processPandPEnergyConsumptionPerBuilding = () => {
    const PROCESS_URL = '/getEnergyConsumptionPerBuilding';
    const SELECT = `root_location_id,
                        root_location_name,
                        ROUND(SUM(daily_consumption), 2) AS daily_consumption,
                        reading_date`;
    const CHART_ID = 'pAndPEnergyConsumptionPerBuilding';
    const LABEL_FIELD = 'reading_date';

    const getDateWindow = () => {
        const now = moment();
        const today7AM = now.clone().startOf('day').add(7, 'hours');
        return {
            startDate: now.isSameOrAfter(today7AM)
                ? today7AM.clone().subtract(1, 'day').format('YYYY-MM-DD HH:mm:ss')
                : today7AM.clone().subtract(2, 'days').format('YYYY-MM-DD HH:mm:ss'),
            endDate: now.isSameOrAfter(today7AM)
                ? today7AM.clone().add(1, 'day').format('YYYY-MM-DD HH:mm:ss')
                : today7AM.format('YYYY-MM-DD HH:mm:ss'),
        };
    };
    const requestPayload = {
        roots: [2, 10, 16],
        select: SELECT,
        ...getDateWindow(),
        ...(activeBranchId ? { branch_id: activeBranchId } : {}),
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
        const byDate = {};
        const buildingSet = new Set();
        (rows || []).forEach(r => {
            const date = r.reading_date;
            const building = r.root_location_name || r.location_name || `Building ${r.root_location_id}`;
            const val = Number(r.daily_consumption) || 0;
            byDate[date] = byDate[date] || {};
            byDate[date][building] = (byDate[date][building] || 0) + val;
            buildingSet.add(building);
        });

        const dates = Object.keys(byDate).sort((a, b) => new Date(a) - new Date(b));
        const buildingOrder = [...buildingSet].sort();

        const series = dates.map(date => {
            const buildings = byDate[date] || {};

            return Object.assign({}, createSeriesTemplate(), {
                name: date,
                dataPoints: buildingOrder.map((buildingName) => ({
                    label: buildingName,
                    y: Number(((buildings[buildingName] || 0)).toFixed(2)),
                })),
            });
        });

        charts[CHART_ID] = charts[CHART_ID] || { options: createChartOptions() };
        charts[CHART_ID].options.data = series;

        if (refetch && charts[CHART_ID]) charts[CHART_ID].render();
        else renderChart(CHART_ID, charts[CHART_ID].options);
    };

    // periodic refetch
    const doFetch = (refetch = false) => {
        const payload = {
            roots: [2, 10, 16],
            select: SELECT,
            ...getDateWindow(),
            ...(activeBranchId ? { branch_id: activeBranchId } : {}),
        };
        fetchData(payload, createSeriesTemplate(), CHART_ID, PROCESS_URL, LABEL_FIELD, processPerBuilding, refetch);
        if (refetch && charts[CHART_ID]) charts[CHART_ID].render();
    };

    setIntervalAtFiveMinuteMarks(() => doFetch(true));

    // initialize and perform first fetch
    charts[CHART_ID] = { options: createChartOptions() };
    doFetch();
};

processPandPEnergyConsumptionPerBuilding();


// Process for the Previous and Present energy consumption calculation
processPandPEnergyConsumption();


// Process for the Daily energy consumption per meter calculation
processDailyEnergyConsumption();