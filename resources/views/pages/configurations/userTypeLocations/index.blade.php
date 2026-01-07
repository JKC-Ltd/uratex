<x-app-layout>
    <x-slot name="importedLinks">
        @include('includes.datatables-links')

    </x-slot>
    <x-slot name="pageTitle">
        UserType Locations
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="left w-50">
                            <h3 class="card-title">UserType Locations List</h3>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="defaultTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User Type</th>
                                    <th>Locations</th>
                                    <th>Last Update</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($userTypes as $userType)
                                    <tr>
                                        <td>{{ $userType->id }}</td>
                                        <td>{{ $userType->name }}</td>
                                        <td>
                                            @if ($userType->userTypeLocations->count() > 0)
                                                @foreach ($userType->userTypeLocations as $location)
                                                    @foreach (explode(',', $location->locations_list) as $locationName)
                                                        <span class="badge badge-info">{{ $locationName }}</span></br>
                                                    @endforeach
                                                @endforeach
                                            @else
                                                <span class="badge badge-warning">No Locations Assigned</span>
                                            @endif
                                        </td>
                                        <td>{{ $userType->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('userTypeLocations.edit', $userType->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fa fa-pen"></i> Edit
                                            </a>

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
        <script src="{{ asset('/assets/js/sweetalert-delete.js') }}"></script>
    @endsection
</x-app-layout>
