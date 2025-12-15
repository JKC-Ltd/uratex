<x-app-layout>
    <x-slot name="pageTitle">
        {{ $sensor->description }}
    </x-slot>
    <x-slot name="content">

        {{-- <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div id="voltageCurrentProfile{{ $sensor->id }}" data-id="{{ $sensor->id }}" style="height: 320px; width: 100%;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div id="activePowerProfile{{ $sensor->id }}" data-id="{{ $sensor->id }}" style="height: 320px; width: 100%;">
                        </div>
                    </div>
                </div>
            </div> --}}

        <div class="col-md-12" id="sensor-details-line" data-id="{{ $sensor->id }}">
            <div class="card card-primary">
                <div class="card-body">
                    <div id="activePowerProfile{{ $sensor->id }}" style="height: 520px; width: 100%;"></div>
                </div>
            </div>
            <div class="card card-primary">
                <div class="card-body">
                    <div id="voltageProfile{{ $sensor->id }}" style="height: 520px; width: 100%;"></div>
                </div>
            </div>
            <div class="card card-primary">
                <div class="card-body">
                    <div id="currentProfile{{ $sensor->id }}" style="height: 520px; width: 100%;"></div>
                </div>
            </div>
        </div>

        </div>
    </x-slot>

    @section('scripts')
        <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
        <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
        <script type="module" src="{{ asset('assets/js/sensor-details.js') }}?v={{ time() }}"></script>
    @endsection
</x-app-layout>
