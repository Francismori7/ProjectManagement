<header class="navigation" role="banner">
    <div class="navigation-wrapper">
        <a href="{{ route('core.home') }}" class="mobile-logo">
            <img src="https://raw.githubusercontent.com/thoughtbot/refills/master/source/images/placeholder_logo_1.png"
                 alt="Logo image">
        </a>
        <a href="#" id="js-navigation-mobile-menu" class="navigation-mobile-menu">
            MENU
        </a>
        <nav role="navigation">
            <ul id="js-navigation-menu" class="navigation-menu show">
                <li class="nav-link logo">
                    <a href="{{ route('core.home') }}" class="logo">
                        <img src="https://raw.githubusercontent.com/thoughtbot/refills/master/source/images/placeholder_logo_1.png"
                             alt="Logo image">
                    </a>
                </li>
                <li class="nav-link"><a href="/projects">My Projects</a></li>
                <li class="nav-link"><a href="/about">About Us</a></li>
                <li class="nav-link"><a href="/contact">Contact</a></li>

                @if(Auth::check())
                    <li class="nav-link more"><a href="/profile">{{ Auth::user()->getFirstName() }}</a>
                        <ul class="submenu">
                            <li><a href="/dashboard">Dashboard</a></li>
                            <li><a href="/profile/edit">Edit my profile</a></li>
                            <li><a href="{{ route('auth.logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @else
                    <li class="nav-link"><a href="{{ route('auth.login') }}">Login</a></li>
                    <li class="nav-link"><a href="{{ route('auth.register') }}">Sign up</a></li>
                @endif
            </ul>
        </nav>
    </div>
</header>