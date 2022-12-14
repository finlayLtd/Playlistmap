<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow px-15">
            <!-- Mini Mode -->
            <div class="content-header-section sidebar-mini-visible-b">
                <!-- Logo -->
                <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                    <img alt="" src="{{ asset('images/logo.webp') }}" >
                </span>
                <!-- END Logo -->
            </div>
            <!-- END Mini Mode -->

            <!-- Normal Mode -->
            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times text-danger"></i>
                </button>
                <!-- END Close Sidebar -->

                <!-- Logo -->
                <div class="content-header-item">
                    <a class="font-w700" href="{{ route('backend.dashboard') }}">
                        <img alt="" src="{{ asset('images/logo.webp') }}"  width="130">
                    </a>
                </div>
                <!-- END Logo -->
            </div>
            <!-- END Normal Mode -->
        </div>
        <!-- END Side Header -->

        <!-- Side User -->
        <div class="content-side content-side-full content-side-user px-10 align-parent">
            <!-- Visible only in mini mode -->
            <div class="sidebar-mini-visible-b align-v animated fadeIn">
                <img alt="" class="img-avatar img-avatar32" src="{{ asset('images/defaults/avatar.webp') }}" >
            </div>
            <!-- END Visible only in mini mode -->

            <!-- Visible only in normal mode -->
            <div class="sidebar-mini-hidden-b text-center">
                <a class="img-link" href="javascript:void(0)">
                    <img alt="" class="img-avatar" src="{{ auth()->user()->avatar_url }}" >
                </a>
                <ul class="list-inline mt-10">
                    <li class="list-inline-item">
                        <a class="link-effect text-dual-primary-dark font-size-sm font-w600 text-uppercase" href="javascript:void(0)">{{ auth()->user()->name }}</a>
                    </li>
                    <li class="list-inline-item">
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <a class="link-effect text-dual-primary-dark" data-toggle="layout" data-action="sidebar_style_inverse_toggle" href="javascript:void(0)">
                            <i class="si si-drop"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="link-effect text-dual-primary-dark" href="javascript:void(0)" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            <i class="si si-logout"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>

                </ul>
            </div>
            <!-- END Visible only in normal mode -->
        </div>
        <!-- END Side User -->

        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <li>
                    <a class="{{ _active_menu('dashboard') }}" href="{{ route('backend.dashboard') }}">
                        <i class="si si-speedometer"></i><span class="sidebar-mini-hide">Dashboard</span>
                    </a>
                </li>

                <li class="{{ _active_menu('playlists', true) }}">
                    {!! _sidebar_menu_group('Playlist', 'fal fa-list-music') !!}
                    <ul>
                        {!! _sidebar_menu(route('backend.playlists.index'), 'Index') !!}
                        {!! _sidebar_menu(route('backend.playlists.create'), 'Add New') !!}
                    </ul>
                </li>

                <li class="{{ _active_menu('crawler', true) }}">
                    {!! _sidebar_menu_group('Crawler', 'fal fa-bug') !!}
                    <ul>
                        {!! _sidebar_menu(route('backend.crawler.index'), 'Index') !!}
                        {!! _sidebar_menu(route('backend.crawler.dashboard'), 'Dashboard') !!}
                        {!! _sidebar_menu(route('backend.crawler.playlists_statistics'), 'Playlists Statistics') !!}
                        {!! _sidebar_menu(route('backend.crawler.words'), 'Crawler Words') !!}
                        {!! _sidebar_menu(route('backend.crawler.spotify_users'), 'Spotify Users') !!}
                        {!! _sidebar_menu(route('backend.crawler.spotify_blacklist_users'), 'Spotify Blacklist Users') !!}
                        {!! _sidebar_menu(route('backend.crawler.settings'), 'Settings') !!}
                    </ul>
                </li>

                <li class="{{ _active_menu('users', true) }}">
                    {!! _sidebar_menu_group('Users', 'fal fa-users') !!}
                    <ul>
                        {!! _sidebar_menu(route('backend.users.index'), 'Index') !!}
                        {!! _sidebar_menu(route('backend.users.create'), 'Add New') !!}
                    </ul>
                </li>
                <li>
                    <a class="{{ _active_menu('subscriptions') }}" href="{{ route('backend.subscriptions.index') }}">
                        <i class="fal fa-poll-people"></i><span class="sidebar-mini-hide">Subscriptions</span>
                    </a>
                </li>
                <li class="{{ _active_menu('templates', true) }}">
                    {!! _sidebar_menu_group('Templates', 'fal fa-text-size') !!}
                    <ul>
                        {!! _sidebar_menu(route('backend.templates.index'), 'Index') !!}
                        {!! _sidebar_menu(route('backend.templates.create'), 'Add New') !!}
                    </ul>
                </li>
                <li class="{{ _active_menu('tags', true) }}">
                    {!! _sidebar_menu_group('Tags', 'fal fa-tags') !!}
                    <ul>
                        {!! _sidebar_menu(route('backend.tags.index'), 'Index') !!}
                        {!! _sidebar_menu(route('backend.tags.create'), 'Add New') !!}
                    </ul>
                </li>
                <li>
                    <a class="{{ _active_menu('packages') }}" href="{{ route('backend.plans.index') }}">
                        <i class="fal fa-th-list"></i><span class="sidebar-mini-hide">Packages</span>
                    </a>
                </li>
                <li>
                    <a class="{{ _active_menu('contact reports') }}" href="{{ route('backend.playlists.reported') }}">
                        <i class="fal fa-bug"></i><span class="sidebar-mini-hide">Contact Reports</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- Sidebar Content -->
</nav>
