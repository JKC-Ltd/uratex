<x-app-layout>
    <x-slot name="importedLinks">
        <link rel="stylesheet" href="{{ asset('assets/css/spinner.css') }}">
        <style>
            #boc-avatar {
                display: none !important;
                /* Use !important to override other styles */
            }

            .boc-edit-form-header {
                height: 100% !important;
            }

            .boc-form-fieldset {
                padding-top: 25px;
            }

            label.hasval {
                font-size: 1rem;
                /* color: black !important; */
            }
            
        </style>
    </x-slot>
    <x-slot name="pageTitle">
        Location Dashboard
    </x-slot>
    <x-slot name="content">
        <div class="location-dashboard-chart">
            <div id="tree"></div>
        </div>
    </x-slot>

    @section('scripts')
        <script src="{{ asset('assets/js/orgchart.js') }}"></script>
        <script type="module" src="{{ asset('dist/js/pages/locationDashboard.js') }}?v={{ time() }}"></script>
    @endsection
</x-app-layout>
