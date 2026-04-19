<x-app-layout>
    <x-slot name="pageTitle">
        Voltage & Current Profile
    </x-slot>
    <x-slot name="content">
        {{-- NEW LAYOUT --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">BRANCH</label>
                                <select class="form-control">
                                    <option value="">-- SELECT BRANCH --</option>
                                    <option value="2">Valenzuela</option>
                                    <option value="3">Plaridel</option>
                                    <option value="3">Alabang</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">SENSOR</label>
                                <select class="form-control">
                                    <option value="">-- SELECT SENSOR --</option>
                                    <option value="1">MDP 1</option>
                                    <option value="2">MDP 2</option>
                                    <option value="3">MDP 3</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end px-4" style="border-right: 1px solid #f1f1f1">
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </div>
                            <div class="col-md-4 d-flex align-items-end pl-4">
                                <div class="alert alert-primary dashboard-alert w-100 mb-0" role="alert">
                                    <i class="fa fa-info dashboard-alert-icon"></i> Last update: <b>Apr 1, 2026 10:00
                                        AM</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9" style="border-right: 1px solid #f1f1f1">
                                <label class="form-label">SELECT SENSOR</label>
                                <ul class="nav nav-tabs sensor-tabs" id="custom-tabs-five-tab" role="tablist">
                                    @foreach ($sensors as $key => $sensor)
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-{{ $sensor->id }}-overlay-tab"
                                                data-toggle="pill" href="#custom-tabs-{{ $sensor->id }}-overlay"
                                                role="tab" aria-controls="custom-tabs-{{ $sensor->id }}-overlay"
                                                aria-selected="true" data-id="{{ $sensor->id }}">

                                                {{ $sensor->description }}

                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-3 d-flex align-items-center pl-4">
                                <div class="alert alert-primary dashboard-alert w-100 mb-0" role="alert">
                                    <i class="fa fa-info dashboard-alert-icon"></i> Last update: <b>Apr 1, 2026 10:00
                                        AM</b>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <script>
                            window.onload = function() {

                                var limit = 50000;
                                var y = 100;
                                var data = [];
                                var dataSeries = {
                                    type: "line"
                                };
                                var dataPoints = [];
                                for (var i = 0; i < limit; i += 1) {
                                    y += Math.round(Math.random() * 10 - 5);
                                    dataPoints.push({
                                        x: i,
                                        y: y
                                    });
                                }
                                dataSeries.dataPoints = dataPoints;
                                data.push(dataSeries);

                                //Better to construct options first and then pass it as a parameter
                                var options = {
                                    zoomEnabled: true,
                                    animationEnabled: true,
                                    title: {
                                        text: "Try Zooming - Panning"
                                    },
                                    axisY: {
                                        lineThickness: 1
                                    },
                                    data: data // random data
                                };

                                var chart = new CanvasJS.Chart("chartContainer", options);
                                var startTime = new Date();
                                chart.render();
                                var endTime = new Date();
                                document.getElementById("timeToRender").innerHTML = "Time to Render: " + (endTime - startTime) + "ms";

                            }
                        </script>
                        <div class="tab-content" id="custom-tabs-five-tabContent">
                            @foreach ($sensors as $key => $sensor)
                                <div class="tab-pane fade {{ $key === 0 ? 'active show' : '' }}"
                                    id="custom-tabs-{{ $sensor->id }}-overlay" role="tabpanel"
                                    aria-labelledby="custom-tabs-{{ $sensor->id }}-overlay-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="activePowerProfile{{ $sensor->id }}"
                                                style="height: 520px; width: 100%;"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="chartContainer" style="height: 600px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
         {{-- END NEW LAYOUT --}}
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs dashboard-tabs" id="custom-tabs-five-tab" role="tablist">
                            @foreach ($sensors as $key => $sensor)
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-{{ $sensor->id }}-overlay-tab"
                                        data-toggle="pill" href="#custom-tabs-{{ $sensor->id }}-overlay"
                                        role="tab" aria-controls="custom-tabs-{{ $sensor->id }}-overlay"
                                        aria-selected="true" data-id="{{ $sensor->id }}">
                                        {{ $sensor->description }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-five-tabContent">
                            @foreach ($sensors as $key => $sensor)
                                <div class="tab-pane fade {{ $key === 0 ? 'active show' : '' }}"
                                    id="custom-tabs-{{ $sensor->id }}-overlay" role="tabpanel"
                                    aria-labelledby="custom-tabs-{{ $sensor->id }}-overlay-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-primary">
                                                <div class="card-body">
                                                    <div id="voltageProfile{{ $sensor->id }}"
                                                        style="height: 520px; width: 100%;"></div>
                                                </div>
                                            </div>
                                            <div class="card card-primary">
                                                <div class="card-body">
                                                    <div id="currentProfile{{ $sensor->id }}"
                                                        style="height: 520px; width: 100%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @section('scripts')
        <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
        <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
        <script type="module" src="{{ asset('assets/js/voltageCurrent.js') }}?v={{ time() }}"></script>
    @endsection
</x-app-layout>
