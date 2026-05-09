import { createOdometer, formatDate, setIntervalAtFiveMinuteMarks, getStartEndDate } from './dashboardUtils.js?v=10';

const DEFAULT_WHERE_IN = [];
const dashboardContext = document.getElementById('energy-visibility-context');
const activeBranchId = dashboardContext?.dataset.branchId || '';

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

const fetchDataNonCharts = (select, startDate, endDate, divId) => {
    if (divId === 'currentDayEnergyConsumption') {
        fetchEnergyConsumption(select, startDate, endDate)
            .done((data) => {
                const currentDay = data[0] || { daily_consumption: 0 };
                const totalEnergyConsumptionValue = document.getElementById('currentDayEnergyConsumptionValue');
                createOdometer(totalEnergyConsumptionValue, (currentDay.daily_consumption ?? 0).toLocaleString());

                const ghgDay = Number((currentDay.daily_consumption * 0.512).toFixed(2));
                $('#branchCarbonFootprintDay').html(`${ghgDay.toLocaleString()} <span>kg of CO2</span>`);

                $('#currentDayEnergyConsumptionDate').text(formatDate(startDate));
                const now = new Date();
                $('#currentDayEnergyConsumptionLastUpdate').text(now.toLocaleDateString('en-US', {
                    year: 'numeric', month: 'short', day: 'numeric',
                    hour: '2-digit', minute: '2-digit'
                }));
            })
            .fail((err) => console.log(err));
    }

    if (divId === 'currentMonthEnergyConsumption') {
        fetchEnergyConsumption(select, startDate, endDate)
            .done((data) => {
                const currentMonth = data[0] || { daily_consumption: 0 };

                let endDateMoment = moment(endDate);
                let endDateSub = endDateMoment.clone().subtract(1, 'day').format('YYYY-MM-DD HH:mm:ss');
                const totalEnergyConsumptionValue = document.getElementById('currentMonthEnergyConsumptionValue');
                createOdometer(totalEnergyConsumptionValue, (currentMonth.daily_consumption ?? 0).toLocaleString());

                $(`#${divId}StartDate`).html(formatDate(startDate));
                $(`#${divId}EndDate`).html(formatDate(endDateSub));

                const ghgMonth = Number((currentMonth.daily_consumption * 0.512).toFixed(2));
                $('#branchCarbonFootprintMonth').html(`${ghgMonth.toLocaleString()} <span>kg of CO2</span>`);
            })
            .fail((err) => console.log(err));
    }
};


const processCurrentDayEnergyConsumption = () => {
    const select = `
            ROUND(SUM((end_energy - start_energy)), 2) AS daily_consumption
        `;

    const doFetch = () => {
        const [startDate, endDate] = getStartEndDate(7, 1, 'day', 1);
        fetchDataNonCharts(select, startDate, endDate, 'currentDayEnergyConsumption');
    };

    setIntervalAtFiveMinuteMarks(doFetch);
    doFetch();
};

const processCurrentMonthEnergyConsumption = () => {
    const select = `
            ROUND(SUM((end_energy - start_energy)), 2) AS daily_consumption
        `;

    const doFetch = () => {
        const [startDate, endDate] = getStartEndDate(7, 25, 'month', 1);
        fetchDataNonCharts(select, startDate, endDate, 'currentMonthEnergyConsumption');
    };

    setIntervalAtFiveMinuteMarks(doFetch);
    doFetch();
};



