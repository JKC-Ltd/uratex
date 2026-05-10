<x-app-layout>
    <x-slot name="importedLinks">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.5/themes/odometer-theme-default.css" />
    </x-slot>
    <x-slot name="pageTitle">
        Energy Consumption
    </x-slot>
    <x-slot name="content">
        <!-- Main row -->
        <div id="energy-visibility-context" data-user-role="{{ $isAdmin ? 'Admin' : 'User' }}" data-branch-id="{{ $selectedBranchId ?? '' }}" hidden></div>

        <div class="row">
            @if ($isMultiBranch)
                <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('energyConsumption.index') }}">
                                <label class="form-label" for="branch_id">BRANCH</label>
                                <select class="form-control mb-4" id="branch_id" name="branch_id">
                                    <option value="">-- ALL BRANCHES --</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ (string) ($selectedBranchId ?? '') === (string) $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-12 {{ $isMultiBranch ? 'col-lg-9' : '' }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="energy-summary-box esb-border">
                                    <div class="energy-summary-icon">
                                        <i class="fa fa-calendar-day"></i>
                                    </div>
                                    <div class="energy-summary-details">
                                        <p class="energy-summary-title">Today's Energy Consumption</p>
                                        <p class="energy-summary-date" id="dailyEnergyConsumptionDate"></p>
                                        <h3 id="dailyEnergyConsumption">2,000</h3>
                                        <span>kWh / day</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="energy-summary-box esb-border">
                                    <div class="energy-summary-icon">
                                        <i class="fa fa-calendar-week"></i>
                                    </div>
                                    <div class="energy-summary-details">
                                        <p class="energy-summary-title">Weekly Energy Consumption</p>
                                        <p class="energy-summary-date" id="weeklyEnergyConsumptionDate"></p>
                                        <h3 id="weeklyEnergyConsumption">0</h3>
                                        <i>kWh / week</i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="energy-summary-box">
                                    <div class="energy-summary-icon">
                                        <i class="fa fa-calendar-alt"></i>
                                    </div>
                                    <div class="energy-summary-details">
                                        <p class="energy-summary-title">Monthly Consumption - Total Facility</p>
                                        <p class="energy-summary-date" id="monthlyEnergyConsumptionDate"></p>
                                        <h3 id="monthlyEnergyConsumption">0</h3>
                                        <i>kWh / month</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row summary-box">
            <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-white" style="border-bottom: 8px solid #f39800;">
                    <div class="inner">
                        <p>Daily kWh Consumption - Total Facility</p>
                        <p class="energy-consumption-date" id="dailyEnergyConsumptionDate"></p>
                        <h3 id="dailyEnergyConsumption">0</h3>
                        <i>kWh / day</i>
                    </div>
                    <div class="icon">
                        <i class="fa fa-calendar-day"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-white" style="border-bottom: 8px solid #f39800;">
                    <div class="inner">
                        <p>Weekly Consumption - Total Facility</p>
                        <p class="energy-consumption-date" id="weeklyEnergyConsumptionDate"></p>
                        <h3 id="weeklyEnergyConsumption">0</h3>
                        <i>kWh / week</i>
                    </div>
                    <div class="icon">
                        <i class="fa fa-calendar-week"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-white" style="border-bottom: 8px solid #f39800;">
                    <div class="inner">
                        <p>Monthly Consumption - Total Facility</p>
                        <p class="energy-consumption-date" id="monthlyEnergyConsumptionDate"></p>
                        <h3 id="monthlyEnergyConsumption">0</h3>
                        <i>kWh / month</i>
                    </div>
                    <div class="icon">
                        <i class="fa fa-calendar-alt"></i>
                    </div>
                </div>
            </div> --}}
            {{-- <section class="col col-lg-4 col-md-4 col-sm-12 connectedSortable">
                <div class="card">
                    <div class="card-body text-center">
                        <h6>Daily kWh Consumption - All Meters</h6>
                        <h1 >0</h1>
                        <i>kWh / day</i>
                    </div>
                </div>
            </section> --}}
            {{-- <section class="col col-lg-4 col-md-4 col-sm-12 connectedSortable">
                <div class="card">
                    <div class="card-body text-center">
                        <h6>Weekly Consumption - All Meters</h6>
                        <h1 id="weeklyEnergyConsumption">0</h1>
                        <i>kWh / week</i>
                    </div>
                </div>
            </section>
            <section class="col col-lg-4 col-md-4 col-sm-12 connectedSortable">
                <div class="card">
                    <div class="card-body text-center">
                        <h6>Monthly Consumption - All Meters</h6>
                        <h1 id="monthlyEnergyConsumption">0</h1>
                        <i>kWh / month</i>
                    </div>
                </div>
            </section> --}}
        {{-- </div> --}}



        <div class="row">
            <section class="col-12 connectedSortable">
                <div class="card">
                    <div class="card-body">
                        <div id="dailyEnergyConsumptionPerBuilding" style="height: 520px; width: 100%;"></div>
                    </div>
                </div>
            </section>
        </div>


        {{--
        <div class="row">
            <section class="col-12 connectedSortable">
                <div class="card">
                    <div class="card-body">
                        <div id="dailyEnergyConsumptionAllMeters" style="height: 520px; width: 100%;"></div>
                    </div>
                </div>
            </section>
        </div>
        --}}

    </x-slot>

    @section('scripts')
        <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
        <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.5/odometer.min.js"></script>
        <script type="module" src="{{ asset('assets/js/energyConsumptionNonCharts.js') }}?v={{ time() }}"></script>
        <script type="module" src="{{ asset('assets/js/energyConsumptionCharts.js') }}?v={{ time() }}"></script>
        <script type="module" src="{{ asset('assets/js/energyConsumptionChartsPerBuilding.js') }}?v={{ time() }}">
        </script>
    @endsection
</x-app-layout>
