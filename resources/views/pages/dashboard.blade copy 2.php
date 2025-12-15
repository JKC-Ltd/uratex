<x-app-layout>
    <x-slot name="importedLinks">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.5/themes/odometer-theme-default.css"/>
    </x-slot>
    <x-slot name="pageTitle">
        Dashboard
    </x-slot>
    <x-slot name="content">
        <div class="row summary-box">
            <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-white" style="border-bottom: 8px solid #f39800;">
                    <div class="inner">
                        <p>Gateways</p>
                        <h3>{{ $gateways->count() }}</h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-hdd"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-white" style="border-bottom: 8px solid #f39800;">
                    <div class="inner">
                        <p>Sensors</p>
                        <h3>{{ $sensors->count() }}</h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-tablet"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-white" style="border-bottom: 8px solid #f39800;">
                    <div class="inner">
                        <p>Areas with Sensors</p>
                        <h3>{{ $area->count() }}</h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-location"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main row -->
        <div class="row dashboard-card">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Building 1 - Total Energy Consumption
                        </h3>
                    </div>
                    <div class="card-body energy-bg">
                        <div id="buildingOneTotalEnergyConsumption"
                            class="card-box d-flex flex-column justify-content-center align-items-center ">
                            <h1 id="buildingOneTotalEnergyConsumptionValue" class="dashboard-value">0 </h1>
                            <h6>kWh</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Building 2 - Total Energy Consumption
                        </h3>
                    </div>
                    <div class="card-body energy-bg">
                        <div id="buildingTwoTotalEnergyConsumption"
                            class="card-box d-flex flex-column justify-content-center align-items-center ">
                            <h1 id="buildingTwoTotalEnergyConsumptionValue" class="dashboard-value">0 </h1>
                            <h6>kWh</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Total Facility Energy Consumption
                        </h3>
                    </div>
                    <div class="card-body energy-bg">
                        <div id="totalEnergyConsumption"
                            class="card-box d-flex flex-column justify-content-center align-items-center ">
                            <h1 id="totalEnergyConsumptionValue" class="dashboard-value">0 </h1>
                            <h6>kWh</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-plug mr-1"></i>
                            Previous & Present Energy Consumption - MDP
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="pandpEnergyConsumption" class="card-box"></div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Current Month Energy Consumption
                        </h3>
                    </div>
                    <div class="card-body energy-bg">
                        <div id="currentMonthEnergyConsumption" class="card-box">
                            <div class="currentMonthEnergy">
                                <h1 id="currentMonthEnergyConsumptionValue" class="dashboard-value">0 </h1>
                                <h6>kWh</h6>
                            </div>
                            <div class="currentMonthDate">
                                <h4 class="mb-0"> <i class="fas fa-calendar-alt mr-3"></i><span
                                        id="currentMonthEnergyConsumptionStartDate"> </span> -
                                    <span id="currentMonthEnergyConsumptionEndDate"></span>
                                </h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row dashboard-card">

            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Building 3 - Total Energy Consumption
                        </h3>
                    </div>
                    <div class="card-body energy-bg">
                        <div id="buildingThreeTotalEnergyConsumption"
                            class="card-box d-flex flex-column justify-content-center align-items-center ">
                            <h1 id="buildingThreeTotalEnergyConsumptionValue" class="dashboard-value">0 </h1>
                            <h6>kWh</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Total Building Energy Consumption
                        </h3>
                    </div>
                    <div class="card-body energy-bg">
                        <div id="totalEnergyConsumption"
                            class="card-box d-flex flex-column justify-content-center align-items-center ">
                            <h1 id="totalBuildingEnergyConsumptionValue" class="dashboard-value">0 </h1>
                            <h6>kWh</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fa fa-chart-bar mr-1"></i>
                            Daily Energy Consumption Per Meter
                        </h3>
                    </div>
                    <div class="card-body">
                        <section class="col-12 connectedSortable">
                            <div id="dailyEnergyConsumptionPerMeter" class="card-box"></div>
                        </section>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-search-location mr-1"></i>
                            Energy Consumption Per Area
                        </h3>
                    </div>
                    <div class="card-body">
                        <section class="col-12 connectedSortable">
                            <div class="row card-box">
                                @foreach ($area as $sensor)
                                    <div class="col-xl-6 col-lg-12 col-md-12">
                                        <div class="info-box bg-area">
                                            <div class="info-box-content">
                                                <span
                                                    class="info-box-text">{{ $sensor->location->location_name }}</span>
                                                <span class="info-box-number"
                                                    id="energyConsumptionPerArea{{ $sensor->location->id }}"
                                                    data-id="{{ $sensor->location->id }}"></span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-broadcast-tower mr-1"></i>
                            Carbon Footprint
                        </h3>
                    </div>
                    <div class="card-body ">
                        <section class="col-12 connectedSortable">
                            <div class="card-box ghg">
                                <div>
                                    <div class="col-md-12 ghgday">
                                        <h5>GHG Emission (kg of CO2) - Current Day</h5>
                                        <h4 id="ghgCurrentDayValue">0 kWh</h4>
                                        <div class="progress " role="progressbar" aria-label="Example with label"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                            style="height: 50px;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                id="ghgCurrentDay" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ghgmonth">
                                        <h5>GHG Emission (kg of CO2) - Current Month</h5>
                                        <h4 id="ghgCurrentMonthValue">0 kWh</h4>
                                        <div class="progress " role="progressbar" aria-label="Example with label"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
                                            style="height: 50px;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                id="ghgCurrentMonth" style="width: 0%"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @section('scripts')
        <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
        <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.5/odometer.min.js"></script>
        <script type="module" src="{{ asset('assets/js/dashboard.js') }}?v={{ time() }}"></script>
        <script type="module" src="{{ asset('assets/js/dashboardv2.js') }}?v={{ time() }}"></script>
    @endsection
</x-app-layout>
