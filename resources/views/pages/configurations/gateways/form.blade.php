<x-app-layout>
    <x-slot name="pageTitle">
        {{ isset($gateway) ? 'Edit Gateways' : 'Create Gateways' }}
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <form
                        action="{{ isset($gateway) ? route('gateways.update', $gateway->id) : route('gateways.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($gateway))
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <select
                                            class="form-control select2bs4 @error('location_id') input-error @enderror"
                                            name="location_id" style="width: 100%;" required>
                                            <option value="" selected disabled>SELECT LOCATION</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}"
                                                    {{ old('location_id', isset($gateway) ? $gateway->location_id : '') == $location->id ? 'selected' : '' }}>
                                                    {{ $location->location_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('location_id')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="customerCode">Customer Code</label>
                                        <input type="text" name="customer_code"
                                            class="form-control @error('customer_code') input-error @enderror"
                                            id="customerCode" placeholder="Customer Code"
                                            value="{{ old('customer_code', isset($gateway) ? $gateway->customer_code : '') }}"
                                            required>
                                        @error('customer_code')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="gateway">Gateway</label>
                                        <input type="text" name="gateway"
                                            class="form-control @error('gateway') input-error @enderror" id="gateway"
                                            placeholder="Gateway"
                                            value="{{ old('gateway', isset($gateway) ? $gateway->gateway : '') }}"
                                            required>
                                        @error('gateway')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="gatewayCode">Gateway Code</label>
                                        <input type="text" name="gateway_code"
                                            class="form-control @error('gateway_code') input-error @enderror"
                                            id="gatewayCode" placeholder="Gateway Code"
                                            value="{{ old('gateway_code', isset($gateway) ? $gateway->gateway_code : '') }}"
                                            required>
                                        @error('gateway_code')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control @error('description') input-error @enderror" name="description" id="description" required
                                            placeholder="Description">{{ old('description', isset($gateway) ? $gateway->description : '') }}</textarea>
                                        @error('description')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('gateways.index') }}">
                                <button type="button" class="btn btn-danger">Cancel</button>
                            </a>
                            <button type="submit"
                                class="btn btn-primary">{{ isset($gateway) ? 'Update' : 'Create' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
    @section('scripts')
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
