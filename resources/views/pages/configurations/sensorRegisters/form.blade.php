<x-app-layout>
    <x-slot name="pageTitle">
        {{ isset($sensorRegister) ? 'Edit Register Type' : 'Create Register Type' }}
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <form method="POST"
                    action="{{ isset($sensorRegister) ? route('sensorRegisters.update', $sensorRegister->id) : route('sensorRegisters.store') }}">
                    @csrf
                    @if (isset($sensorRegister))
                        @method('PUT')
                    @endif
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="sensor_type">Sensor Type</label>
                                        <select id="sensor_type"
                                            class="form-control select2bs4 @error('sensor_type_id') input-error @enderror"
                                            name="sensor_type_id" style="width: 100%">
                                            <option value="" selected disabled>Select Sensor Type</option>
                                            @foreach ($sensorTypes as $sensorType)
                                                <option value="{{ $sensorType->id }}"
                                                    {{ isset($sensorRegister) ? ($sensorType->id == $sensorRegister->sensor_type_id ? 'selected' : '') : '' }}>
                                                    {{ $sensorType->description }}</option>
                                            @endforeach
                                        </select>
                                        @error('sensor_type_id')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group">
                                        <label for="sensor_model">Sensor Model</label>
                                        <select id="sensor_model"
                                            class="form-control select2bs4 @error('sensor_model_id') input-error @enderror"
                                            name="sensor_model_id" style="width: 100%">
                                            <option value="" selected disabled>Select Sensor Model</option>

                                            @foreach ($sensorModels as $sensorModel)
                                                <option value="{{ $sensorModel->id }}"
                                                    {{ isset($sensorRegister) ? ($sensorModel->id == $sensorRegister->sensor_model_id ? 'selected' : '') : '' }}>
                                                    {{ $sensorModel->sensor_model }}</option>
                                            @endforeach
                                        </select>
                                        @error('sensor_model_id')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="sensorRegisterAddress">Sensor Registration</label>
                                        <input type="text"
                                            class="form-control @error('sensor_reg_address') input-error @enderror"
                                            id="sensorRegisterAddress" name="sensor_reg_address"
                                            value="{{ isset($sensorRegister) ? $sensorRegister->sensor_reg_address : '' }}"
                                            placeholder="Sensor Register Address" required>
                                        @error('sensor_reg_address')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('sensorRegisters.index') }}"><button type="button"
                                    class="btn btn-danger">Cancel</button></a>
                            <button type="submit"
                                class="btn btn-primary">{{ isset($sensorRegister) ? 'Update' : 'Submit' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
    @section('scripts')
        <script type="text/javascript">
            $(document).ready(function() {

                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })

            });
        </script>
    @endsection
</x-app-layout>
