<x-app-layout>
    <x-slot name="importedLinks">
        <link rel="stylesheet" href="{{ asset('assets/css/spinner.css') }}">
    </x-slot>
    <x-slot name="pageTitle">
        Active Power
    </x-slot>
    <x-slot name="content">

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-12">
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
                                                    <div id="activePowerProfile{{ $sensor->id }}"
                                                        style="height: 520px; width: 100%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

    </x-slot>

    @section('scripts')
        <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
        <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
        <script type="module" src="{{ asset('assets/js/activePower.js') }}?v={{ time() }}"></script>
    @endsection
</x-app-layout>
