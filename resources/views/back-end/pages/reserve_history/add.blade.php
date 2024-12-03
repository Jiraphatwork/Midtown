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
                                            <div class="mb-3">
                                                <label for="name" class="form-label">ชื่อ-นามสกุล</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="กรอกชื่อ-นามสกุล" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="now_date" class="form-label">วันที่จ่ายเงิน</label>
                                                <input type="date" class="form-control" id="now_date"
                                                    name="now_date" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="first_date" class="form-label">วันแรกของการจอง</label>
                                                <input type="date" class="form-control" id="first_date"
                                                    name="first_date" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="last_date" class="form-label">วันสุดท้ายของการจอง</label>
                                                <input type="date" class="form-control" id="last_date"
                                                    name="last_date" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="status" class="form-label">สถานะ</label>
                                                <select class="form-select" id="status" name="status" required>
                                                    <option value="จ่ายแล้ว">จ่ายแล้ว</option>
                                                    <option value="ยังไม่จ่าย">ยังไม่จ่าย</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="product_type" class="form-label">ประเภทสินค้า</label>
                                                <input type="text" class="form-control" id="product_type"
                                                    name="product_type" placeholder="กรอกประเภทสินค้า" required>
                                            </div>
                                            <!-- รูปแบบพื้นที่ -->
                                            <div class="mb-3">
                                                <label for="type" class="form-label">รูปแบบพื้นที่</label>
                                                <select class="form-select" id="type" name="type" required>
                                                    <option value="" disabled selected>-- เลือกรูปแบบพื้นที่ --
                                                    </option>
                                                    <option value="รูปแบบที่1">รูปแบบที่1</option>
                                                    <option value="รูปแบบที่2">รูปแบบที่2</option>
                                                    <option value="รูปแบบที่3">รูปแบบที่3</option>
                                                </select>
                                            </div>

                                            <!-- พื้นที่ (ตาม type) -->
                                            <div class="mb-3">
                                                <label for="area" class="form-label">พื้นที่</label>
                                                <select class="form-select" id="area" name="area" required>
                                                    <option value="" disabled selected>-- เลือกพื้นที่ --</option>
                                                    <!-- Dynamic area options will be populated here based on type selection -->
                                                </select>
                                            </div>

                                            <!-- รูปภาพพื้นที่ -->
                                            <div class="mb-3">
                                                <label for="pic_area" class="form-label">รูปพื้นที่</label>
                                                <img id="pic_area_display" src="" alt="รูปภาพพื้นที่"
                                                    class="img-fluid" style="width: 40%";">
                                            </div>

                                            <!-- ราคา -->
                                            <div class="mb-3">
                                                <label for="price" class="form-label">ราคา</label>
                                                <input type="text" class="form-control" id="price"
                                                    name="price" readonly>
                                            </div>

                                            <div class="text-center">
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
                // ส่งค่า type ไปยัง Controller เพื่อดึงข้อมูล
                $.ajax({
                    url: "{{ route('reserve_history.getAreaData') }}",  // route ของคุณ
                    type: "GET",
                    data: {
                        type: type
                    },
                    success: function(data) {
                        // แสดงข้อมูลพื้นที่ (area)
                        $('#area').html(
                            '<option value="" disabled selected>-- เลือกพื้นที่ --</option>'
                        );
                        $.each(data.areas, function(key, area) {
                            $('#area').append('<option value="' + area.area + '" data-price="' + area.price + '">' +
                                area.area + '</option>');
                        });

                        // แสดงรูปภาพของพื้นที่
                        $('#pic_area_display').attr('src', data.pic_area);
                        $('#pic_area_display').show();
                    }
                });
            } else {
                // ถ้าไม่มีการเลือก type ก็ให้ล้างข้อมูลที่แสดง
                $('#area').html('<option value="" disabled selected>-- เลือกพื้นที่ --</option>');
                $('#pic_area_display').hide();
                $('#price').val('');
            }
        });

        // เมื่อเลือก area
        $('#area').change(function() {
            var selectedArea = $(this).find('option:selected');
            var price = selectedArea.data('price'); // ดึงราคาใน attribute data-price
            $('#price').val(price);  // เปลี่ยนค่าในฟอร์ม price
        });
    });
</script>