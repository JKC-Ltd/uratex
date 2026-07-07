<x-app-layout>
    <x-slot name="importedLinks">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.5/themes/odometer-theme-default.css" />
    </x-slot>
    <x-slot name="pageTitle">
        Dashboard
    </x-slot>
    <x-slot name="content">
        <div id="energy-visibility-context"
             data-user-role="{{ $isAdmin ? 'Admin' : 'User' }}"
            data-branch-id="{{ $selectedBranchId ?? '' }}"
            data-branches="{{ $branches->toJson() }}"
            hidden></div>

        {{-- Branch filter (admin or multi-branch users) --}}
        @if($isMultiBranch)
        <div class="row mb-3">
            <div class="col-12">
                <div class="card mb-0">
                    <div class="card-body py-2">
                        <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-items-center flex-wrap" style="gap: 10px;">
                            <label class="form-label mb-0 font-weight-bold">BRANCH</label>
                            <select class="form-control" name="branch_id" style="max-width: 260px;">
                                <option value="">-- ALL BRANCHES --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ (string)($selectedBranchId ?? '') === (string)$branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($isMultiBranch)
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
                                    <h5 class="mb-0"><i class="fas fa-calendar-alt m-1"></i> <span id="corporateMonthStartDate">-</span>
                                        - <span id="corporateMonthEndDate">-</span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-primary dashboard-alert" role="alert">
                            <i class="fa fa-info dashboard-alert-icon"></i> Last update: <b id="corporateMonthLastUpdate">-</b>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>BRANCH</th>
                                    <th>ENERGY USAGE (kWh)</th>
                                </tr>
                            </thead>
                            <tbody id="corporateMonthlyBranchTableBody">
                                {{-- populated dynamically by JS for admin --}}
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
                            <tbody id="corporateCarbonFootprintTableBody">
                                {{-- populated dynamically by JS --}}
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
        @endif

        @if(!$isMultiBranch)
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
                                <p class="mb-0" id="currentDayEnergyConsumptionDate">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="energy-value">
                            <h1 id="currentDayEnergyConsumptionValue">0</h1>
                            <p>kWH</p>
                        </div>
                        <div class="alert alert-primary dashboard-alert" role="alert">
                            <i class="fa fa-info dashboard-alert-icon"></i> Last update: <b id="currentDayEnergyConsumptionLastUpdate">-</b>
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
                            <h1 id="currentMonthEnergyConsumptionValue">0</h1>
                            <p>kWH</p>
                        </div>
                        <div class="alert alert-primary dashboard-alert" role="alert">
                            <i class="fa fa-info dashboard-alert-icon"></i> Date: <b><span id="currentMonthEnergyConsumptionStartDate">-</span> -
                                <span id="currentMonthEnergyConsumptionEndDate">-</span></b>
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
                            <h1 id="branchCarbonFootprintDay">- <span>kg of CO2</span></h1>
                        </div>
                        <div class="carbon-footprint-value">
                            <div class="carbon-footprint-head">
                                <p>Current Month</p>
                            </div>
                            <h1 id="branchCarbonFootprintMonth">- <span>kg of CO2</span></h1>
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
                        <div id="pandpEnergyConsumption" class="card-box"></div>
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
                                <p class="mb-0">kWh consumed per sensor</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <section class="col-12 connectedSortable">
                            <div id="dailyEnergyConsumptionPerBuilding" style="height: 520px; width: 100%;"></div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </x-slot>
    @section('scripts')
        <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
        <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.5/odometer.min.js"></script>
        <script type="module" src="{{ asset('assets/js/dashboardNonCharts.js') }}?v={{ time() }}"></script>
        <script type="module" src="{{ asset('assets/js/dashboardCharts.js') }}?v={{ time() }}"></script>
        @if(!$isMultiBranch)
        <script type="module" src="{{ asset('assets/js/energyConsumptionChartsPerBuilding.js') }}?v={{ time() }}"></script>
        @endif
    @endsection
</x-app-layout>
