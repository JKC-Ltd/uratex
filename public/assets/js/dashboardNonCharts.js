import { createOdometer, formatDate, setIntervalAtFiveMinuteMarks, getStartEndDate } from './dashboardUtils.js?v=10';

const DEFAULT_WHERE_IN = [
    {
        field: 'sensor_id',
        value: [15, 19],
    },
];

const fetchEnergyConsumption = (select, startDate, endDate, whereIn = DEFAULT_WHERE_IN) => {
    return $.ajax({
        type: 'GET',
        url: '/getEnergyConsumption',
        data: {
            select,
            startDate,
            endDate,
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

                $('#ghgCurrentDayValue').html(`${Number((currentDay.daily_consumption * 0.512).toFixed(2)).toLocaleString()} kWh`);
                $('#ghgCurrentDay').css('width', (currentDay.daily_consumption * 0.512).toFixed(2));
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

                $('#ghgCurrentMonthValue').html(`${Number((currentMonth.daily_consumption * 0.512).toFixed(2)).toLocaleString()} kWh`);
                $('#ghgCurrentMonth').css('width', (currentMonth.daily_consumption * 0.512).toFixed(2));
            })
            .fail((err) => console.log(err));
    }
};


const processCurrentDayEnergyConsumption = () => {
    const select = `
            ROUND(SUM((end_energy - start_energy)), 2) AS daily_consumption
        `;

    const [startDate, endDate] = getStartEndDate(7, 1, 'day', 1);

    setIntervalAtFiveMinuteMarks(function () {
        fetchDataNonCharts(select, startDate, endDate, "currentDayEnergyConsumption");
    });

    fetchDataNonCharts(select, startDate, endDate, "currentDayEnergyConsumption");
};

const processCurrentMonthEnergyConsumption = () => {
    const select = `
            ROUND(SUM((end_energy - start_energy)), 2) AS daily_consumption
        `;

    const [startDate, endDate] = getStartEndDate(7, 25, 'month', 1);

    setIntervalAtFiveMinuteMarks(function () {
        fetchDataNonCharts(select, startDate, endDate, "currentMonthEnergyConsumption");
    });

    fetchDataNonCharts(select, startDate, endDate, "currentMonthEnergyConsumption");
};



processCurrentDayEnergyConsumption();
processCurrentMonthEnergyConsumption();

