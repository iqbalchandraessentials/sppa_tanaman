<header class="main-header">
    <nav class="navbar navbar-static-bottom">
        <div class=""></div>
        <div class="navbar-custom-menu r-side">
            <ul class="nav navbar-nav">
                <!-- User Account-->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="ti-settings"></i>
                    </a>
                    <ul class="dropdown-menu animated flipInX dropdown-show-top">
                        <!-- Menu Body -->
                        <li class="user-body">
                            {{-- <a class="dropdown-item font-size-1rem" href="{{ url('/') }}"><i class="ti-close"></i>Exit</a> --}}
                            <a class="dropdown-item font-size-1rem" href="javascript:void(0);" onclick="window.history.go(-1)"><i class="ti-arrow-left"></i>Exit</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item font-size-1rem" href="{{ url('/') }}"><i class="ti-power-off"></i>Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
