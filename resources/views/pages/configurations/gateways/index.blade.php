<x-app-layout>
    <x-slot name="importedLinks">
        @include('includes.datatables-links')
    </x-slot>
    <x-slot name="pageTitle">
        Gateways
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="left w-50">
                            <h3 class="card-title">Gateway List</h3>
                        </div>
                        <div class="right w-50 text-right">
                            <a href="/gateways/create">
                                <button class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i>
                                    &nbsp;Create New Gateway</button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="defaultTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Location</th>
                                    <th>Gateway</th>
                                    <th>Gateway Code</th>
                                    <th>Description</th>
                                    <th>Last Update</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($gateways) && $gateways->isNotEmpty())
                                    @foreach ($gateways as $gateway)
                                        <tr>
                                            <td>{{ $gateway->id }}</td>
                                            <td>{{ $gateway->location->location_name }}</td>
                                            <td>{{ $gateway->gateway }}</td>
                                            <td>{{ $gateway->gateway_code }}</td>
                                            <td>{{ $gateway->description }}</td>
                                            <td>{{ $gateway->updated_at }}</td>
                                            <td>
                                                <form action="{{ route('gateways.destroy', $gateway->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="btn-group">
                                                        <a href="{{ route('gateways.edit', $gateway->id) }}">
                                                            <button class="btn btn-primary btn-sm" type="button">
                                                                <i class="fa fa-pen"></i> Edit
                                                            </button>
                                                        </a>

                                                        <button type="button"
                                                            class="btn btn-danger btn-sm delete-data-info"
                                                            data-name="{{ $gateway->gateway }}"
                                                            data-id="{{ $gateway->id }}" data-url="gateways/destroy">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">No gateways found.</td>
                                    </tr>
                                @endif
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
