<!--begin:Menu item-->
<div class="menu-item pt-5">
    <!--begin:Menu content-->
    <div class="menu-content">
        <span class="menu-heading fw-bold text-uppercase fs-7">CheckList</span>
    </div>
    <!--end:Menu content-->
</div>
@role('admin|Jefe Control Calidad')
<!--begin:Menu item-->
<div class="menu-item">
    <!--begin:Menu link-->
    <a class="menu-link {{ Request::is('dashboard.calidad') ? 'active' : '' }}"
       href="{{route('dashboard.calidad')}}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs014.svg-->
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
														<rect x="2" y="2" width="9" height="9" rx="2"
                                                              fill="currentColor"/>
														<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2"
                                                              fill="currentColor"/>
														<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2"
                                                              fill="currentColor"/>
														<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2"
                                                              fill="currentColor"/>
													</svg>
												</span>
                                                <!--end::Svg Icon-->
                                                <!--end::Svg Icon-->
											</span>
        <span class="menu-title">INICIO</span>
    </a>
    <!--end:Menu link-->
</div>
@endrole
<!--end:Menu item-->
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
											<span class="menu-title">CheckList Calidad</span>
											<span class="menu-arrow"></span>
										</span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('calidad.create')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                <span class="menu-title">Nuevo Checklist Calidad</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('calidad.index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                <span class="menu-title">Lista Checklist Calidad</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->

        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('item-reported.index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                <span class="menu-title">Item Reincidencias</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->


        @role('admin')
        <!--end:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('checklist.index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                <span class="menu-title">Configuración</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        @endrole
    </div>
    <!--end:Menu sub-->

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
											<span class="menu-title">Mis Ticket</span>
											<span class="menu-arrow"></span>
										</span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('ticket.index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                <span class="menu-title">Lista de Ticket</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->



    </div>
    <!--end:Menu sub-->

</div>
