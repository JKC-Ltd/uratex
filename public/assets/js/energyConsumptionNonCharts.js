import { createOdometer, formatDate, setIntervalAtFiveMinuteMarks, getStartEndDate } from './dashboardUtils.js?v=10';

const DEFAULT_WHERE_IN = [];
const energyContext = document.getElementById('energy-visibility-context');
const activeBranchId = energyContext?.dataset.branchId || '';

const fetchEnergyConsumption = (select, startDate, endDate, branchId = activeBranchId, whereIn = DEFAULT_WHERE_IN) => {
    return $.ajax({
        type: 'GET',
        url: '/getEnergyConsumption',
        data: {
            select,
            startDate,
            endDate,
            branch_id: branchId || undefined,
            whereIn,
        },
    });
};

const fetchDataNonCharts = (select, startDate, endDate, divID, divDate) => {
    fetchEnergyConsumption(select, startDate, endDate)
        .done((data) => {
            let totalValue = {};
            let totalValueId = document.getElementById(`${divID}`);

            $(`#${divDate}`).text(`${formatDate(startDate)} - ${formatDate(endDate)}`);
            totalValue[divID] = data.reduce((total, item) => total + item.daily_consumption, 0);
            createOdometer(totalValueId, totalValue[divID].toLocaleString());
        })
        .fail((err) => console.log(err));
};


const processCurrentDayEnergyConsumption = () => {
    let select = "*, ROUND((end_energy - start_energy), 2) AS daily_consumption";
    const [startDate, endDate] = getStartEndDate(7, 1, 'day', 1);

    setIntervalAtFiveMinuteMarks(function () {
        console.log("refetching...");
        fetchDataNonCharts(select, startDate, endDate, "dailyEnergyConsumption", "dailyEnergyConsumptionDate");
    });

    fetchDataNonCharts(select, startDate, endDate, "dailyEnergyConsumption", "dailyEnergyConsumptionDate");
};

const processCurrentWeekEnergyConsumption = () => {
    let select = "*, ROUND((end_energy - start_energy), 2) AS daily_consumption";
    const [startDate, endDate] = getStartEndDate(7, 7, 'week', 1);
    let endDateMoment = moment(endDate);
    let endDateSub = endDateMoment.clone().subtract(1, "day").format('YYYY-MM-DD HH:mm:ss');

    setIntervalAtFiveMinuteMarks(function () {
        console.log("refetching...");
        fetchDataNonCharts(select, startDate, endDateSub, "weeklyEnergyConsumption", "weeklyEnergyConsumptionDate");
    });

    // Initial fetch
    fetchDataNonCharts(select, startDate, endDateSub, "weeklyEnergyConsumption", "weeklyEnergyConsumptionDate");
};

const processMonthlyEnergyConsumption = () => {
    const select = `
            ROUND(SUM((end_energy - start_energy)), 2) AS daily_consumption
        `;

    const [startDate, endDate] = getStartEndDate(7, 25, 'month', 1);

    setIntervalAtFiveMinuteMarks(function () {
        fetchDataNonCharts(select, startDate, endDate, "monthlyEnergyConsumption", "monthlyEnergyConsumptionDate");
    });

    fetchDataNonCharts(select, startDate, endDate, "monthlyEnergyConsumption", "monthlyEnergyConsumptionDate");
};



processCurrentDayEnergyConsumption();
processCurrentWeekEnergyConsumption();
processMonthlyEnergyConsumption();

