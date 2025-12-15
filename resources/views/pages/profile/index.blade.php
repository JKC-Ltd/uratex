<x-app-layout>
    <x-slot name="importedLinks">
        @include('includes.datatables-links')
    </x-slot>
    <x-slot name="pageTitle">
        User Profile
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary" id="sensor_details" >
                    <div class="card-header">
                        <div class="card-title">
                            User Details
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <div class="card-details">
                            <p><strong><i class="fas fa-user"></i>Name</strong> </p>
                            <p>{{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}</p>
                        </div>
                        <div class="separator"></div>
                        <div class="card-details">
                            <p><strong><i class="fas fa-envelope"></i>Email</strong> </p>
                            <p>{{ Auth::user()->email }}</p>
                        </div>
                        <div class="separator"></div>
                        <div class="card-details">
                            <p><strong><i class="fas fa-calendar-alt"></i>Created At</strong> </p>
                            <p>{{ Auth::user()->created_at->format('d M Y') }}</p>
                            
                        </div>

                        <a href="{{ route('profile.edit', $user->id) }}">
                            <button class="btn btn-primary btn-sm">
                                <i class="fa fa-pen"></i> Edit Profile
                            </button>
                        </a>
                    </div>
                </div>


               
            </div>
         

        </div>
    </x-slot>
</x-app-layout>
