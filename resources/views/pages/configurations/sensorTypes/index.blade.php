<x-app-layout>
    <x-slot name="importedLinks">
        @include('includes.datatables-links')
        <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    </x-slot>
    <x-slot name="pageTitle">
        Sensor Types
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="left w-50">
                            <h3 class="card-title">Sensor Type List</h3>
                        </div>
                        <div class="right w-50 text-right">
                            <a href="{{ route('sensorTypes.create') }}">
                                <button class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i>
                                    &nbsp;Create New Sensor Type</button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="defaultTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Description</th>
                                    <th>Sensor Type Code</th>
                                    <th>Sensor Type Parameter</th>
                                    <th>Last Update</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sensorTypes as $sensorType)
                                    <tr>
                                        <td>{{ $sensorType->id }}</td>
                                        <td>{{ $sensorType->description }}</td>
                                        <td>{{ $sensorType->sensor_type_code }}</td>
                                        <td>{{ $sensorType->sensor_type_parameter }}</td>
                                        <td>{{ $sensorType->updated_at }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('sensorTypes.edit', $sensorType->id) }}">
                                                    <button class="btn btn-primary btn-sm">
                                                        <i class="fa fa-pen"></i> Edit
                                                    </button>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm delete-data-info"
                                                    data-name="{{ $sensorType->sensor_type_code }}"
                                                    data-id="{{ $sensorType->id }}" data-url="sensorTypes/destroy">
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
        <script>
            $(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                @if (session('success'))
                    Toast.fire({
                        icon: 'success',
                        title: '{{ session('success') }}'
                    });
                @endif
            });
        </script>
    @endsection
</x-app-layout>
