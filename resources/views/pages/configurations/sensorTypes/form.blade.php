<x-app-layout>
    <x-slot name="importedLinks">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
        {{-- <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}"> --}}
    </x-slot>
    <x-slot name="pageTitle">
        {{ isset($sensorType) ? 'Edit Sensor Type' : 'Create Sensor Type' }}
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <form method="POST"
                    action="{{ isset($sensorType) ? route('sensorTypes.update', $sensorType->id) : route('sensorTypes.store') }}">
                    @csrf
                    @if (isset($sensorType))
                        @method('PUT')
                    @endif
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="sensorTypeCode">Sensory Type Code</label>
                                        <input type="text" class="form-control" id="sensorTypeCode"
                                            name="sensor_type_code"
                                            value="{{ isset($sensorType) ? $sensorType->sensor_type_code : old('sensor_type_code') }}"
                                            placeholder="Sensor Type Code" required>
                                        @error('sensor_type_code')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @php

                                    @endphp
                                    <div class="form-group">
                                        <label for="sensorTypeParameter">Sensor Type Parameter</label>
                                        {{-- <input type="text" class="form-control" id="sensorTypeParameter"
                                            name="sensor_type_parameter"
                                            value="{{ isset($sensorType) ? $sensorType->sensor_type_parameter : old('sensor_type_parameter') }}"
                                            placeholder="Sensor Type Parameter" required>
                                        @error('sensor_type_parameter')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror --}}

                                        <select class=" form-control select2bs4 select2" id="sensor_type_parameter"
                                            multiple="multiple" name="sensor_type_parameter[]" style="width: 100%;"
                                            required>
                                            @if (isset($sensorType))
                                                @php

                                                    $sensorTypeParameters = explode(
                                                        ',',
                                                        $sensorType->sensor_type_parameter,
                                                    );

                                                @endphp
                                                @foreach ($sensorTypeParameters as $sensor_type_parameter)
                                                    <option selected value="{{ $sensor_type_parameter }}">
                                                        {{ $sensor_type_parameter }}</option>
                                                @endforeach
                                            @endif
                                            {{-- <option selected value="V">V</option> --}}
                                            {{-- <option selected value="CO2">CO2</option>         --}}
                                            @foreach ($sensorLogs as $sensorLog)
                                                <option value="{{ $sensorLog }}">{{ $sensorLog }}</option>)
                                            @endforeach
                                            {{-- <option value="V">V</option>
                                            <option value="CO2">CO2</option> --}}
                                        </select>
                                        @error('sensor_type_parameter')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror

                                    </div>


                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="description" required>{{ isset($sensorType) ? $sensorType->description : old('description') }}</textarea>
                                        @error('description')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('sensorTypes.index') }}"><button type="button"
                                    class="btn btn-danger">Cancel</button></a>
                            <button type="submit"
                                class="btn btn-primary">{{ isset($sensorType) ? 'Update' : 'Submit' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
    @section('scripts')
        <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    theme: 'bootstrap4'
                })
                @if ($errors->has('location_id'))
                    $('.select2').next('.select2').addClass('input-error');
                @endif
            });
        </script>
    @endsection
</x-app-layout>
