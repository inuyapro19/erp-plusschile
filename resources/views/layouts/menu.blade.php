<!--begin:Menu item-->
<div class="menu-item">
    <!--begin:Menu link-->
    <a class="menu-link {{ Request::is('home') ? 'active' : '' }}" href="{{route('home')}}">
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
<!--end:Menu item-->


@role('admin')


@include('layouts.menu_roles.admin')

@endrole

@role('jefe de rrhh|asistente de rrhh')
@include('layouts.menu_roles.rrhh')
@endrole

@role('trabajador')
    @include('layouts.menu_roles.trabajador')
@endrole

@role('operaciones')
@include('layouts.menu_roles.operaciones')
@endrole

@role('agente de ventas')
@include('layouts.menu_roles.ventas')
@endrole

@role('secretaria')
    @include('layouts.menu_roles.secretaria')
@endrole

@role('admin|rrhh')
@include('layouts.menu_roles.sistema')
@endrole

@role(config('roles.checklist_roles'))
<!-- Your code here -->
@include('layouts.menu_roles.checklist')
@endrole

@role(config('roles.checklist_roles_prevencion'))
<!-- Your code here -->
@include('layouts.menu_roles.checklist_prevension')
@endrole