const processCurrentMonthPerBranchEnergyConsumption = () => {
    const branches = JSON.parse(dashboardContext?.dataset.branches || '[]');
    if (!branches.length) return;

    const select = `ROUND(SUM((end_energy - start_energy)), 2) AS daily_consumption`;
    const tbody = document.getElementById('corporateMonthlyBranchTableBody');

    const fetchPerBranch = () => {
        const [startDate, endDate] = getStartEndDate(7, 25, 'month', 1);
        const endDateSub = moment(endDate).subtract(1, 'day').format('YYYY-MM-DD HH:mm:ss');
        $('#corporateMonthStartDate').text(formatDate(startDate));
        $('#corporateMonthEndDate').text(formatDate(endDateSub));
        const promises = branches.map(branch =>
            new Promise((resolve, reject) => {
                fetchEnergyConsumption(select, startDate, endDate, branch.id)
                    .done(data => resolve({ branch, data }))
                    .fail(err => reject(err));
            })
        );

        Promise.all(promises)
            .then(results => {
                if (!tbody) return;
                tbody.innerHTML = '';
                results.forEach(({ branch, data }) => {
                    const consumption = data[0]?.daily_consumption ?? 0;

                    const nameTd = document.createElement('td');
                    nameTd.className = 'branchname';
                    nameTd.textContent = branch.name;

                    const valueEl = document.createElement('span');
                    valueEl.textContent = '0';
                    const unitSpan = document.createElement('span');
                    unitSpan.textContent = ' kWh';
                    const valueTd = document.createElement('td');
                    valueTd.className = 'branchvalue';
                    valueTd.appendChild(valueEl);
                    valueTd.appendChild(unitSpan);

                    const tr = document.createElement('tr');
                    tr.appendChild(nameTd);
                    tr.appendChild(valueTd);
                    tbody.appendChild(tr);

                    createOdometer(valueEl, consumption);
                });

                const now = new Date();
                $('#corporateMonthLastUpdate').text(now.toLocaleDateString('en-US', {
                    year: 'numeric', month: 'short', day: 'numeric',
                    hour: '2-digit', minute: '2-digit'
                }));
            })
            .catch(err => console.log(err));
    };

    setIntervalAtFiveMinuteMarks(fetchPerBranch);
    fetchPerBranch();
};

processCurrentDayEnergyConsumption();
processCurrentMonthEnergyConsumption();
processCurrentMonthPerBranchEnergyConsumption();

const processCarbonFootprintPerBranch = () => {
    const branches = JSON.parse(dashboardContext?.dataset.branches || '[]');
    if (!branches.length) return;

    const select = `ROUND(SUM((end_energy - start_energy)), 2) AS daily_consumption`;
    const tbody = document.getElementById('corporateCarbonFootprintTableBody');

    const fetchAll = () => {
        const [dayStart, dayEnd] = getStartEndDate(7, 1, 'day', 1);
        const [monthStart, monthEnd] = getStartEndDate(7, 25, 'month', 1);
        const promises = branches.map(branch =>
            new Promise((resolve, reject) => {
                Promise.all([
                    fetchEnergyConsumption(select, dayStart, dayEnd, branch.id),
                    fetchEnergyConsumption(select, monthStart, monthEnd, branch.id),
                ])
                    .then(([dayData, monthData]) => resolve({ branch, dayData, monthData }))
                    .catch(err => reject(err));
            })
        );

        Promise.all(promises)
            .then(results => {
                if (!tbody) return;
                tbody.innerHTML = '';
                results.forEach(({ branch, dayData, monthData }) => {
                    const dayConsumption = Number((dayData[0]?.daily_consumption ?? 0) * 0.512);
                    const monthConsumption = Number((monthData[0]?.daily_consumption ?? 0) * 0.512);

                    const nameTd = document.createElement('td');
                    nameTd.className = 'branchname';
                    nameTd.textContent = branch.name;

                    const dayValueEl = document.createElement('span');
                    dayValueEl.textContent = '0';
                    const dayUnit = document.createElement('span');
                    dayUnit.textContent = ' kg of CO2';
                    const dayTd = document.createElement('td');
                    dayTd.className = 'branchvalue';
                    dayTd.appendChild(dayValueEl);
                    dayTd.appendChild(dayUnit);

                    const monthValueEl = document.createElement('span');
                    monthValueEl.textContent = '0';
                    const monthUnit = document.createElement('span');
                    monthUnit.textContent = ' kg of CO2';
                    const monthTd = document.createElement('td');
                    monthTd.className = 'branchvalue';
                    monthTd.appendChild(monthValueEl);
                    monthTd.appendChild(monthUnit);

                    const tr = document.createElement('tr');
                    tr.appendChild(nameTd);
                    tr.appendChild(dayTd);
                    tr.appendChild(monthTd);
                    tbody.appendChild(tr);

                    createOdometer(dayValueEl, Number(dayConsumption.toFixed(2)));
                    createOdometer(monthValueEl, Number(monthConsumption.toFixed(2)));
                });
            })
            .catch(err => console.log(err));
    };

    setIntervalAtFiveMinuteMarks(fetchAll);
    fetchAll();
};

processCarbonFootprintPerBranch();

