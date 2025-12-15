$(document).ready(function () {
    var sensorModelId = $("#sensor-reg-address").data("sensor-model");
    if (sensorModelId) {
        var sensorTypeId = $("#sensor_type").val();
        loadSensorModel(sensorModelId, sensorTypeId);
        loadSensorDetails(sensorTypeId);

        $("#sensor_type").on("change", function () {
            sensorTypeId = $(this).val();
            if (sensorTypeId) {
                loadSensorModel(sensorModelId, sensorTypeId);
                loadSensorDetails(sensorTypeId);
            } 

        });
    } else {
        $("#sensor_type").on("change", function () {
            sensorTypeId = $(this).val();
            if (sensorTypeId) {
                loadSensorParameters(sensorTypeId);
                loadSensorDetails(sensorTypeId);
            } 
        });
    }
    
});

function loadSensorDetails (sensorTypeId) {
    $.ajax({
        url: '/getSensorType/' + sensorTypeId,
        method: 'GET',
        success: function(response) {
            $('#sensor_details').show();
            
            $('#sensor_code').text(response.sensor_type_code);
            $('#sensor_description').text(response.description);

            var parameters = response.sensor_type_parameter.split(",");
            var htmlContent = "";

            parameters.forEach(param=> {
                param = param.trim();
                htmlContent += `<span class="badge badge-primary">${param}</span>`;
            });

            $("#sensor_parameters").html(htmlContent);
         
        },
        error: function () {
            alert("Error fetching sensor data.");
        },
    });

}

function loadSensorModel(sensorModelId, sensorTypeId){
    $.ajax({
        url: "/getSensorModel/" + sensorModelId,
        method: "GET",
        success: function (response) {
            var sensorRegAddress;
            if (sensorTypeId == response.sensor_type.id) {
                sensorRegAddress = response.sensor_model.sensor_reg_address;
            } else {
                sensorRegAddress = "";
            }
            sensorTypeId = sensorTypeId || response.sensor_type.id;    
            loadSensorParameters(sensorTypeId, sensorRegAddress);
        },
        error: function () {
            alert("Error fetching sensor data.");
        },
    });
}

function loadSensorParameters(sensorTypeId, sensorRegAddress) {
    $.ajax({
        url: "/getSensorType/" + sensorTypeId,
        method: "GET",
        success: function (response) {
            var parameters = response.sensor_type_parameter.split(",");
            var regAddress = (sensorRegAddress && sensorRegAddress.length > 0) ? sensorRegAddress.split(",") : [];

            var htmlContent = "";

            parameters.forEach(function (parameter, index) {
                var value = regAddress[index] || '';

                htmlContent += `
                <div class="form-group row">
                    <label for=${parameter} class="col-sm-5 col-form-label">${parameter.replace(/_/g, " ").toUpperCase()}</label>
                    <div class="col-sm-7">
                    <input type="text" id=${parameter} name="sensor_reg_address[]" class="form-control" value="${value}"/>
                    </div>
                </div>
                
                `;
            });

            $("#sensor-reg-address").html(htmlContent);
        },
        error: function () {
            alert("Error fetching sensor data.");
        },
    });
}
