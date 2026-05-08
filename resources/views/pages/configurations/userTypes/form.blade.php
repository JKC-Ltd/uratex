<x-app-layout>
    <x-slot name="importedLinks">
        <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    </x-slot>
    <x-slot name="pageTitle">
        Create User Type
    </x-slot>
    <x-slot name="content">
        @php

            // dd($userType);
        @endphp
        <div class="row">
            <div class="col-12">
                <form method="POST"
                    action="{{ isset($userType) ? route('userTypes.update', $userType->id) : route('userTypes.store') }}">
                    @csrf
                    @if (isset($userType))
                        @method('PUT')
                    @endif
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <label for="name">User Type</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') input-error @enderror" id="name"
                                        placeholder="User Type"
                                        value="{{ old('name', isset($userType) ? $userType->name : '') }}">
                                    @error('name')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror


                                    {{-- <label for="location"> Location</label>
                                    <select class=" form-control select2bs4 select2" id="location" multiple="multiple"
                                        name="location[]" style="width: 100%;" required>
                                        @if (isset($userType))
                                            @php
                                                $assignedLocations = [];
                                                foreach ($userType->userTypeLocations as $userlocation) {
                                                    $locationsList = explode(',', $userlocation->locations_list);
                                                    $assignedLocations = array_merge(
                                                        $assignedLocations,
                                                        $locationsList,
                                                    );
                                                }

                                            @endphp
                                            @foreach ($assignedLocations as $assignedLocation)
                                                <option selected value="{{ $assignedLocation }}">
                                               
                                                    {{ $listOfLocations[$assignedLocation] }}
                                                </option>
                                            @endforeach
                                        @endif
                                        @foreach ($listOfLocations as $key => $listOfLocation)
                                            <option value="{{ $key }}" />
                                            {{ $listOfLocation }}
                                            </option>
                                        @endforeach
                                    </select> --}}
                                
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('userTypes.index') }}"><button type="button"
                                    class="btn btn-danger">Cancel</button></a>
                            <button type="submit"
                                class="btn btn-primary">{{ isset($userType) ? 'Update' : 'Create' }}</button>
                        </div>
                </form>
            </div>
        </div>
    </x-slot>
    @section('scripts')
        <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
                @if ($errors->has('location_id'))
                    $('.select2bs4').next('.select2').addClass('input-error');
                @endif
            });
        </script>
    @endsection
</x-app-layout>
