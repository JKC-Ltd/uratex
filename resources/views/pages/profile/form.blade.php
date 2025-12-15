<x-app-layout>
    <x-slot name="importedLinks">
        @include('includes.datatables-links')
        <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    </x-slot>
    <x-slot name="pageTitle">
        Edit Profile
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <form action="{{ route('profile.update', $user->id) }}"
                        method="POST">
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
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" name="lastname"
                                            class="form-control @error('lastname') input-error @enderror" id="lastname"
                                            placeholder="Last Name"
                                            value="{{ isset($user) ? $user->lastname : old('lastname') }}">
                                        @error('lastname')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>     
                                       
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email"
                                            class="form-control @error('email') input-error @enderror" id="email"
                                            placeholder="Email" value="{{ isset($user) ? $user->email : old('email') }}" disabled>
                                        @error('email')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                         

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="old_password">Old Password</label>
                                        <input type="password" id="old_password" name="old_password" class="form-control">
                                        @error('old_password')
                                            <span class="error-message">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password">New Password</label>
                                        <input type="password" id="new_password" name="new_password" class="form-control">
                                        @error('new_password')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password_confirmation">Confirm New Password</label>
                                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control">
                                        @error('new_password_confirmation')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('dashboard') }}">
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
    @section('scripts')
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/datatables.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('/assets/js/sweetalert-delete.js') }}"></script>
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
