<header style="position:  fixed;z-index:  10000;width:  100%;">
    <nav class="navbar navbar-expand-md navbar-light btn-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand text-white" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="bg-light navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Search -->
                <div class="navbar-nav mr-auto">
                    <input class="form-control" id="search" style="direction: rtl;width: 100%" type="text" placeholder="البحث" aria-label="Search" autocomplete="off">
                </div>

                <ul class="navbar-nav">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('posts.create') }}"><i class="fa fa-plus"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('profile') }}"><i class="fa fa-user"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="pt-5">
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading"></h1>
            <p class="lead text-muted">قم بمشاركة صورك وفيديوهاتك من خلال شبكة الإنستقرام</p>
            <p style="direction: rtl;">
                <a href="{{ route('home') }}" class="btn btn-{{ isset($active_home) ? $active_home : 'secondary' }} my-2">{{ __('frontend.Home') }}</a>
                <a href="{{ route('followers.index') }}" class="btn btn-{{ isset($active_follow) ? $active_follow : 'secondary' }} my-2">{{ __('frontend.Followers') }}</a>
                <a href="{{ route('users.index') }}" class="btn btn-{{ isset($active_user) ? $active_user : 'secondary' }} my-2">{{ __('frontend.Users') }}</a>
                <a href="{{ route('profile') }}" class="btn btn-{{ isset($active_profile) ? $active_profile : 'secondary' }} my-2">{{ __('frontend.My Profile') }}</a>
            </p>
        </div>
    </section>
</div>

