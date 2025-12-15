<x-app-layout>
    <x-slot name="pageTitle">
        Dashboard
    </x-slot>
    <x-slot name="content">
        <div class="row">
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
                        <p>Users</p>
                        <h3>{{ $users->count() }}</h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main row -->
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            COST ESTIMATED
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="energyComparisonPerDayDoughnut" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            CHANGE IN COST
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="energyComparisonPerDayColumn" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            USAGE ESTIMATE
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="usageEstimate" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            COST ESTIMATED
                        </h3>
                    </div>
                    <div class="card-body">
                        <section class="col-12 connectedSortable">
                            <div id="dailyEnergyConsumptionPerMeter" style="height: 370px; width: 100%;"></div>
                        </section>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            CHANGE IN COST
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row" style="height: 370px; width: 100%;">
                            @foreach ($sensors as $sensor)
                                <div class="col">
                                    <div class="info-box bg-primary">
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ $sensor->description }}</span>
                                            <span class="info-box-number" id="info-box-{{ $sensor->id }}"></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            CARBON FOOTPRINT
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row" style="height: 370px; width: 100%;">

                            <div class="col-md-12">
                                <h5>Emission</h5>
                                <div class="progress" role="progressbar" aria-label="Example with label"
                                    aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: 90%">90%</div>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <h5>Green Energy Generated</h5>
                                <div class="progress" role="progressbar" aria-label="Example with label"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: 25%">25%</div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h5>Green Energy Generated</h5>
                                <div class="progress" role="progressbar" aria-label="Example with label"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: 25%">25%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </x-slot>
    <x-slot name="importedScripts">
        <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
        <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
    </x-slot>
</x-app-layout>
