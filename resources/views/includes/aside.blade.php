<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="{{ asset('assets/images/siix-logo.png')}}" alt="Logo" class="img-fluid d-flex m-auto" style="padding:10px;width:180px;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2 mb-5">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('locationDashboard.index') }}" class="nav-link {{ request()->routeIs('locationDashboard.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map-marker-alt"></i>
                        <p>
                            Location Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('energyConsumption.index') }}" class="nav-link {{ request()->routeIs('energyConsumption.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bolt"></i>
                        <p>
                            Energy Consumption
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('activePower.index') }}" class="nav-link {{ request()->routeIs('activePower.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-plug"></i>
                        <p>
                            Active Power
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('voltageCurrent.index') }}" class="nav-link {{ request()->routeIs('voltageCurrent.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Voltage & Current
                        </p>
                    </a>
                </li>
                @if (Auth::user()->userType->name== 'Admin')
                <li class="nav-header">CONFIGURATIONS</li>
                <li class="nav-item">
                    <a href="{{ route('users.index')}}" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('locations.index') }}" class="nav-link {{ request()->routeIs('locations.index') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-map-pin"></i>
                        <p>
                            Locations
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/gateways" class="nav-link {{ request()->is('gateways') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-hdd"></i>
                        <p>
                            Gateways
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sensors.index') }}" class="nav-link {{ request()->routeIs('sensors.index') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-tablet"></i>
                        <p>
                            Sensors
                        </p>
                    </a>
                </li>
              
                <li class="nav-item {{ request()->routeIs('sensorTypes.index','sensorModels.index') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>
                            Sensor Configurations
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('sensorTypes.index') }}" class="nav-link {{ request()->routeIs('sensorTypes.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sensor Type</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sensorModels.index') }}" class="nav-link {{ request()->routeIs('sensorModels.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sensor Model</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="/sensorRegisters" class="nav-link {{ request()->is('sensorRegisters') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sensor Register</p>
                            </a>
                        </li> --}}
                    </ul>
                </li>
                
                @endif
                
            </ul>
        </nav>
    </div>
</aside>
