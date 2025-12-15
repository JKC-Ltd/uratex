import { getStartEndDate } from "../../../assets/js/dashboardUtils.js?v=1.4";

document.addEventListener("DOMContentLoaded", function () {

    var linkIcon = `<svg fill="none" width="24" height="24" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev/svgjs"><g width="100%" height="100%" transform="matrix(1,0,0,1,0,0)"><g clip-rule="evenodd" fill="rgb(0,0,0)" fill-rule="evenodd"><path d="m19.8876 4.64899c-.7494-.74943-1.9645-.74943-2.7139 0-.2929.2929-.7678.2929-1.0607 0-.2928-.29289-.2929-.76776 0-1.06066 1.3353-1.33522 3.5001-1.33522 4.8353 0 1.3352 1.33523 1.3352 3.50005 0 4.83528l-2.3591 2.35909c-1.2747 1.2747-3.3047 1.3325-4.6485.1735-.3137-.2705-.3487-.7441-.0782-1.05776.2705-.31368.7441-.34866 1.0578-.07814.7534.6497 1.8931.6169 2.6082-.09822l2.3591-2.35913c.7495-.74944.7495-1.96452 0-2.71396zm-3.4085 3.20454c-.7533-.64972-1.8931-.61688-2.6082.09821l-2.3591 2.35916c-.7495.7494-.7495 1.9645 0 2.7139.7494.7495 1.9645.7495 2.7139 0 .2929-.2929.7678-.2929 1.0607 0s.2929.7678 0 1.0607c-1.3352 1.3352-3.5001 1.3352-4.8353 0s-1.3352-3.5001 0-4.83528l2.3591-2.35913c1.2747-1.27469 3.3047-1.33242 4.6486-.17348.3136.27052.3486.74411.0781 1.05778-.2705.31368-.7441.34866-1.0578.07814z" fill="#ffffff" fill-opacity="1" data-original-color="#000000ff" stroke="none" stroke-opacity="1"/><path d="m11.1433 2.58691h.0564c.4142 0 .75.33579.75.75 0 .41422-.3358.75-.75.75-1.90681 0-3.26148.0016-4.28914.13976-1.00609.13527-1.58574.38894-2.00895.81215s-.67688 1.00285-.81214 2.00894c-.13817 1.02767-.13976 2.38233-.13976 4.28914v2c0 1.9068.00159 3.2615.13976 4.2892.13526 1.0061.38893 1.5857.81214 2.0089s1.00286.6769 2.00895.8122c1.02766.1381 2.38233.1397 4.28914.1397h2c1.9068 0 3.2615-.0016 4.2892-.1397 1.006-.1353 1.5857-.389 2.0089-.8122s.6769-1.0028.8121-2.0089c.1382-1.0277.1398-2.3824.1398-4.2892 0-.4142.3358-.75.75-.75s.75.3358.75.75v.0564c0 1.8378 0 3.2934-.1531 4.4326-.1577 1.1725-.4898 2.1214-1.2381 2.8698-.7484.7483-1.6973 1.0805-2.8698 1.2381-1.1392.1531-2.5948.1531-4.4326.1531h-2.1128c-1.83777 0-3.2934 0-4.43262-.1531-1.17242-.1576-2.12137-.4898-2.86973-1.2381-.74836-.7484-1.08048-1.6973-1.23811-2.8698-.15316-1.1392-.15315-2.5948-.15313-4.4326v-2.1128c-.00002-1.83776-.00003-3.29339.15313-4.43261.15763-1.17242.48975-2.12137 1.23811-2.86973.74836-.74837 1.69731-1.08048 2.86973-1.23811 1.13922-.15316 2.59485-.15315 4.43262-.15314z" fill="#ffffff" fill-opacity="1" data-original-color="#000000ff" stroke="none" stroke-opacity="1"/></g></g></svg>`;

    OrgChart.RES.IT_IS_LONELY_HERE_LINK = "Add a location or sensor";
    // LOCATION TEMPLATE
    OrgChart.templates.locationTemplate = Object.assign({}, OrgChart.templates.ana);
    OrgChart.templates.locationTemplate.size = [300, 80];
    OrgChart.templates.locationTemplate.node = `<rect x="0" y="0" height="80" width="300" fill="#184aa1" rx="15" ry="15"></rect>
        <circle cx="35" cy="40" r="47" fill="#d1d2d4" stroke="#fff" stroke-width="5"></circle>
        <clipPath id="{randId}"><circle cx="35" cy="40" r="46"></circle></clipPath>
        <image preserveAspectRatio="xMidYMid slice" clip-path="url(#{randId})" xlink:href="/assets/images/location-icon.png" x="-15" y="-10"  width="100" height="100"></image>`;
    OrgChart.templates.locationTemplate.field_0 = `<text width="210" class="field_0" style="font-size: 20px;" data-text-overflow="multiline" font-weight="bold" fill="#fff" x="170" y="45" text-anchor="middle">{val}</text>`;
    // SENSOR TEMPLATE
    OrgChart.templates.sensorTemplate = Object.assign({}, OrgChart.templates.ana);
    OrgChart.templates.sensorTemplate.size = [300, 80];
    OrgChart.templates.sensorTemplate.node = `<rect x="0" y="0" height="80" width="300" fill="#f39800" rx="15" ry="15"></rect>
            <circle cx="35" cy="40" r="47" fill="#d1d2d4" stroke="#fff" stroke-width="5"></circle>
            <clipPath id="{randId}"><circle cx="35" cy="40" r="46"></circle></clipPath>
            <image preserveAspectRatio="xMidYMid slice" clip-path="url(#{randId})" xlink:href="/assets/images/sensor-icon.png" x="-15" y="-10"  width="100" height="100"></image>`;
    OrgChart.templates.sensorTemplate.field_0 = `<text width="210" class="field_0" style="font-size: 20px;" font-weight="bold" fill="#fff" x="170" y="45" text-anchor="middle">{val}</text>`;

    //BUILDING TEMPLATE
    OrgChart.templates.buildingTemplate = Object.assign({}, OrgChart.templates.ana);
    OrgChart.templates.buildingTemplate.size = [300, 80];
    OrgChart.templates.buildingTemplate.node = `<rect x="0" y="0" height="80" width="300" fill="#FF6F1E" rx="15" ry="15"></rect>
            <circle cx="35" cy="40" r="47" fill="#d1d2d4" stroke="#fff" stroke-width="5"></circle>
            <clipPath id="{randId}"><circle cx="35" cy="40" r="46"></circle></clipPath>
            <image preserveAspectRatio="xMidYMid slice" clip-path="url(#{randId})" xlink:href="/assets/images/sensor-icon.png" x="-15" y="-10"  width="100" height="100"></image>`;
    OrgChart.templates.buildingTemplate.field_0 = `<text width="210" class="field_0" style="font-size: 20px;" font-weight="bold" fill="#fff" x="170" y="45" text-anchor="middle">{val}</text>`;


    let chart = new OrgChart(document.getElementById("tree"), {
        enableSearch: true,
        // miniMap: true,
        layout: OrgChart.tree,
        orientation: OrgChart.orientation.left,
        align: OrgChart.ORIENTATION,
        scaleInitial: OrgChart.match.boundary,
        editForm: {
            elements: [
                { type: 'textbox', label: 'Sensor', binding: 'name' },
                { type: 'textbox', label: 'Active Power (kW)', binding: 'real_power' },
                { type: 'textbox', label: 'Daily Energy Consumption (kWh)', binding: 'daily_consumption' },
                { type: 'textbox', label: 'Sensor Brand', binding: 'sensor_brand' },
            ],
            photoBinding: null,
            buttons: {
                // map: {
                //     icon: linkIcon,
                //     text: 'Map'
                // },
                share: null,
                edit: null,
                remove: null,
                pdf: null
            },
            photoBinding: null,

        },
        toolbar: {
            layout: false,
            zoom: true,
            fit: true,
            expandAll: true,
        },
        tags: {
            Location: {
                template: "locationTemplate",
            },
            Sensor: {
                template: "sensorTemplate",
            },
            Building: {
                template: "buildingTemplate",
            },
        },
        nodeBinding: {
            field_0: "name"
        },
    });

    // chart.editUI.on('button-click', function (sender, args) {
    //     console.log("Button clicked");
    //     let nodeId = args.nodeId;
    //     let node = chart.get(nodeId);

    //     if (node) {

    //         $.ajax({
    //             url: "/getSensor",
    //             type: "GET",
    //             data: {
    //                 name: node.name,
    //                 slave_address: node.slave_address,
    //                 gateway_id: node.gateway_id,
    //             },
    //             success: function (sensor) {
    //                 window.open(`/locationDashboard/${sensor.id}`, "_self");
    //             },
    //         });
    //     } else {
    //         console.log("Node not found with ID:", nodeId);
    //     }
    //     // window.open('/dashboard', "_self");

    // });


    let chartLayout = [];

    function updateChartLayout(data, isSensor = false, ctr = 0) {
        if (isSensor) {
            data.forEach((sensor) => {
                delete sensor.sensor_brand;
                // Don't modify building IDs 6, 7, 8 so child locations can reference them as parents
                if (![2, 6, 7, 8].includes(sensor.id)) {
                    sensor.id = sensor.id + (Math.random() * 99).toFixed(2);
                }
                chartLayout.push(sensor);
                ctr++;
            });
        } else {
            data.forEach((location, key) => {
                chartLayout.push(location);
            });
        }

        console.log(chartLayout);
    }

    function fetchData(url, data = null) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: url,
                type: "GET",
                data: data,
                success: function (data) {
                    resolve(data);
                },
                error: function (error) {
                    reject(error);
                }
            });
        });
    }

    const [startDate, endDate] = getStartEndDate(7, 1, 'day', 1);
    const locationRequest = {
        select: "sensor_id, real_power, ROUND((end_energy - start_energy), 2) AS daily_consumption",
        startDate: startDate,
        endDate: endDate
    };

    Promise.all([
        fetchData("/getLocationChart"),
        fetchData("/getSensorChart", locationRequest),
    ])
        .then(([locationData, sensorData]) => {
            updateChartLayout(locationData);
            let ctr = locationData.length + 1;

            updateChartLayout(sensorData, true, ctr);
            chart.load([]);
            chart.load(chartLayout);
        })
        .catch((error) => {
            console.error("Error loading data:", error);
        });

    chart.onNodeClick((args) => {
        return args.node.templateName === 'sensorTemplate' || args.node.templateName === 'buildingTemplate' ? true : false;
    });

});
