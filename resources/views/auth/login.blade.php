@extends('auth.app')
@section('content')
<!--<div class="form-container" id="app">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <login-component></login-component>
            </div>
        </div>
    </div>
    <div class="form-image">
        <div class="l-image">
        </div>
    </div>
</div>-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Authentication - Sign-in -->
    <div id="app" class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Body-->
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
            <!--begin::Form-->
            <login-component></login-component>
            <!--end::Form-->
            <!--begin::Footer-->
            <div class="d-flex flex-center flex-wrap px-5">
                <!--begin::Links-->
                <!--<div class="d-flex fw-semibold text-primary fs-base">
                    <a href="../../demo1/dist/pages/team.html" class="px-5" target="_blank">Terms</a>
                    <a href="../../demo1/dist/pages/pricing/column.html" class="px-5" target="_blank">Plans</a>
                    <a href="../../demo1/dist/pages/contact.html" class="px-5" target="_blank">Contact Us</a>
                </div>-->
                <!--end::Links-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Body-->
        <!--begin::Aside-->
        <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url(images/fondo.jpg)">
            <!--begin::Content-->

            <!--end::Content-->
        </div>
        <!--end::Aside-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->

@endsection

