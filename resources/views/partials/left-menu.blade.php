<!-- sidebar: style can be found in sidebar-->
<section class="sidebar">
    <div id="menu" role="navigation">

        <!-- Profile -->
        <div class="nav_profile">
            <div class="media profile-left">
                {{--<a class="float-left profile-thumb" href="#">--}}
                    {{--<img src="/images/authors/avatar1.jpg" class="rounded-circle" alt="User Image"></a>--}}
                <div class="content-profile">
                    <h4 class="media-heading">{{ auth()->user()->name }}</h4>
                    <ul class="icon-list">
                        {{--<li>--}}
                            {{--<a href="{{ route('user-profile') }}" title="user">--}}
                                {{--<i class="fa fa-fw ti-user" aria-hidden="true"></i>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        <li>
                            <a class="logout-link" href="{{ route('logout') }}" title="Logout">
                                <i class="fa fa-fw ti-shift-right" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Left Links -->
        <ul class="navigation">
            <li {!! request()->is('/') ? 'class="active"' : '' !!}>
                <a href="{{ route('home') }}">
                    <i class="menu-icon ti-home" aria-hidden="true"></i>
                    <span class="mm-text">Dashboard</span>
                </a>
            </li>
            <li class="menu-dropdown {!! request()->is('manage/*') ? 'active' : '' !!}">
                <a href="#">
                    <i class="fa fa-fw fa-edit" aria-hidden="true"></i>
                    <span>Management</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li {!! (request()->is('teams*') ? 'class="active"' : 'class=""') !!}>
                        <a href="{{ route('teams.index') }}">
                            <i class="menu-icon fa fa-fw fa-users" aria-hidden="true"></i> Manage Teams
                        </a>
                    </li>
                    <li {!! (request()->is('players*') ? 'class="active"' : 'class=""') !!}>
                        <a href="{{ route('players.index') }}">
                            <i class="menu-icon fa fa-fw fa-user" aria-hidden="true"></i> Manage Players
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</section>