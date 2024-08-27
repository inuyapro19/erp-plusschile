<!--begin::User menu-->
<div class="app-navbar-item ms-1 ms-md-3" id="kt_header_user_menu_toggle">
    <!--begin::Menu wrapper-->
    <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
        <img src="{{asset('assets/media/avatars/300-1.jpg')}}" alt="user" />
    </div>
    <!--begin::User account menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <div class="menu-content d-flex align-items-center px-3">
                <!--begin::Avatar-->
                <div class="symbol symbol-50px me-5">
                    <img alt="Logo" src="{{asset('assets/media/avatars/300-1.jpg')}}" />
                </div>
                <!--end::Avatar-->
                <!--begin::Username-->
                <div class="d-flex flex-column">
                    <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name}}
                        <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Cargo</span></div>
                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{Auth::user()->email}}</a>
                </div>
                <!--end::Username-->
            </div>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu separator-->
        <div class="separator my-2"></div>
        <!--end::Menu separator-->
        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="{{route('profile.edit')}}" class="menu-link px-5">Mi Perfil</a>
        </div>



        <!--begin::Menu separator-->
        <div class="separator my-2"></div>
        <!--end::Menu separator-->
        <!--begin::Menu item-->

        <!--laravel logout-->
        <div class="menu-item px-5">
            <a
               href="#"
               class="menu-link px-5"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">Salir</a>
        </div>

        <form
            method="POST"
            action="{{ route('logout') }}"
            id="logout-form">
            {{ csrf_field() }}
        </form>
        <!--end::Menu item-->
    </div>
    <!--end::User account menu-->
    <!--end::Menu wrapper-->
</div>
<!--end::User menu-->
<!--begin::Header menu toggle-->
<div class="app-navbar-item d-lg-none ms-2 me-n3" title="Show header menu">
    <div class="btn btn-icon btn-active-color-primary w-30px h-30px w-md-35px h-md-35px" id="kt_app_header_menu_toggle">
        <!--begin::Svg Icon | path: icons/duotune/text/txt001.svg-->
        <span class="svg-icon svg-icon-2 svg-icon-md-1">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z" fill="currentColor" />
                <path opacity="0.3" d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z" fill="currentColor" />
            </svg>
        </span>
        <!--end::Svg Icon-->
    </div>
</div>
<!--end::Header menu toggle-->
