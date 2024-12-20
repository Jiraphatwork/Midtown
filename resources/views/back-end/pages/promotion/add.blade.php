<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    @include("$prefix.layout.head")
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true"
    data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true"
    data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
    class="app-default">
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            <div id="kt_app_header" class="app-header" data-kt-sticky="true"
                data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
                data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
                @include("$prefix.layout.head-menu")
            </div>
            <!--end::Header-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">

                <!--begin::Sidebar-->
                @include("$prefix.layout.side-menu")
                <!--end::Sidebar-->

                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">

                                <div class="container mt-5">
                                    <h2 class="text-center mb-4 text-dark">เพิ่มข้อมูลโปรโมชั่น</h2>
                                    <div class="shadow-lg p-4 bg-body-tertiary rounded">
                                        <form action="{{ route('promotion.insert') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name_promotion" class="form-label">ชื่อโปรโมชั่น</label>
                                                <input type="text" class="form-control" id="name_promotion" name="name_promotion" placeholder="กรอกชื่อโปรโมชั่น" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pic_promotion" class="form-label">รูปโปรโมชั่น</label>
                                                <input type="file" class="form-control" id="pic_promotion" name="pic_promotion" accept="image/*" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="detail" class="form-label">รายละเอียด</label>
                                                <input type="text" class="form-control" id="detail" name="detail" placeholder="กรอกรายละเอียด" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="first_date" class="form-label">วันเริ่มต้นโปรโมชั่น</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control datepicker" id="first_date" name="first_date" required>
                                                    <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="last_date" class="form-label">วันสิ้นสุดโปรโมชั่น</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control datepicker" id="last_date" name="last_date" required>
                                                    <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                                </div>
                                            </div>
                                        
                                            <!-- ปุ่มบันทึกและยกเลิก -->
                                            <div class="text-center mt-4">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa-solid fa-save"></i> บันทึก
                                                </button>
                                                
                                                <a href="{{ route('promotion.index') }}" class="btn btn-secondary">
                                                    <i class="fa-solid fa-circle-xmark"></i> ยกเลิก
                                                </a>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!--begin::Content container-->
                    <div id="kt_app_content_container" class="app-container container-xxl">

                    </div>
                    <!--end::Content container-->
                </div>

            </div>
            <!--end::Content wrapper-->

            <!--begin::Footer-->
            <div id="kt_app_footer" class="app-footer">
                @include("$prefix.layout.footer")
            </div>
            <!--End::Footer-->
        </div>
        <!--End::Main-->
    </div>
    </div>
    </div>

    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>

    <!--begin::Javascript-->
    @include("$prefix.layout.script")
    <!--end::Javascript-->

</body>
<!--end::Body-->

</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('.datepicker', {
            dateFormat: 'Y-m-d', // กำหนดรูปแบบวันที่
        });
    });
</script>
@if (session('success'))
    <script>
        console.log("Success Message: {{ session('success') }}"); // ตรวจสอบค่าที่ส่งมา
        Swal.fire({
            title: 'สำเร็จ!',
            text: "{{ session('success') }}",
            icon: 'success',
            timer: 2000,
            showConfirmButton: false,
        });
    </script>
@endif

@if (session('error'))
    <script>
        console.log("Error Message: {{ session('error') }}"); // ตรวจสอบค่าที่ส่งมา
        Swal.fire({
            title: 'ข้อผิดพลาด!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'ตกลง'
        });
    </script>
@endif

