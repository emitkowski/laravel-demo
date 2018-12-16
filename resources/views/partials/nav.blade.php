<!-- header logo: style can be found in header-->
<header class="header">
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="{{ route('home') }}" class="logo">

        </a>
        <!-- Sidebar toggle button-->
        <div class="mr-auto">
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <i class="fa fa-fw ti-menu"></i>
            </a>
        </div>

        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown-->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle padding-user d-block" data-toggle="dropdown">
                        {{--<img src="/img/authors/avatar1.jpg" width="35" class="rounded-circle img-fluid float-left" height="35" alt="User Image">--}}
                        <div class="riot">
                            <div>
                                {{ auth()->user()->name }}
                                <span><i class="fa fa-sort-down"></i></span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <li role="presentation"></li>
                        <li>
                            <a href="{{ route('logout') }}" class="dropdown-item logout-link">
                                <i class="fa fa-fw ti-shift-right"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>