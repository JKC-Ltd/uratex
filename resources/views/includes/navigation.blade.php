<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                Hi, {{ Auth::user()->firstname }}
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <li class="user-header">
                    <div class="circle-icon">
                        {{ strtoupper(substr(Auth::user()->firstname, 0, 1) . substr(Auth::user()->lastname, 0, 1)) }}
                    </div>          
                  <p>
                    {{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}
                  </p>
                </li>
                <li class="user-footer">
                    
                        <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">Profile</a>
                    
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf    
                            <a class="btn btn-default btn-flat" href="route('logout')"
                            onclick="event.preventDefault();
                            this.closest('form').submit();">
                            <p>Logout</p>
                            </a>          
                        </form>
                    
                </li>
              </ul>
        </li>
    </ul>
</nav>
