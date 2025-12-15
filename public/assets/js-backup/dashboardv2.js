import { getStartEndDate, createOdometer, setIntervalAtFiveMinuteMarks } from "./shared/main.js?v=1.5";

const fetchDataNoneCharts = (select, startDate, endDate, divID, divDate) => {

    $.ajax({
        type: "GET",
        url: "/getEnergyConsumptionPerBuilding",
        data: {
            select: select,
            roots: [6, 7, 8],
            startDate: startDate,
            endDate: endDate,
        },
        success: function (data) {
            let totalValue = {};
            let totalValueId = document.getElementById(`totalBuildingEnergyConsumptionValue`);
            const totalValueB1 = data.filter(item => item.root_location_id === 6).reduce((total, item) => total + item.daily_consumption, 0);
            const totalValueB2 = data.filter(item => item.root_location_id === 7).reduce((total, item) => total + item.daily_consumption, 0);
            const totalValueB3 = data.filter(item => item.root_location_id === 8).reduce((total, item) => total + item.daily_consumption, 0);
            totalValue[divID] = totalValueB1 + totalValueB2 + totalValueB3;

            createOdometer(totalValueId, totalValue[divID].toLocaleString());
            createOdometer(document.getElementById(`buildingOneTotalEnergyConsumptionValue`), totalValueB1.toLocaleString());
            createOdometer(document.getElementById(`buildingTwoTotalEnergyConsumptionValue`), totalValueB2.toLocaleString());
            createOdometer(document.getElementById(`buildingThreeTotalEnergyConsumptionValue`), totalValueB3.toLocaleString());

        },
        error: function (error) {
            console.log(error);
        }
    })

};

const processDailyEnergyConsumption = () => {
    let select = "*, ROUND((end_energy - start_energy), 2) AS daily_consumption";

    const [startDate, endDate] = getStartEndDate(7, 1, 'day', 1);


    setIntervalAtFiveMinuteMarks(function () {
        console.log("refetching...");
        fetchDataNoneCharts(select, startDate, endDate, "totalEnergyConsumption", "dailyEnergyConsumptionDate");
    });

    // Initial fetch
    fetchDataNoneCharts(select, startDate, endDate, "totalEnergyConsumption", "dailyEnergyConsumptionDate");
};

processDailyEnergyConsumption();