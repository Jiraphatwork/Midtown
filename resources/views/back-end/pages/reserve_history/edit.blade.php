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
                                    <h2 class="text-center mb-4">แก้ไขข้อมูลการจอง</h2>
                                    <div class="shadow-lg p-4 bg-body-tertiary rounded">
                                        <form action="{{ route('reserve_history.update', $history->id) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')

                                            <!-- Section: ข้อมูลการจอง -->
                                            <h4 class="mb-4 text-primary">ข้อมูลการจอง</h4>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="name" class="form-label">ชื่อ-นามสกุล</label>
                                                    <input type="text" class="form-control" id="name"
                                                        name="name" value="{{ old('name', $history->name) }}"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="now_date" class="form-label">วันที่จ่ายเงิน</label>
                                                    <input type="date" class="form-control" id="now_date"
                                                        name="now_date"
                                                        value="{{ old('now_date', \Carbon\Carbon::parse($history->now_date)->format('Y-m-d')) }}"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="first_date" class="form-label">วันแรกของการจอง</label>
                                                    <input type="date" class="form-control" id="first_date"
                                                        name="first_date"
                                                        value="{{ old('first_date', \Carbon\Carbon::parse($history->first_date)->format('Y-m-d')) }}"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="last_date"
                                                        class="form-label">วันสุดท้ายของการจอง</label>
                                                    <input type="date" class="form-control" id="last_date"
                                                        name="last_date"
                                                        value="{{ old('last_date', \Carbon\Carbon::parse($history->last_date)->format('Y-m-d')) }}"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="status" class="form-label">สถานะ</label>
                                                    <select class="form-select" id="status" name="status" required>
                                                        <option value="จ่ายแล้ว"
                                                            {{ old('status', $history->status) == 'จ่ายแล้ว' ? 'selected' : '' }}>
                                                            จ่ายแล้ว</option>
                                                        <option value="ยังไม่จ่าย"
                                                            {{ old('status', $history->status) == 'ยังไม่จ่าย' ? 'selected' : '' }}>
                                                            ยังไม่จ่าย</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="product_type" class="form-label">ประเภทสินค้า</label>
                                                    <input type="text" class="form-control" id="product_type"
                                                        name="product_type"
                                                        value="{{ old('product_type', $history->product_type) }}"
                                                        required>
                                                </div>
                                            </div>

                                            <!-- Section: ข้อมูลพื้นที่ -->
                                            <h4 class="mt-5 mb-4 text-primary">ข้อมูลพื้นที่</h4>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="type" class="form-label">รูปแบบพื้นที่</label>
                                                    <select class="form-select" id="type" name="type" required>
                                                        <option value="รูปแบบที่1"
                                                            {{ old('type', $history->type) == 'รูปแบบที่1' ? 'selected' : '' }}>
                                                            รูปแบบที่1</option>
                                                        <option value="รูปแบบที่2"
                                                            {{ old('type', $history->type) == 'รูปแบบที่2' ? 'selected' : '' }}>
                                                            รูปแบบที่2</option>
                                                        <option value="รูปแบบที่3"
                                                            {{ old('type', $history->type) == 'รูปแบบที่3' ? 'selected' : '' }}>
                                                            รูปแบบที่3</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="area" class="form-label">พื้นที่</label>
                                                    <select class="form-select" id="area" name="area"
                                                        required>
                                                        <option value="" disabled selected>-- เลือกพื้นที่ --
                                                        </option>
                                                        @foreach ($areas as $area)
                                                            <option value="{{ $area->area }}"
                                                                {{ old('area', $history->area) == $area->area ? 'selected' : '' }}>
                                                                {{ $area->area }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="price" class="form-label">ราคา</label>
                                                    <input type="text" id="price" class="form-control"
                                                        name="price" value="{{ old('price', $history->price) }}"
                                                        readonly>
                                                </div>
                                                <div class="col-md-6 ">
                                                    <label for="pic_area" class="form-label">รูปภาพพื้นที่</label>
                                                    <img id="pic_area_display"
                                                        src="{{ asset('pic_areas_reserve/' . $history->pic_area) }}"
                                                        alt="รูปภาพพื้นที่" class="img-fluid border"
                                                        style="width: 100%; max-width: 200px; display: block;">
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
        // ฟังก์ชันสำหรับโหลด area ตาม type เมื่อเริ่มต้น
        function loadAreasByType(type, selectedArea) {
            if (type) {
                console.log("Fetching areas for type: ", type); // ตรวจสอบ type ที่ส่งไป
                $.ajax({
                    url: "{{ route('reserve_history.getAreaData') }}",
                    type: "GET",
                    data: {
                        type: type
                    },
                    success: function(data) {
                        console.log("Received data: ", data); // ดูข้อมูลที่ได้รับ
                        $('#area').html(
                            '<option value="" disabled selected>-- เลือกพื้นที่ --</option>');
                        $.each(data.areas, function(key, area) {
                            $('#area').append('<option value="' + area.area + '"' +
                                (area.area === selectedArea ? ' selected' : '') + '>' +
                                area.area + '</option>');
                        });
                    },
                    error: function(err) {
                        console.error("Error fetching areas: ", err); // แสดงข้อผิดพลาด
                        $('#area').html(
                            '<option value="" disabled selected>-- เลือกพื้นที่ --</option>');
                    }
                });
            } else {
                console.warn("Type is empty, resetting area dropdown.");
                $('#area').html('<option value="" disabled selected>-- เลือกพื้นที่ --</option>');
            }
        }

        // โหลด area ทันทีที่เปิดหน้า edit
        var currentType = $('#type').val(); // ค่า type ปัจจุบัน
        var currentArea = "{{ $history->area }}"; // ค่า area ปัจจุบัน
        loadAreasByType(currentType, currentArea);

        // เมื่อ type เปลี่ยน
        $('#type').change(function() {
            var type = $(this).val();
            loadAreasByType(type, null); // โหลดพื้นที่ใหม่ โดยไม่เลือกค่าเริ่มต้น
            // รีเซ็ตรูปภาพและราคา
            $('#pic_area_display').hide().attr('src', '');
            $('#price').val('');
        });

        // เมื่อ area เปลี่ยน
        $('#area').change(function() {
            var area = $(this).val();
            if (area) {
                // ส่งคำขอ AJAX เพื่อดึงข้อมูลรูปภาพและราคา
                $.ajax({
                    url: "{{ route('reserve_history.getAreaData') }}",
                    type: "GET",
                    data: {
                        area: area
                    },
                    success: function(data) {
                        // แสดงรูปภาพและราคา
                        $('#pic_area_display').attr('src', data.pic_area).show();
                        $('#price').val(data.price);
                    },
                    error: function() {
                        // รีเซ็ตค่าหากเกิดข้อผิดพลาด
                        $('#pic_area_display').hide().attr('src', '');
                        $('#price').val('');
                    }
                });
            } else {
                // รีเซ็ตค่าหากไม่มีการเลือก
                $('#pic_area_display').hide().attr('src', '');
                $('#price').val('');
            }
        });
    });
</script>
