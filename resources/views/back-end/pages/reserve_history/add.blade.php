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
                                    <h2 class="text-center mb-4 text-dark">เพิ่มข้อมูลการจอง</h2>
                                    <div class="shadow-lg p-4 bg-body-tertiary rounded">
                                        <form action="{{ route('reserve_history.insert') }}" method="POST">
                                            @csrf
                                            <!-- Section: ข้อมูลการจอง -->
                                            <h4 class="mb-4 text-primary">ข้อมูลการจอง</h4>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="name" class="form-label">ชื่อ-นามสกุล</label>
                                                    <input type="text" class="form-control" id="name"
                                                        name="name" placeholder="กรอกชื่อ-นามสกุล" required>
                                                </div>

                                                <div class="col-md-6 position-relative">
                                                    <label for="now_date" class="form-label">วันที่จ่ายเงิน</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control datepicker"
                                                            id="now_date" name="now_date" required>
                                                        <span class="input-group-text"><i
                                                                class="bi bi-calendar3"></i></span>
                                                    </div>

                                                </div>
                                                <div class="col-md-6 position-relative">
                                                    <label for="first_date" class="form-label">วันแรกของการจอง</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control datepicker"
                                                            id="first_date" name="first_date" required>
                                                        <span class="input-group-text"><i
                                                                class="bi bi-calendar3"></i></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 position-relative">
                                                    <label for="last_date"
                                                        class="form-label">วันสุดท้ายของการจอง</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control datepicker"
                                                            id="last_date" name="last_date" required>
                                                        <span class="input-group-text"><i
                                                                class="bi bi-calendar3"></i></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="status" class="form-label">สถานะ</label>
                                                    <select class="form-select" id="status" name="status" required>
                                                        <option value="จ่ายแล้ว">จ่ายแล้ว</option>
                                                        <option value="ยังไม่จ่าย">ยังไม่จ่าย</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label for="product_type" class="form-label">ประเภทสินค้า</label>
                                                    <input type="text" class="form-control" id="product_type"
                                                        name="product_type" placeholder="กรอกประเภทสินค้า" required>
                                                </div>
                                            </div>

                                            <!-- Section: ข้อมูลพื้นที่ -->
                                            <h4 class="mt-5 mb-4 text-primary">ข้อมูลพื้นที่</h4>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="type" class="form-label">รูปแบบพื้นที่</label>
                                                    <select class="form-select" id="type" name="type" required>
                                                        <option value="" disabled selected>-- เลือกรูปแบบพื้นที่
                                                            --</option>
                                                        <option value="รูปแบบที่1">รูปแบบที่1</option>
                                                        <option value="รูปแบบที่2">รูปแบบที่2</option>
                                                        <option value="รูปแบบที่3">รูปแบบที่3</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="area" class="form-label">พื้นที่</label>
                                                    <select class="form-select" id="area" name="area"
                                                        required>
                                                        <option value="" disabled selected>-- เลือกพื้นที่ --
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="price" class="form-label">ราคา</label>
                                                    <input type="text" id="price" class="form-control"
                                                        name="price" readonly>
                                                </div>
                                                <div class="col-md-6 text-center">
                                                    <label for="pic_area" class="form-label"></label>
                                                    <img id="pic_area_display" src="" alt="รูปภาพพื้นที่"
                                                        class="img-fluid border"
                                                        style="width: 80%; max-width: 150px; display: none;">
                                                </div>
                                            </div>

                                            <!-- Section: ปุ่ม -->
                                            <div class="text-center mt-4">
                                                <button type="submit" class="btn btn-primary">บันทึก</button>
                                                <a href="{{ route('reserve_history.index') }}"
                                                    class="btn btn-secondary">ยกเลิก</a>
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
    $(document).ready(function() {
        // เมื่อเลือก type
        $('#type').change(function() {
            var type = $(this).val();
            if (type) {
                // ส่งคำขอ AJAX เพื่อดึงข้อมูล area ตาม type
                $.ajax({
                    url: "{{ route('reserve_history.getAreaData') }}",
                    type: "GET",
                    data: {
                        type: type
                    },
                    success: function(data) {
                        // อัปเดตตัวเลือกพื้นที่
                        $('#area').html(
                            '<option value="" disabled selected>-- เลือกพื้นที่ --</option>'
                        );
                        $.each(data.areas, function(key, area) {
                            $('#area').append('<option value="' + area.area + '">' +
                                area.area + '</option>');
                        });

                        // ซ่อนรูปภาพและล้างราคา (เริ่มใหม่)
                        $('#pic_area_display').hide().attr('src', '');
                        $('#price').val('');
                    }
                });
            } else {
                // ล้าง Dropdown และค่าที่แสดง
                $('#area').html('<option value="" disabled selected>-- เลือกพื้นที่ --</option>');
                $('#pic_area_display').hide().attr('src', '');
                $('#price').val('');
            }
        });

        // เมื่อเลือก area
        $('#area').change(function() {
            var area = $(this).val();
            if (area) {
                // ส่งคำขอ AJAX เพื่อดึงรูปภาพและราคาตาม area
                $.ajax({
                    url: "{{ route('reserve_history.getAreaData') }}",
                    type: "GET",
                    data: {
                        area: area
                    },
                    success: function(data) {
                        // แสดงรูปภาพ
                        $('#pic_area_display').attr('src', data.pic_area).show();

                        // แสดงราคา
                        $('#price').val(data.price);
                    },
                    error: function() {
                        // ล้างค่าหากเกิดข้อผิดพลาด
                        $('#pic_area_display').hide().attr('src', '');
                        $('#price').val('');
                    }
                });
            } else {
                // ล้างค่าหากไม่มีการเลือกพื้นที่
                $('#pic_area_display').hide().attr('src', '');
                $('#price').val('');
            }
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('.datepicker', {
            dateFormat: 'Y-m-d', // กำหนดรูปแบบวันที่
        });
    });
</script>
