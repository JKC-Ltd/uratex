<x-app-layout>
    <x-slot name="importedLinks">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.5/themes/odometer-theme-default.css" />
    </x-slot>
    <x-slot name="pageTitle">
        Dashboard
    </x-slot>
    <x-slot name="content">
        <div class="row dashboard-corporate-card">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <div class="row">
                            <div class="col-8">
                                <div class="card-title d-flex align-items-center">
                                    <i class="fas fa-bolt card-icon-title mr-1"></i>
                                    <div class="ml-2">
                                        <h1>
                                            Current Month's Energy Consumption
                                        </h1>
                                        <p class="mb-0">kWh consumed per branch</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-end">
                                <div class="currentMonthDate">
                                    <h5 class="mb-0"><i class="fas fa-calendar-alt m-1"></i> <span>Mar 05, 2026</span>
                                        - <span>Apr 05, 2026</span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-primary dashboard-alert" role="alert">
                            <i class="fa fa-info dashboard-alert-icon"></i> Last update: <b>Apr 1, 2026 10:00 AM</b>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>BRANCH</th>
                                    <th>ENERGY USAGE (kWh)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="branchname">Uratex Valenzuela</td>
                                    <td class="branchvalue">2,000,000 <span>kWh</span></td>
                                </tr>
                                <tr>
                                    <td class="branchname">Uratex Alabang</td>
                                    <td class="branchvalue">3,000 <span>kWh</span></td>
                                </tr>
                                <tr>
                                    <td class="branchname">Uratex Plaridel</td>
                                    <td class="branchvalue">4,000 <span>kWh</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <div class="card-title d-flex align-items-center">
                            <i class="fa fa-chart-bar card-icon-title mr-1"></i>
                            <div class="ml-2">
                                <h1>
                                    Daily Energy Consumption
                                </h1>
                                <p class="mb-0">kWh consumed per branch</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <section class="col-12 connectedSortable">
                            <div id="dailyEnergyConsumptionPerMeter" class="card-box"></div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <div class="row dashboard-corporate-card">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <div class="card-title d-flex align-items-center">
                            <i class="fa fa-chart-bar card-icon-title mr-1"></i>
                            <div class="ml-2">
                                <h1>
                                    Previous and Present Energy Days' Consumption
                                </h1>
                                <p class="mb-0">kWh consumed per branch</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <section class="col-12 connectedSortable">
                            <div id="pAndPEnergyConsumptionPerBuilding" class="card-box"></div>
                        </section>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <div class="card-title d-flex align-items-center">
                            <i class="fa fa-leaf card-icon-title mr-1"></i>
                            <div class="ml-2">
                                <h1>
                                    Carbon Footprint
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table>
                            <thead>
                                <tr>
                                    <th>BRANCH</th>
                                    <th>GHG Emission (kg of CO2) - Current Day</th>
                                    <th>GHG Emission (kg of CO2) - Current Month</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="branchname">Uratex Valenzuela</td>
                                    <td class="branchvalue">2,000,000 <span>kWh</span></td>
                                    <td class="branchvalue">2,000,000 <span>kWh</span></td>
                                </tr>
                                <tr>
                                    <td class="branchname">Uratex Alabang</td>
                                    <td class="branchvalue">3,000 <span>kWh</span></td>
                                    <td class="branchvalue">3,000 <span>kWh</span></td>
                                </tr>
                                <tr>
                                    <td class="branchname">Uratex Plaridel</td>
                                    <td class="branchvalue">4,000 <span>kWh</span></td>
                                    <td class="branchvalue">4,000 <span>kWh</span></td>
                                </tr>
                            </tbody>
                        </table>
                        {{-- <section class="col-12 connectedSortable">
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
                        </section> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row dashboard-branch-card">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <div class="card-title d-flex align-items-center">
                            <i class="fa fa-bolt card-icon-title mr-1"></i>
                            <div class="ml-2">
                                <h1>
                                    Today's Energy Consumption
                                </h1>
                                <p class="mb-0">Apr 16, 2026</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="energy-value">
                            <h1>40,000</h1>
                            <p>kWH</p>
                        </div>
                        <div class="alert alert-primary dashboard-alert" role="alert">
                            <i class="fa fa-info dashboard-alert-icon"></i> Last update: <b>Apr 16, 2026 10:00 AM</b>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <div class="card-title d-flex align-items-center">
                            <i class="fa fa-bolt card-icon-title mr-1"></i>
                            <div class="ml-2">
                                <h1>
                                    Current Month's Energy Consumption
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="energy-value">
                            <h1>1,000,000</h1>
                            <p>kWH</p>
                        </div>
                        <div class="alert alert-primary dashboard-alert" role="alert">
                            <i class="fa fa-info dashboard-alert-icon"></i> Date: <b><span>Mar 16, 2026</span> -
                                <span>Apr 16, 2026</span></b>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <div class="card-title d-flex align-items-center">
                            <i class="fa fa-leaf card-icon-title mr-1"></i>
                            <div class="ml-2">
                                <h1>
                                    Carbon Footprint
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="carbon-footprint-value">
                            <div class="carbon-footprint-head">
                                <p>Current Day</p>
                            </div>
                            <h1>4,000 <span>kg of CO2</span></h1>
                            
                        </div>
                        <div class="carbon-footprint-value">
                            <div class="carbon-footprint-head">
                                <p>Current Month</p>
                            </div>
                            <h1>4,000 <span>kg of CO2</span></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <div class="card-title d-flex align-items-center">
                            <i class="fa fa-chart-bar card-icon-title mr-1"></i>
                            <div class="ml-2">
                                <h1>
                                    Previous and Present Energy Days' Consumption
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-5" style="border-right: 1px solid #f1f1f1">
                                <div id="pandpEnergyConsumption" class="card-box"></div>
                            </div>
                            <div class="col-12 col-lg-7">
                                <section class="col-12 connectedSortable">
                                    <div id="pAndPEnergyConsumptionPerBuilding" class="card-box"></div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <div class="card-title d-flex align-items-center">
                            <i class="fa fa-chart-bar card-icon-title mr-1"></i>
                            <div class="ml-2">
                                <h1>
                                    Daily Energy Consumption
                                </h1>
                                <p class="mb-0">kWh consumed per building</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <section class="col-12 connectedSortable">
                            <div id="dailyEnergyConsumptionPerMeter" class="card-box"></div>
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
        <script type="module" src="{{ asset('assets/js/dashboardNonCharts.js') }}?v={{ time() }}"></script>
        <script type="module" src="{{ asset('assets/js/dashboardCharts.js') }}?v={{ time() }}"></script>
    @endsection
</x-app-layout>
