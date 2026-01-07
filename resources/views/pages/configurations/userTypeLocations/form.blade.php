<x-app-layout>
    <x-slot name="importedLinks">
        <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    </x-slot>
    <x-slot name="pageTitle">
        Accessed Locations :  {{ $userType->name }}
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <form method="POST"
                    action="{{route('userTypeLocations.update', $userType->id) }}">
                    @csrf
                    @if (isset($userType))
                        @method('PUT')
                    @endif
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="location"> Location</label>
                                    <select class=" form-control select2bs4 select2" id="location" multiple="multiple"
                                        name="location[]" style="width: 100%;" required>
                                        {{-- <option value="">Select Locations</option> --}}
                                        {{-- @if(isset($userType))
                                            @php
                                                $selectedLocations = explode(',', $userType->userTypeLocations->locations_list);
                                            @endphp
                                            @foreach ($selectedLocations as $selectedLocation)
                                                <option selected value="{{ $selectedLocation }}">
                                                    {{ $selectedLocation }}
                                                </option>
                                            @endforeach
                                        @endif --}}
                                        @foreach ($listOfLocations as $key => $listOfLocation)
                                            <option value="{{ $key}}" />                                              
                                                {{ $listOfLocation }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('userTypeLocations.index') }}"><button type="button"
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
