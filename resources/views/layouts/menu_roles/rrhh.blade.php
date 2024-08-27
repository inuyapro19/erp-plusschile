{{--<li class="menu {{ Request::is('trabajador.import') ? 'active' : '' }}">
    <a href="{{route('trabajador.import')}}" aria-expanded="true" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas"
                 data-icon="home" class="svg-inline--fa fa-home fa-w-18" role="img" viewBox="0 0 576 512">
                <path fill="currentColor"
                      d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z"/>
            </svg>
            <span> Importar Trabajadores</span>
        </div>
    </a>
</li>--}}
<!--begin:Menu item-->
<div class="menu-item pt-5">
    <!--begin:Menu content-->
    <div class="menu-content">
        <span class="menu-heading fw-bold text-uppercase fs-7">Recuersos Humanos</span>
    </div>
    <!--end:Menu content-->
</div>
<!--begin:Menu item-->
<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <!--begin:Menu link-->
    <span class="menu-link">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
														<path
                                                            d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z"
                                                            fill="currentColor"/>
														<path opacity="0.3"
                                                              d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z"
                                                              fill="currentColor"/>
													</svg>
												</span>
                                                <!--end::Svg Icon-->
											</span>
											<span class="menu-title">Trabajadores</span>
											<span class="menu-arrow"></span>
										</span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('trabajadores.index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                <span class="menu-title">Todos los Trabajadores</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->

        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('trabajador.nuevo')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                <span class="menu-title">Agregar</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('desvinculador.index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                <span class="menu-title">Desvinculados</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('trabajador.import')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                <span class="menu-title">Importar</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('vacaciones.index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                <span class="menu-title">Vacaciones</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->

</div>
<!--end:Menu item-->

<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
        <span class="menu-link">
            	<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
														<path
                                                            d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z"
                                                            fill="currentColor"/>
														<path opacity="0.3"
                                                              d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z"
                                                              fill="currentColor"/>
													</svg>
												</span>
                    <!--end::Svg Icon-->
											</span>
											<span class="menu-title">Solicitudes</span>
											<span class="menu-arrow"></span>
        </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('solicitudes.index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                <span class="menu-title">Ver Solicitudes</span>
            </a>
            <!--end:Menu link-->
        </div>
    </div>
</div>

<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
        <span class="menu-link">
            	<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
														<path
                                                            d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z"
                                                            fill="currentColor"/>
														<path opacity="0.3"
                                                              d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z"
                                                              fill="currentColor"/>
													</svg>
												</span>
                    <!--end::Svg Icon-->
											</span>
											<span class="menu-title">Sugerencias</span>
											<span class="menu-arrow"></span>
        </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('sugerencia.index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                <span class="menu-title">Reclamos</span>
            </a>
            <!--end:Menu link-->
        </div>
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('sugerencia.todas.sugerencias')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                <span class="menu-title">Sugerencias</span>
            </a>
            <!--end:Menu link-->
        </div>
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('sugerencia.felicitaciones')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                <span class="menu-title">Felicitaciones</span>
            </a>
            <!--end:Menu link-->
        </div>
    </div>
</div>

<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
        <span class="menu-link">
            	<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
														<path
                                                            d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z"
                                                            fill="currentColor"/>
														<path opacity="0.3"
                                                              d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z"
                                                              fill="currentColor"/>
													</svg>
												</span>
                    <!--end::Svg Icon-->
											</span>
											<span class="menu-title">Tramites</span>
											<span class="menu-arrow"></span>
        </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('tramite.index')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                <span class="menu-title">Ingreso Licencia Medicas</span>
            </a>
            <!--end:Menu link-->
        </div>
    </div>
</div>

<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
        <span class="menu-link">
            	<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
														<path
                                                            d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z"
                                                            fill="currentColor"/>
														<path opacity="0.3"
                                                              d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z"
                                                              fill="currentColor"/>
													</svg>
												</span>
                    <!--end::Svg Icon-->
											</span>
											<span class="menu-title">Configuración</span>
											<span class="menu-arrow"></span>
        </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('tramite.index')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                <span class="menu-title">Calendario</span>
            </a>
            <!--end:Menu link-->
        </div>
    </div>
</div>


