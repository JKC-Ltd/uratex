<x-app-layout>
    <x-slot name="pageTitle">
        {{ isset($user) ? 'Edit ' : 'Create ' }} Users
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}"
                        method="POST">
                        {{-- action="{{ isset($sensor) ? route('gateways.update', $sensor->id) : route('gateways.store') }}"
                        method="POST"> --}}
                        @csrf
                        @if (isset($user))
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstname">First Name</label>
                                        <input type="text" name="firstname"
                                            class="form-control @error('firstname') input-error @enderror"
                                            id="firstname" placeholder="First Name"
                                            value="{{ isset($user) ? $user->firstname : old('firstname') }}">
                                        @error('firstname')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror

                                        <label for="lastname">Last Name</label>
                                        <input type="text" name="lastname"
                                            class="form-control @error('lastname') input-error @enderror" id="lastname"
                                            placeholder="Last Name"
                                            value="{{ isset($user) ? $user->lastname : old('lastname') }}">
                                        @error('lastname')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror

                                        <label>User Type</label>
                                        <select
                                            class="form-control select2bs4 @error('user_type_id') input-error @enderror"
                                            name="user_type_id" style="width: 100%;">
                                            <option value="">SELECT USER TYPE</option>
                                            @foreach ($userTypes as $userType)
                                                <option value="{{ $userType->id }}"
                                                    {{ (isset($user) && $user->user_type_id == $userType->id) || old('user_type_id') == $userType->id ? 'selected' : '' }}>
                                                    {{ $userType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_type_id')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror

                                        <label for="email">Email</label>
                                        <input type="text" name="email"
                                            class="form-control @error('email') input-error @enderror" id="email"
                                            placeholder="Email" value="{{ isset($user) ? $user->email : old('email') }}">
                                        @error('email')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror

                                        <label for="password">Password</label>
                                        <input type="password" name="password" 
                                            class="form-control @error('password') input-error @enderror" id="password"
                                            placeholder="Password" value="">
                                        @error('password')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror

                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" name="password_confirmation" 
                                            class="form-control @error('password') input-error @enderror" id="password_confirmation"
                                            placeholder="Password" value="">
                                        @error('password_confirmation')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('users.index') }}">
                                <button type="button" class="btn btn-danger">Cancel</button>
                            </a>
                            <button type="submit"
                                class="btn btn-primary">{{ isset($user) ? 'Update' : 'Create' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
    <x-slot name="importedScripts">
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
    </x-slot>
</x-app-layout>
