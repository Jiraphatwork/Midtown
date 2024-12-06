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
                                    <h2 class="text-center mb-4">แก้ไขข้อมูลติดต่อเรา</h2>
                                    <div class="shadow-lg p-4 bg-body-tertiary rounded">
                                        <form action="{{ route('data_contact.update', $item->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <div class="mb-3">
                                                <label for="map" class="form-label">รูปMap</label>
                                                @if ($item->map)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('maps/' . $item->map) }}" alt="Business Card"
                                                            width="150">
                                                    </div>
                                                @endif
                                                <input type="file" class="form-control" id="map" name="map"
                                                    accept="image/*">
                                                <small class="text-muted">* หากไม่ต้องการเปลี่ยนไฟล์
                                                    ไม่ต้องเลือกไฟล์</small>
                                            </div>


                                            <div class="mb-3">
                                                <label for="address" class="form-label">ที่อยู่</label>
                                                <input type="text" class="form-control" id="address" name="address"
                                                    value="{{ old('address', $item->address) }}"
                                                    placeholder="กรอกที่อยู่">
                                            </div>


                                            <div class="mb-3">
                                                <label for="tel" class="form-label">เบอร์โทร</label>
                                                <input type="text" class="form-control" id="tel" name="tel"
                                                    value="{{ old('tel', $item->tel) }}"
                                                    placeholder="กรอกเบอร์โทร"maxlength="10" oninput="updateLengthTel()"
                                                    onblur="validateTel()">
                                                <span id="charCountTel" class="text-muted"></span>
                                            </div>


                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">บันทึก</button>
                                                <a href="{{ route('data_contact.index') }}"
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
    // ฟังก์ชันสำหรับแสดงจำนวนที่กรอกไปแล้ว
    function updateLengthTel() {
        var input = document.getElementById('tel');
        var charCount = document.getElementById('charCountTel');
        charCount.textContent = `กรอกไปแล้ว ${input.value.length}/10 ตัวอักษร`;
    }

    // ฟังก์ชันตรวจสอบเบอร์โทร
    function validateTel() {
        var tel = document.getElementById('tel');
        var validTel = /^[0-9]{10}$/; // ตรวจสอบว่าเบอร์โทรเป็นตัวเลข 10 หลัก
        var charCount = document.getElementById('charCountTel');

        // แสดงจำนวนตัวอักษรที่กรอกไปแล้ว
        updateLengthTel();

        // ตรวจสอบว่าเบอร์โทรเป็นไปตามรูปแบบที่กำหนดหรือไม่
        if (!validTel.test(tel.value)) {
            tel.setCustomValidity("กรุณากรอกเบอร์โทรที่ถูกต้อง (10 หลัก)");
        } else {
            tel.setCustomValidity(""); // รีเซ็ตข้อความ error
        }
    }
    </script>