<x-app-layout>
    <x-slot name="importedLinks">
        @include('includes.datatables-links')
    </x-slot>
    <x-slot name="pageTitle">
        Sensors
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="left w-50">
                            <h3 class="card-title">Sensors List</h3>
                        </div>
                        <div class="right w-50 text-right">
                            <a href="{{ route('sensors.create') }}">
                                <button class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i>
                                    &nbsp;Create New Sensor</button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="defaultTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Slave Address</th>
                                    <th>Location</th>
                                    <th>Gateway</th>
                                    <th>Sensor Type</th>
                                    <th>Sensor Model</th>
                                    <th>Description</th>
                                    <th>Last Update</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sensors as $sensor)
                                @php
                                    // dd($listOfLocationsParents[$sensor->location_id]); 
                                @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $sensor->slave_address }}</td>
                                        <td>
                                            {{ !empty($listOfLocationsParents[$sensor->location_id]['fullPath']) ? $listOfLocationsParents[$sensor->location_id]['fullPath'] .' /' : 'SEP / EMS /' }} 
                                            <b>{{ $sensor->location->location_name  }}</b>
                                        </td>

                                        <td>{{ $sensor->gateway->gateway_code }}</td>
                                        <td>{{ $sensor->sensorModel->sensorType->sensor_type_code }}</td>
                                        </td>
                                        <td>{{ $sensor->sensorModel->sensor_model }} -
                                            {{ $sensor->sensorModel->sensor_brand }}</td>
                                        <td>{{ $sensor->description }}</td>
                                        <td>{{ $sensor->updated_at }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('sensors.edit', $sensor->id) }}">
                                                    <button class="btn btn-primary btn-sm">
                                                        <i class="fa fa-pen"></i> Edit
                                                    </button>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm delete-data-info"
                                                    data-name="{{ $sensor->slave_address }}"
                                                    data-id="{{ $sensor->id }}" data-url="sensors/destroy">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    @section('scripts')
        @include('includes.datatables-scripts')
        <script src="{{ asset('assets/js/datatables.js') }}"></script>
        <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
        <script src="{{ asset('./assets/js/sweetalert-delete.js') }}"></script>
    @endsection
</x-app-layout>
