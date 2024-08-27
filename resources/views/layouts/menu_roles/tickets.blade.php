<div class="menu-item pt-5">
    <!--begin:Menu content-->
    <div class="menu-content">
        <span class="menu-heading fw-bold text-uppercase fs-7">Ticket</span>
    </div>
    <!--end:Menu content-->
</div>

<!--begin:Menu item-->
<div class="menu-item">
    <!--begin:Menu link-->
    <a class="menu-link {{ Request::is('home') ? 'active' : '' }}" href="{{route('ticket.index')}}">
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
        <span class="menu-title">Lista de tickets</span>
    </a>
    <!--end:Menu link-->
</div>
<!--end:Menu item-->
