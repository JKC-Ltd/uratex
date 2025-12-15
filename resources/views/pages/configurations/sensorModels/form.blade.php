<x-app-layout>
    <x-slot name="pageTitle">
        {{ isset($sensorModel) ? 'Edit Sensor Model' : 'Create Sensor Model' }}
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <form method="POST"
                    action="{{ isset($sensorModel) ? route('sensorModels.update', $sensorModel->id) : route('sensorModels.store') }}">
                    @csrf
                    @if (isset($sensorModel))
                        @method('PUT')
                    @endif
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sensorModel">Sensor Model</label>
                                        <input type="text" class="form-control" id="sensorModel" name="sensor_model"
                                            value="{{ isset($sensorModel) ? $sensorModel->sensor_model : old('sensor_model') }}"
                                            placeholder="Sensor Model" required>
                                        @error('sensor_model')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="sensorBrand">Sensor Brand</label>
                                        <input type="text" class="form-control" id="sensorBrand" name="sensor_brand"
                                            value="{{ isset($sensorModel) ? $sensorModel->sensor_brand : old('sensor_brand') }}"
                                            placeholder="Sensor Brand" required>
                                        @error('sensor_brand')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="sensor_type">Sensor Type</label>
                                        <select id="sensor_type"
                                            class="form-control select2bs4 @error('sensor_type_id') input-error @enderror"
                                            name="sensor_type_id" style="width: 100%">
                                            <option value="" selected disabled>Select Sensor Type</option>
                                            @foreach ($sensorTypes as $sensorType)
                                                <option value="{{ $sensorType->id }}"
                                                    {{ isset($sensorModel) ? ($sensorType->id == $sensorModel->sensor_type_id ? 'selected' : '') : '' }}>
                                                    {{ $sensorType->description }}</option>
                                            @endforeach
                                        </select>
                                        @error('sensor_type_id')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- <div id="sensor-reg-address" data-sensor-model="{{ $sensorModel->id }}"></div> --}}
                                    <div id="sensor-reg-address"
                                        {{ isset($sensorModel) ? 'data-sensor-model=' . $sensorModel->id : '' }}>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="card card-primary" id="sensor_details" style="display: none;">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Sensor Type Details
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-details">
                                                <p><strong><i class="fas fa-microchip"></i>Sensor Type Code</strong>
                                                </p>
                                                <span id="sensor_code"></span>
                                            </div>
                                            <div class="separator"></div>
                                            <div class="card-details">
                                                <p><strong><i class="fas fa-file-alt"></i>Description</strong> </p>
                                                <span id="sensor_description"></span>
                                            </div>
                                            <div class="separator"></div>
                                            <div class="card-details">
                                                <p><strong><i class="fas fa-sliders-h"></i>Sensor Type
                                                        Parameter</strong> </p>
                                                <span id="sensor_parameters"></span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('sensorModels.index') }}"><button type="button"
                                    class="btn btn-danger">Cancel</button></a>
                            <button type="submit" id="btnSubmit"
                                class="btn btn-primary">{{ isset($sensorModel) ? 'Update' : 'Create' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
    @section('scripts')
        <script src="{{ asset('assets/js/sensorModel.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })

            });
        </script>
    @endsection
</x-app-layout>
