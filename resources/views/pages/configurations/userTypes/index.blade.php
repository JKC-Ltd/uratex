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
                        <div class="right w-50 text-right">
                            <a href="{{ route('userTypes.create') }}">
                                <button class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i>
                                    &nbsp;Create New User Type</button>
                            </a>
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
                                {{-- @php
                                    dd($listOfLocations);
                                @endphp --}}
                                @foreach ($userTypes as $userType)
                                    <tr>
                                        <td>{{ $userType->id }}</td>
                                        <td>{{ $userType->name }}</td>
                                        <td>
                                            @if ($userType->userTypeLocations->count() > 0)
                                                @foreach ($userType->userTypeLocations as $location)
                                                    @foreach (explode(',', $location->locations_list) as $locationName)
                                                        <span class="badge badge-info">
                                                            {{ $listOfLocations[$locationName] }}
                                                        </span></br>
                                                    @endforeach
                                                @endforeach
                                            @else
                                                <span class="badge badge-warning">No Locations Assigned</span>
                                            @endif
                                        </td>
                                        <td>{{ $userType->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('userTypes.edit', $userType->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fa fa-pen"></i> Edit
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm delete-data-info"
                                                data-name="{{ $userType->name }}" data-id="{{ $userType->id }}"
                                                data-url="userTypes/destroy">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
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
        <script src="{{ asset('assets/js/sweetalert-delete.js') }}"></script>
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
